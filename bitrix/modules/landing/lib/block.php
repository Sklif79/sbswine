<?php
namespace Bitrix\Landing;

use \Bitrix\Main\Web\Json;
use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Web\DOM;
use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config\Option;
use \Bitrix\Landing\Internals;

Loc::loadMessages(__FILE__);

class Block extends \Bitrix\Landing\Internals\BaseTable
{
	/**
	 * Dir of repoitory of blocks.
	 */
	const BLOCKS_DIR = '/bitrix/blocks';

	/**
	 * Block preview filename (jpg).
	 */
	const PREVIEW_FILE_NAME = 'preview.jpg';

	/**
	 * Life time for mark new block.
	 */
	const NEW_BLOCK_LT = 1209600;//86400 * 14

	/**
	 * Access level: access deined.
	 */
	const ACCESS_D = 'D';

	/**
	 * Access level: edit only design.
	 */
	const ACCESS_V = 'V';

	/**
	 * Access level: edit content and design (not delete).
	 */
	const ACCESS_W = 'W';

	/**
	 * Access level: full access.
	 */
	const ACCESS_X = 'X';

	/**
	 * Internal class.
	 * @var string
	 */
	public static $internalClass = 'BlockTable';

	/**
	 * Id of current block.
	 * @var int
	 */
	protected $id = 0;

	/**
	 * Sort of current block.
	 * @var int
	 */
	protected $sort = 0;

	/**
	 * Is the rest block if > 0.
	 * @var int
	 */
	protected $repoId = 0;

	/**
	 * Code of current block.
	 * @var string
	 */
	protected $code = '';

	/**
	 * Actually content of current block.
	 * @var string
	 */
	protected $content = '';

	/**
	 * Access for this block.
	 * @see ACCESS_* constants.
	 * @var string
	 */
	protected $access = 'X';

	/**
	 * Data row of current block.
	 * @var array
	 */
	protected $data = array();

	/**
	 * Active or not current block.
	 * @var boolean
	 */
	protected $active = false;

	/**
	 * Deleted or not current block.
	 * @var boolean
	 */
	protected $deleted = false;

	/**
	 * Public or not current block.
	 * @var boolean
	 */
	protected $block = false;

	/**
	 * Local path to the block.
	 * @var string
	 */
	protected $path = null;

	/**
	 * Absolutely path to the block.
	 * @var string
	 */
	protected $pathFull = null;

	/**
	 * Instance of Error.
	 * @var \Bitrix\Landing\Error
	 */
	protected $error = null;

	/**
	 * Constructor.
	 * @param int $id Block id.
	 * @param array $data Data row from BlockTable (by default get from DB).
	 */
	public function __construct($id, $data = array())
	{
		if (empty($data) || !is_array($data))
		{
			$data = parent::getList(array(
				'filter' => array(
					'ID' => $id
				)
			))->fetch();
			if (!$data)
			{
				$id = 0;
			}
		}

		$this->id = intval($id);
		$this->sort = isset($data['SORT']) ? intval($data['SORT']) : '';
		$this->code = isset($data['CODE']) ? trim($data['CODE']) : '';
		$this->active = isset($data['ACTIVE']) && $data['ACTIVE'] == 'Y';
		$this->deleted = isset($data['DELETED']) && $data['DELETED'] == 'Y';
		$this->public = isset($data['PUBLIC']) && $data['PUBLIC'] == 'Y';
		$this->content = (!$this->deleted && isset($data['CONTENT']))
						? trim($data['CONTENT']) : '';

		if (isset($data['ACCESS']))
		{
			$this->access = $data['ACCESS'];
		}

		if (preg_match('/repo_([\d]+)/', $this->code, $matches))
		{
			$this->repoId = $matches[1];
		}

		if (!$this->repoId)
		{
			$this->path = self::getBlockPath($this->code);
			$this->pathFull = Manager::getDocRoot() . $this->path;
		}

		$this->error = new Error;
	}

	/**
	 * Fill landing with blocks.
	 * @param \Bitrix\Landing\Landing $landing Landing instance.
	 * @param int $limit Limit count for blocks.
	 * @return boolean
	 */
	public static function fillLanding(\Bitrix\Landing\Landing $landing, $limit = 0)
	{
		if ($landing->exist())
		{
			$editMode = $landing->getEditMode();
			$repo = array();
			$blocks = array();
			// get all blocks by filter
			$res = parent::getList(array(
				'filter' => array(
					'LID' => $landing->getId(),
					'=PUBLIC' => $editMode ? 'N' : 'Y',
					'=DELETED' => 'N'
				),
				'order' => array(
					'SORT' => 'ASC',
					'ID' => 'ASC'
				),
				'limit' => $limit
			));
			while ($row = $res->fetch())
			{
				$block = new self($row['ID'], $row);
				if (!$editMode && $block->getRepoId())
				{
					$repo[] = $block->getRepoId();
				}
				$blocks[$row['ID']] = $block;
			}
			if (!empty($repo))
			{
				$repo = Repo::getAppInfo($repo);
			}
			// add blocks to landing
			foreach ($blocks as $block)
			{
				$reposInfo = isset($repo[$block->getRepoId()])
							? $repo[$block->getRepoId()]
							: array();
				if ($editMode || !$reposInfo)
				{
					$landing->addBlockToCollection($block);
				}
				elseif (
					isset($reposInfo['PAYMENT_ALLOW']) &&
					$reposInfo['PAYMENT_ALLOW'] == 'Y'
				)
				{
					$landing->addBlockToCollection($block);
				}
			}
			return true;
		}

		return false;
	}

	/**
	 * Create copy of blocks for draft version.
	 * @param \Bitrix\Landing\Landing $landing Landing instance.
	 * @return void
	 */
	public static function cloneForEdit(\Bitrix\Landing\Landing $landing)
	{
		if ($landing->exist())
		{
			$clone = true;
			$forClone = array();

			$res = parent::getList(array(
				'select' => array(
					'ID', 'LID', 'CODE', 'SORT', 'ACTIVE',
					'CONTENT', 'PUBLIC', 'ACCESS'
				),
				'filter' => array(
					'LID' => $landing->getId()
				)
			));
			while ($row = $res->fetch())
			{
				if ($row['PUBLIC'] != 'Y')
				{
					$clone = false;
					break;
				}
				else
				{
					$row['PUBLIC'] = 'N';
					$row['PARENT_ID'] = $row['ID'];
					unset($row['ID']);
					$forClone[] = $row;
				}
			}

			if ($clone)
			{
				foreach ($forClone as $row)
				{
					parent::add($row);
				}
			}
		}
	}

	/**
	 * Publication blocks for landing.
	 * @param \Bitrix\Landing\Landing $landing Landing instance.
	 * @return void
	 */
	public static function publicationBlocks(\Bitrix\Landing\Landing $landing)
	{
		if ($landing->exist())
		{
			$lid = $landing->getId();
			$blocks = array();
			$linkReplace = array();
			$draftToPublic = array();
			$linkPattern = '/"#block([\d]+)"/is';

			$res = parent::getList(array(
				'select' => array(
					'ID', 'PUBLIC', 'PARENT_ID',
					'CODE', 'SORT', 'ACTIVE',
					'ACCESS', 'CONTENT'
				),
				'filter' => array(
					'LID' => $landing->getId(),
					'=DELETED' => 'N'
				)
			));
			while ($row = $res->fetch())
			{
				//@tmp fix
				if (strpos($row['CODE'], '0.menu') === 0)
				{
					$row['SORT'] = -100;
				}
				$blocks[$row['ID']] = $row;
			}

			// create new block, update exist
			foreach ($blocks as $id => $block)
			{
				if ($block['PUBLIC'] != 'Y')
				{
					$parentId = isset($blocks[$block['PARENT_ID']])
								? $blocks[$block['PARENT_ID']]['ID']
								: 0;
					if ($parentId)
					{
						parent::update($parentId, array(
							'SORT' => $block['SORT'],
							'ACTIVE' => $block['ACTIVE'],
							'ACCESS' => $block['ACCESS'],
							'CONTENT' => $block['CONTENT']
						));
						unset($blocks[$block['PARENT_ID']]);
						// clone files
						File::replaceInBlock(
							$parentId,
							File::getFilesFromBlockContent(
								$id, $block['CONTENT']
							)
						);
					}
					else
					{
						$res = parent::add(array(
							'LID' => $lid,
							'CODE' => $block['CODE'],
							'SORT' => $block['SORT'],
							'ACTIVE' => $block['ACTIVE'],
							'ACCESS' => $block['ACCESS'],
							'CONTENT' => $block['CONTENT']
						));
						if ($res->isSuccess())
						{
							$parentId = $res->getId();
							parent::update($id, array(
								'PARENT_ID' => $parentId
							));
							// clone files
							File::addToBlock(
								$parentId,
								File::getFilesFromBlockContent(
									$id, $block['CONTENT']
								)
							);
						}
					}
					if (preg_match($linkPattern, $block['CONTENT']))
					{
						$linkReplace[$parentId] = $block['CONTENT'];
					}
					$draftToPublic[$id] = $parentId;
					unset($blocks[$id]);
				}
			}

			// delete blocks, which deleted in draft
			foreach ($blocks as $id => $block)
			{
				self::parentDelete($id);
			}

			// replace draft link to public (inner blocks)
			foreach ($linkReplace as $id => $content)
			{
				$content = preg_replace_callback(
					$linkPattern,
					function($match) use ($draftToPublic)
					{
						return '"#block' . $draftToPublic[$match[1]] . '"';
					},
					$content);
				parent::update($id, array(
					'CONTENT' => $content
				));
			}
		}
	}

	/**
	 * Recognize landing id by block id.
	 * @param int|array $id Block id (id array).
	 * @return int|array|false
	 */
	public static function getLandingIdByBlockId($id)
	{
		$data = array();
		$res = parent::getList(array(
			'select' => array(
				'ID', 'LID'
			),
			'filter' => array(
				'ID' => $id
			)
		));
		while ($row = $res->fetch())
		{
			$data[$row['ID']] = $row['LID'];
		}

		if (is_array($id))
		{
			return $data;
		}
		elseif (!empty($data))
		{
			return array_pop($data);
		}

		return false;
	}

	/**
	 * Create instance by string code.
	 * @param \Bitrix\Landing\Landing $landing Landing - owner for new block.
	 * @param string $code Code of block from repository.
	 * @param array $data Additional data array.
	 * @return Block|false
	 */
	public static function createFromRepository(\Bitrix\Landing\Landing $landing, $code, $data = array())
	{
		// get content
		$content = '';
		// local repo
		if (preg_match('/repo_([\d]+)/', $code, $matches))
		{
			$repo = Repo::getById($matches[1])->fetch();
			$content = $repo['CONTENT'];
		}
		// files storage
		elseif (($path = self::getBlockPath($code)))
		{
			$path = Manager::getDocRoot() . $path . '/block.php';
			if (file_exists($path))
			{
				$content = file_get_contents($path);
			}
		}
		// check errors
		if (!$landing->exist())
		{
			$landing->getError()->addError(
				'LANDING_NOT_EXIST',
				Loc::getMessage('LANDING_BLOCK_LANDING_NOT_EXIST')
			);
			return false;
		}
		if ($content == '')
		{
			$landing->getError()->addError(
				'BLOCK_NOT_FOUND',
				Loc::getMessage('LANDING_BLOCK_NOT_FOUND')
			);
			return false;
		}
		// add
		$fields = array(
			'LID' => $landing->getId(),
			'CODE' => $code,
			'CONTENT' => $content,
			'ACTIVE' => 'Y'
		);
		$availableReplace = array(
			'ACTIVE', 'PUBLIC', 'ACCESS', 'SORT', 'CONTENT'
		);
		foreach ($availableReplace as $replace)
		{
			if (isset($data[$replace]))
			{
				$fields[$replace] = $data[$replace];
			}
		}
		$res = parent::add($fields);
		if ($res->isSuccess())
		{
			$block = new self($res->getId());
			$manifest = $block->getManifest();
			if (
				isset($manifest['callbacks']['afteradd']) &&
				is_callable($manifest['callbacks']['afteradd'])
			)
			{
				$manifest['callbacks']['afteradd']($block);
			}
			return $block;
		}
		else
		{
			$landing->getError()->addFromResult($res);
			return false;
		}
	}

	/**
	 * New or not the block.
	 * @param string $block Block code.
	 * @return boolean
	 */
	protected static function isNewBlock($block)
	{
		static $newBlocks = null;

		if ($newBlocks === null)
		{
			$newBlocks = unserialize(Option::get('landing', 'new_blocks'));
			if (!is_array($newBlocks))
			{
				$newBlocks = array();
			}
			if (
				!isset($newBlocks['date']) ||
				(
					isset($newBlocks['date']) &&
					((time() - $newBlocks['date']) > self::NEW_BLOCK_LT)
				)
			)
			{
				$newBlocks = array();
			}
			if (isset($newBlocks['items']))
			{
				$newBlocks = $newBlocks['items'];
			}
		}

		return in_array($block, $newBlocks);
	}

	/**
	 * Clear cache repository.
	 * @return void
	 */
	public static function clearRepositoryCache()
	{
		if (defined('BX_COMP_MANAGED_CACHE'))
		{
			Manager::getCacheManager()->clearByTag('blocks');
		}
	}

	/**
	 * Get blocks from repository.
	 * @return array
	 */
	public static function getRepository()
	{
		static $blocksCats = array();

		// static cache
		if (!empty($blocksCats))
		{
			return $blocksCats;
		}

		// local function for fill last used blocks
		$fillLastUsed = function($blocksCats)
		{
			$lastUsed = self::getLastUsed();
			if ($lastUsed)
			{
				foreach ($lastUsed as $code)
				{
					$blocksCats['last']['items'][$code] = array();
				}
				foreach ($blocksCats as &$cat)
				{
					foreach ($cat['items'] as $code => &$block)
					{
						if (in_array($code, $lastUsed))
						{
							$block['section'][] = 'last';
							$blocksCats['last']['items'][$code] = $block;
						}
					}
					unset($block);
				}
				unset($cat);
			}
			return $blocksCats;
		};

		// system cache begin
		$cache = new \CPHPCache();
		$cacheTime = 8640000;
		$cacheStarted = false;
		$cacheId = 'blocks';
		$cachePath = 'landing';
		if ($cache->initCache($cacheTime, $cacheId, $cachePath))
		{
			$blocksCats = $cache->getVars();
			if (is_array($blocksCats) && !empty($blocksCats))
			{
				return $fillLastUsed($blocksCats);
			}
		}
		if ($cache->startDataCache($cacheTime, $cacheId, $cachePath))
		{
			$cacheStarted = true;
			if (defined('BX_COMP_MANAGED_CACHE'))
			{
				Manager::getCacheManager()->startTagCache($cachePath);
				Manager::getCacheManager()->registerTag('blocks');
			}
		}

		// not in cache - init
		$blocks = array();
		$sections = array();
		$path = Manager::getDocRoot() . self::BLOCKS_DIR;

		// read all subdirs ($namespaces) in block dir
		$namespaces = array();
		if (($handle = opendir($path)))
		{
			while ((($entry = readdir($handle)) !== false))
			{
				if (
					$entry != '.' && $entry != '..' &&
					is_dir($path . '/' . $entry)
				)
				{
					$namespaces[] = $entry;
				}
			}
		}

		//get all blocks with description-file
		sort($namespaces);
		foreach ($namespaces as $subdir)
		{
			if (($handle = opendir($path . '/' . $subdir)))
			{
				// sections
				$sectionsPath = $path . '/' . $subdir . '/.sections.php';
				if (file_exists($sectionsPath))
				{
					$sections = array_merge(
						$sections,
						(array) include $sectionsPath
					);
				}
				// blocks
				while ((($entry = readdir($handle)) !== false))
				{
					$descriptionPath = $path . '/' . $subdir . '/' . $entry . '/.description.php';
					$previewPathJpg = $path . '/' . $subdir . '/' . $entry . '/' . self::PREVIEW_FILE_NAME;
					if ($entry != '.' && $entry != '..' && file_exists($descriptionPath))
					{
						Loc::loadLanguageFile($descriptionPath);
						$description = include $descriptionPath;
						if (isset($description['block']['name']))
						{
							$blocks[$entry] = array(
								'name' => $description['block']['name'],
								'namespace' => $subdir,
								'new' => self::isNewBlock($entry),
								'type' => isset($description['block']['type'])
												? $description['block']['type']
												: array(),
								'section' => isset($description['block']['section'])
												? $description['block']['section']
												: 'other',
								'description' => isset($description['block']['description'])
												? $description['block']['description']
												: '',
								'preview' => file_exists($previewPathJpg)
												? self::BLOCKS_DIR . '/' . $subdir . '/' . $entry . '/' . self::PREVIEW_FILE_NAME
												: '',
								'restricted' => false,
								'repo_id' => false,
								'app_code' => false
							);
						}
					}
				}
			}
		}

		// rest repo
		$blocksRepo = \Bitrix\Landing\Repo::getRepository();
		// get apps by blocks
		$apps = array();
		foreach ($blocksRepo as $block)
		{
			if ($block['app_code'])
			{
				$apps[] = $block['app_code'];
			}
		}
		if ($apps)
		{
			$apps = Repo::getAppByCode($apps);
			// mark repo blocks expired
			foreach ($blocksRepo as &$block)
			{
				if (
					$block['app_code'] &&
					isset($apps[$block['app_code']]) &&
					$apps[$block['app_code']]['PAYMENT_ALLOW'] == 'N'
				)
				{
					$block['app_expired'] = true;
				}
			}
			unset($block);
		}
		$blocks += $blocksRepo;

		// set by sections
		foreach ($sections as $code => $title)
		{
			$blocksCats[$code] = array(
				'name' => $title,
				'new' => false,
				'separator' => false,
				'app_code' => false,
				'items' => array()
			);
		}
		foreach ($blocks as $key => $block)
		{
			if (!is_array($block['section']))
			{
				$block['section'] = array($block['section']);
			}
			foreach ($block['section'] as $section)
			{
				$section = trim($section);
				if (!isset($blocksCats[$section]))
				{
					$section = 'other';
				}
				$blocksCats[$section]['items'][$key] = $block;
				if ($block['new'])
				{
					$blocksCats[$section]['new'] = true;
				}
			}
		}

		// add apps sections
		if (!empty($blocksRepo))
		{
			$blocksCats['separator_apps'] = array(
				'name' => Loc::getMessage('LANDING_BLOCK_SEPARATOR_PARTNER'),
				'separator' => true,
				'items' => array()
			);
			foreach ($apps as $app)
			{
				$blocksCats[$app['CODE']] = array(
					'name' => $app['APP_NAME'],
					'new' => false,
					'separator' => false,
					'app_code' => $app['CODE'],
					'items' => array()
				);
			}
			// add blocks to the app sections
			foreach ($blocksRepo as $key => $block)
			{
				if ($block['app_code'])
				{
					$blocksCats[$block['app_code']]['items'][$key] = $block;
				}
			}
		}

		// system cache end
		if ($cacheStarted)
		{
			$cache->endDataCache($blocksCats);
			if (defined('BX_COMP_MANAGED_CACHE'))
			{
				Manager::getCacheManager()->EndTagCache();
			}
		}

		$blocksCats = $fillLastUsed($blocksCats);

		return $blocksCats;
	}

	/**
	 * Get last used blocks by current user.
	 * @param int $count Count of blocks.
	 * @return array
	 */
	public static function getLastUsed($count = 10)
	{
		$blocks = array();

		$c = 0;
		$res = parent::getList(array(
			'select' => array(
				'CODE'
			),
			'filter' => array(
				'CREATED_BY_ID' => Manager::getUserId(),
				'=PUBLIC' => 'N'
			),
			'order' => array(
				'DATE_CREATE' => 'DESC'
			)
		));
		while ($row = $res->fetch())
		{
			$blocks[$row['CODE']] = $row['CODE'];
			if (++$c >= $count)
			{
				break;
			}
		}

		return array_values($blocks);
	}


	/**
     * Get blocks style manifest from repository.
     * @return array
	*/
	public static function getStyle()
	{
		$style = array();

		// read all subdirs ($namespaces) in block dir
		$path = Manager::getDocRoot() . self::BLOCKS_DIR;
		if (($handle = opendir($path)))
		{
			while ((($entry = readdir($handle)) !== false))
			{
				if (
					$entry != '.' && $entry != '..' &&
					is_dir($path . '/' . $entry) &&
					file_exists($path . '/' . $entry . '/.style.php')
				)
				{
					$style[$entry] = include $path . '/' . $entry . '/.style.php';
				}
			}
		}

		return $style;
	}

	/**
	 * Get block content array.
	 * @param int $id Block id.
	 * @param boolean $editMode Edit mode if true.
	 * @return array
	 */
	public static function getBlockContent($id, $editMode = false)
	{
		ob_start();
		$block = new self($id);
		$extContent = '';
		if (($ext = $block->getExt()))
		{
			$extContent = \CUtil::initJSCore($ext, true);
			$extContent = preg_replace(
				'#<script type="text/javascript"(\sdata\-skip\-moving\="true")?>.*?</script>#is',
				'',
				$extContent
			);
		}
		$block->view();
		$content = ob_get_contents();
		ob_end_clean();
		if ($block->exist())
		{
			$availableJS = !$editMode || !$block->getRepoId();
			return array(
				'id' => $id,
				'content' => $content,
				'content_ext' => $extContent,
				'css' => $block->getCSS(),
				'js' => $availableJS ? $block->getJS() : array(),
				'manifest' => $block->getManifest()
			);
		}
		else
		{
			return array();
		}
	}

	/**
	 * Get block anchor.
	 * @param int $id Block id.
	 * @return string
	 */
	public static function getAnchor($id)
	{
		return 'block' . $id;
	}

	/**
	 * Get namespace for block.
	 * @param string $code Code of block.
	 * @return string
	 */
	protected static function getBlockNamespace($code)
	{
		static $pathes = array();
		static $namespace = array();

		$code = trim($code);

		if (isset($pathes[$code]))
		{
			return $pathes[$code];
		}

		$pathes[$code] = '';
		$path = Manager::getDocRoot() . self::BLOCKS_DIR;

		// read all subdirs ($namespaces) in block dir
		if (empty($namespace))
		{
			if (($handle = opendir($path)))
			{
				while ((($entry = readdir($handle)) !== false))
				{
					if (
						is_dir($path . '/' . $entry) &&
						$entry != '.' && $entry != '..'
					)
					{
						$namespace[] = $entry;
					}
				}
			}
			sort($namespace);
		}

		// get first needed block from end
		foreach (array_reverse($namespace) as $subdir)
		{
			if (file_exists($path . '/' . $subdir . '/' . $code . '/block.php'))
			{
				$pathes[$code] = $subdir;
				break;
			}
		}

		return $pathes[$code];
	}

	/**
	 * Get local path for block.
	 * @param string $code Code of block.
	 * @return string
	 */
	protected static function getBlockPath($code)
	{
		if (($namespace = self::getBlockNamespace($code)))
		{
			return self::BLOCKS_DIR . '/' . $namespace . '/' . $code;
		}
		else
		{
			return '';
		}
	}

	/**
	 * Exist or not block in current instance.
	 * @return boolean
	 */
	public function exist()
	{
		return $this->id > 0;
	}

	/**
	 * Get id of the block.
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Get code of the block.
	 * @return string
	 */
	public function getCode()
	{
		return $this->code;
	}

	/**
	 * Get content of the block.
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}

	/**
	 * Active or not the block.
	 * @return boolean
	 */
	public function isActive()
	{
		return $this->active;
	}

	/**
	 * Deleted (mark) or not the block.
	 * @return boolean
	 */
	public function isDeleted()
	{
		return $this->deleted;
	}

	/**
	 * Public or not the block.
	 * @return boolean
	 */
	public function isPublic()
	{
		return $this->public;
	}

	/**
	 * Get current access.
	 * @return string
	 */
	public function getAccess()
	{
		return $this->access;
	}

	/**
	 * Set active to the block.
	 * @param boolean $active Bool: true or false.
	 * @return boolean
	 */
	public function setActive($active)
	{
		if ($this->access < $this::ACCESS_X)
		{
			$this->error->addError(
				'ACCESS_DENIED',
				Loc::getMessage('LANDING_BLOCK_ACCESS_DENIED')
			);
			return false;
		}
		$this->active = (boolean) $active;
		return true;
	}

	/**
	 * Get repo id, if block from repo.
	 * @return int
	 */
	public function getRepoId()
	{
		return $this->repoId;
	}

	/**
	 * Get local path to the block.
	 * @return string|null
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * Get preview picture of the block.
	 * @return string
	 */
	public function getPreview()
	{
		if (file_exists($this->pathFull . '/' . self::PREVIEW_FILE_NAME))
		{
			return $this->path . '/' . self::PREVIEW_FILE_NAME;
		}
		return '';
	}

	/**
	 * Get error collection
	 * @return \Bitrix\Landing\Error
	 */
	public function getError()
	{
		return $this->error;
	}

	/**
	 * Get class handler for type of node.
	 * @param string $type Type.
	 * @return string
	 */
	protected function getTypeClass($type)
	{
		static $classes = array();

		$type = strtolower($type);

		if (isset($classes[$type]))
		{
			return $classes[$type];
		}

		$class = __NAMESPACE__ . '\\Node\\' . $type;

		// check custom classes
		$event = new \Bitrix\Main\Event('landing', 'onGetNodeClass', array(
			'type' => $type,
		));
		$event->send();
		foreach ($event->getResults() as $result)
		{
			if ($result->getResultType() != \Bitrix\Main\EventResult::ERROR)
			{
				if (
					($modified = $result->getModified()) &&
					isset($modified['class'])
				)
				{
					$class = $modified['class'];
				}
			}
		}

		$classes[$type] = $class;

		return $classes[$type];
	}

	/**
	 * Get manifest array from block.
	 * @return array
	 */
	public function getManifest()
	{
		static $manifestStore = array();

		if (isset($manifestStore[$this->code]))
		{
			return $manifestStore[$this->code];
		}

		$manifest = array();
		// manifet is exist and correct
		if ($this->repoId || file_exists($this->pathFull . '/.description.php'))
		{
			if ($this->repoId)
			{
				$manifest = Repo::getBlock($this->repoId);
			}
			else
			{
				Loc::loadLanguageFile($this->pathFull . '/.description.php');
				$manifest = include $this->pathFull . '/.description.php';
			}
			if (isset($manifest['block']['name']))
			{
				// set empty array if no exists
				foreach (array('cards', 'nodes', 'attrs') as $code)
				{
					if (!isset($manifest[$code]) || !is_array($manifest[$code]))
					{
						$manifest[$code] = array();
					}
				}
				// prepare every node
				foreach ($manifest['nodes'] as $keyNode => &$node)
				{
					if (is_callable($node) && !$this->repoId)
					{
						$node = $node();
					}
					$node['code'] = $keyNode;
					$class = $this->getTypeClass($node['type']);
					if (isset($node['type']) && class_exists($class))
					{
						$node['handler'] = call_user_func(array(
							$class,
							'getHandlerJS'
						));
						if (method_exists($class, 'prepareManifest'))
						{
							$node = call_user_func_array(array(
								$class,
								'prepareManifest'
							), array(
								$this,
								$node,
								&$manifest
							));
							if (!is_array($node))
							{
								unset($manifest['nodes'][$keyNode]);
							}
						}
					}
					else
					{
						unset($manifest['nodes'][$keyNode]);
					}
				}
				unset($node);
				// and attrs
				foreach ($manifest['attrs'] as $keyNode => &$node)
				{
					if (is_callable($node) && !$this->repoId)
					{
						$node = $node();
					}
				}
				unset($node);
				// callbacks
				if (isset($manifest['callbacks']) && is_array($manifest['callbacks']))
				{
					$callbacks = array();
					foreach ($manifest['callbacks'] as $code => $callback)
					{
						$callbacks[strtolower($code)] = $callback;
					}
					$manifest['callbacks'] = $callbacks;
				}
				// prepare styles
				if (!isset($manifest['namespace']))
				{
					$manifest['namespace'] = $this->getBlockNamespace($this->code);
				}
				if (
					isset($manifest['style']) &&
					!(
						isset($manifest['style']['block']) &&
						isset($manifest['style']['nodes']) &&
						count($manifest['style']) == 2
					)
				)
				{
					$manifest['style'] = array(
						'block' => array(),
						'nodes' => $manifest['style']
					);
				}
				elseif (
					!isset($manifest['style']) ||
					!is_array($manifest['style'])
				)
				{
					$manifest['style'] = array(
						'block' => array(),
						'nodes' => array()
					);
				}
				// other
				$manifest['code'] = $this->code;
			}
			else
			{
				$manifest = array();
			}
		}

		$manifestStore[$this->code] = $manifest;

		return $manifest;
	}

	/**
	 * Get manifest array as is from block.
	 * @param string $code Code name, format "namespace:code".
	 * @return array
	 */
	public static function getManifestFile($code)
	{
		$manifest = array();

		if (strpos($code, ':') !== false)
		{
			list($namespace, $code) = explode(':', $code);
			$pathFull = self::BLOCKS_DIR . '/' . $namespace . '/' . $code;
			$pathFull = Manager::getDocRoot() . $pathFull;

			if (file_exists($pathFull . '/.description.php'))
			{
				Loc::loadLanguageFile($pathFull . '/.description.php');
				$manifest = include $pathFull . '/.description.php';
			}
		}

		return $manifest;
	}

	/**
	 * Get CSS/JS array of block.
	 * @param string $type What return: css or js.
	 * @return array
	 */
	public function getAsset($type = false)
	{
		static $asset = array();

		if (!isset($asset[$this->code]))
		{
			$asset[$this->code] = array(
				'css' => array(),
				'js' => array(),
				'ext' => array()
			);
			// additional asset first
			if ($this->repoId || file_exists($this->pathFull . '/.description.php'))
			{
				$keys = array('css', 'js', 'ext');
				if ($this->repoId)
				{
					$manifest = Repo::getBlock($this->repoId);
				}
				else
				{
					$manifest = include $this->pathFull . '/.description.php';
				}
				foreach ($keys as $ass)//ass = asset ;)
				{
					if (
						isset($manifest['assets'][$ass]) &&
						!empty($manifest['assets'][$ass])
					)
					{
						foreach ($manifest['assets'][$ass] as $file)
						{
							if ($ass != 'ext')
							{
								$asset[$this->code][$ass][] = trim($file);
							}
							else if (
								!$this->repoId ||
								in_array($file, array('landing_form'))
							)
							{
								$asset[$this->code][$ass][] = trim($file);
							}
						}
						$asset[$this->code][$ass] = array_unique($asset[$this->code][$ass]);
					}
				}
			}
			if (!$this->repoId)
			{
				// base files next
				$file = $this->getPath() . '/style.css';
				if (file_exists(Manager::getDocRoot() . $file))
				{
					$asset[$this->code]['css'][] = $file;
				}
				$file = $this->getPath() . '/script.js';
				if (file_exists(Manager::getDocRoot() . $file))
				{
					$asset[$this->code]['js'][] = $file;
				}
			}
		}

		return isset($asset[$this->code][$type])
				? $asset[$this->code][$type]
				: $asset[$this->code];
	}

	/**
	 * Get css file path, if exists.
	 * @return array
	 */
	public function getCSS()
	{
		return $this->getAsset('css');
	}

	/**
	 * Get js file path, if exists.
	 * @return array
	 */
	public function getJS()
	{
		return $this->getAsset('js');
	}

	/**
	 * Get extensions.
	 * @return array
	 */
	public function getExt()
	{
		return $this->getAsset('ext');
	}

	/**
	 * Out the block.
	 * @param boolean $edit Out block in edit mode.
	 * @param Landing|null $landing Landing of this block.
	 * @return void
	 */
	public function view($edit = false, \Bitrix\Landing\Landing $landing = null)
	{
		global $APPLICATION;

		static $jsPlaced = array();

		if ($this->deleted)
		{
			return;
		}

		if ($edit || $this->active)
		{
			if (!$this->repoId)
			{
				Loc::loadMessages($this->pathFull . '/block.php');
			}
			foreach ($this->getCSS() as $css)
			{
				Asset::getInstance()->addCSS($css);
			}
			if (($ext = $this->getExt()))
			{
				\CUtil::initJSCore($ext);
			}
			if (!$edit || !$this->repoId)
			{
				foreach ($this->getJS() as $js)
				{
					if ($this->repoId)
					{
						if (!in_array($js, $jsPlaced))
						{
							$jsPlaced[] = $js;
							Manager::setPageClass(
								'FooterJS',
								'<script type="text/javascript" src="' . \htmlspecialcharsbx($js) . '"></script>'
							);
						}
					}
					else
					{
						Asset::getInstance()->addJS($js);
					}
				}
			}
		}

		$content = '<div id="' . $this->getAnchor($this->id) . '" class="block-wrapper' . (!$this->active ? ' landing-block-deactive' : '') . '">' .
						$this->content .
					'</div>';
		// @tmp bug with setInnerHTML save result
		$content = preg_replace('/&amp;([^\s]{1})/is', '&$1', $content);

		if ($edit)
		{
			$manifest = $this->getManifest();
			if ($manifest)
			{
				echo '<script type="text/javascript">'
						. 'BX.ready(function(){'
							. 'if (typeof BX.Landing.Block !== "undefined")'
							. '{'
								. 'new BX.Landing.Block('
									. 'BX("block' . $this->id  . '"), '
									. '{'
										. 'id: ' . $this->id  . ', '
										. 'active: ' . ($this->active ? 'true' : 'false')  . ', '
										. 'access: ' . '"' . $this->access . '"' . ', '
										. 'manifest: ' . Json::encode($manifest)
									. '}'
								. ');'
							. '}'
						. '});'
					. '</script>';
			}
			if ($this->repoId)
			{
				echo $content;
			}
			else
			{
				eval('?>' . $content . '<?');
			}
		}
		elseif ($this->active)
		{
			if ($this->repoId)
			{
				echo $content;
			}
			else
			{
				eval('?>' . $content . '<?');
			}

		}
	}

	/**
	 * Set new content.
	 * @param string $content New content.
	 * @return void
	 */
	public function saveContent($content)
	{
		$this->content = trim($content);
	}

	/**
	 * Save current block in DB.
	 * @return boolean
	 */
	public function save()
	{
		$data = array(
			'SORT' => $this->sort,
			'ACTIVE' => $this->active ? 'Y' : 'N',
			'DELETED' => $this->deleted ? 'Y' : 'N'
		);
		if ($this->content)
		{
			$data['CONTENT'] = $this->content;
		}
		$res = parent::update($this->id, $data);
		$this->error->addFromResult($res);
		return $res->isSuccess();
	}

	/**
	 * Change landing of current block.
	 * @param int $lid New landing id.
	 * @return boolean
	 *
	 */
	public function changeLanding($lid)
	{
		$res = parent::update($this->id, array(
			'LID' => $lid,
			'PARENT_ID' => 0,
			'PUBLIC' => 'N'
		));
		$this->error->addFromResult($res);
		return $res->isSuccess();
	}

	/**
	 * Delete current block.
	 * @return boolean
	 */
	public function unlink()
	{
		if ($this->access < $this::ACCESS_X)
		{
			$this->error->addError(
				'ACCESS_DENIED',
				Loc::getMessage('LANDING_BLOCK_ACCESS_DENIED')
			);
			return false;
		}

		$manifest = $this->getManifest();
		$res = self::parentDelete($this->id);
		if (!$res->isSuccess())
		{
			$this->error->addFromResult($res);
		}
		return $res->isSuccess();
	}

	/**
	 * Mark delete or not current block.
	 * @param boolean $mark Mark.
	 * @return void
	 */
	public function markDeleted($mark)
	{
		if ($this->access >= $this::ACCESS_X)
		{
			$this->deleted = (boolean) $mark;
		}
	}

	/**
	 * Set new sort to current block.
	 * @param int $sort New sort.
	 * @return void
	 */
	public function setSort($sort)
	{
		$this->sort = $sort;
	}

	/**
	 * Save new sort to current block to DB.
	 * @param int $sort New sort.
	 * @return void
	 */
	public function saveSort($sort)
	{
		$this->sort = $sort;
		Internals\BlockTable::update($this->id, array(
			'SORT' => $sort
		));
	}

	/**
	 * Get sort of current block.
	 * @return int
	 */
	public function getSort()
	{
		return $this->sort;
	}

	/**
	 * Load current content in DOM html structure.
	 * @return DOM\Document
	 */
	public function getDom()
	{
		static $doc = array();

		if (!isset($doc[$this->id]))
		{
			$doc[$this->id] = new DOM\Document;
			$doc[$this->id]->loadHTML($this->content);
		}

		return $doc[$this->id];
	}

	/**
	 * Clone one card in block by selector.
	 * @param string $selector Selector.
	 * @param int $position Card position.
	 * @param string $content New content for cloned card.
	 * @return boolean Success or failure.
	 */
	public function cloneCard($selector, $position, $content = '')
	{
		$manifest = $this->getManifest();
		if (isset($manifest['cards'][$selector]))
		{
			$position = max($position, -1);
			$realPosition = max($position, 0);
			$doc = $this->getDom();
			$resultList = $doc->querySelectorAll($selector);
			if (isset($resultList[$realPosition]))
			{
				$parentNode = $resultList[$realPosition]->getParentNode();
				$refChild = isset($resultList[$position + 1])
					? $resultList[$position + 1]
					: null;
				$haveChild = false;
				if ($refChild)
				{
					foreach ($parentNode->getChildNodes() as $child)
					{
						if ($child === $refChild)
						{
							$haveChild = true;
							break;
						}
					}
				}
				if ($parentNode && (!$refChild || $haveChild))
				{
					// some dance for set new content ;)
					if ($content)
					{
						$tmpCardName = strtolower('tmpcard' . randString(10));
						$newChild = new DOM\Element($tmpCardName);
						$newChild->setOwnerDocument($doc);
						$newChild->setInnerHTML($content);
					}
					else
					{
						$newChild = $resultList[$realPosition];
					}
					$parentNode->insertBefore(
						$newChild,
						$refChild,
						false
					);
					// cleaning and save
					if (isset($tmpCardName))
					{
						$this->saveContent(
							str_replace(
								array('<' . $tmpCardName . '>', '</' . $tmpCardName . '>'),
								'',
								$doc->saveHTML()
							)
						);
					}
					else
					{
						$this->saveContent($doc->saveHTML());
					}
				}
				return true;
			}

		}

		$this->error->addError(
			'CARD_NOT_FOUND',
			Loc::getMessage('LANDING_BLOCK_CARD_NOT_FOUND')
		);
		return false;
	}

	/**
	 * Remove one card from block by selector.
	 * @param string $selector Selector.
	 * @param int $position Card position.
	 * @return boolean Success or failure.
	 */
	public function removeCard($selector, $position)
	{
		$manifest = $this->getManifest();
		if (isset($manifest['cards'][$selector]))
		{
			$doc = $this->getDom();
			$resultList = $doc->querySelectorAll($selector);
			if (isset($resultList[$position]))
			{
				$resultList[$position]->getParentNode()->removeChild(
					$resultList[$position]
				);
				$this->saveContent($doc->saveHTML());
				return true;
			}

		}

		$this->error->addError(
			'CARD_NOT_FOUND',
			Loc::getMessage('LANDING_BLOCK_CARD_NOT_FOUND')
		);
		return false;
	}

	/**
	 * Set new names for nodes of block.
	 * @param array $data Nodes data array.
	 * @return boolean
	 */
	public function changeNodeName($data)
	{
		if ($this->access < $this::ACCESS_W)
		{
			$this->error->addError(
				'ACCESS_DENIED',
				Loc::getMessage('LANDING_BLOCK_ACCESS_DENIED')
			);
			return false;
		}
		$doc = $this->getDom();
		$manifest = $this->getManifest();
		// find available nodes by manifest from data
		foreach ($manifest['nodes'] as $selector => $node)
		{
			if (isset($data[$selector]))
			{
				$resultList = $doc->querySelectorAll($selector);

				foreach ($data[$selector] as $pos => $value)
				{
					$value = trim($value);
					if (
						preg_match('/^[a-z0-9]+$/', $value) &&
						isset($resultList[$pos]))
					{
						$resultList[$pos]->setNodeName($value);
					}
				}
			}
		}
		// save rebuild html as text
		$this->saveContent($doc->saveHTML());
		return true;
	}

	/**
	 * Set new content to nodes of block.
	 * @param array $data Nodes data array.
	 * @return boolean
	 */
	public function updateNodes($data)
	{
		if ($this->access < $this::ACCESS_W)
		{
			$this->error->addError(
				'ACCESS_DENIED',
				Loc::getMessage('LANDING_BLOCK_ACCESS_DENIED')
			);
			return false;
		}

		$doc = $this->getDom();
		$manifest = $this->getManifest();
		// find available nodes by manifest from data
		foreach ($manifest['nodes'] as $selector => $node)
		{
			if (isset($data[$selector]))
			{
				if (!is_array($data[$selector]))
				{
					$data[$selector] = array(
						$data[$selector]
					);
				}
				// and save content from frontend in DOM by handler-class
				call_user_func_array(array(
					$this->getTypeClass($node['type']),
					'saveNode'
				), array(
					&$this,
					$selector,
					$data[$selector]
				));
			}
		}
		// save rebuild html as text
		$this->saveContent($doc->saveHTML());
		return true;
	}

	/**
	 * Recursive styles remove in Node.
	 * @param \Bitrix\Main\Web\DOM\Node $node Node for clear.
	 * @param array $styleToRemove Array of styles to remove.
	 * @return \Bitrix\Main\Web\DOM\Node
	 */
	protected function removeStyle(\Bitrix\Main\Web\DOM\Node $node, array $styleToRemove)
	{
		foreach ($node->getChildNodesArray() as $nodeChild)
		{
			if ($nodeChild instanceof \Bitrix\Main\Web\DOM\Element)
			{
				$styles = DOM\StyleInliner::getStyle($nodeChild);
				if (!empty($styles))
				{
					foreach ($styleToRemove as $remove)
					{
						if (isset($styles[$remove]))
						{
							unset($styles[$remove]);
						}
					}
					DOM\StyleInliner::setStyle($nodeChild, $styles);
				}
			}
			$node = $this->removeStyle($nodeChild, $styleToRemove);
		}

		return $node;
	}

	/**
	 * Set new classes to nodes of block.
	 * @param array $data Classes data array.
	 * @return boolean
	 */
	public function setClasses($data)
	{
		if ($this->access < $this::ACCESS_V)
		{
			$this->error->addError(
				'ACCESS_DENIED',
				Loc::getMessage('LANDING_BLOCK_ACCESS_DENIED')
			);
			return false;
		}

		$doc = $this->getDom();
		$manifest = $this->getManifest();

		// wrapper (not realy exist)
		$wrapper = '#' . $this->getAnchor($this->id);

		// find available nodes by manifest from data
		$styles = array_merge(
			$manifest['style']['block'],
			$manifest['style']['nodes']
		);
		$styles[$wrapper] = array(
			//
		);
		foreach ($styles as $selector => $node)
		{
			if (isset($data[$selector]))
			{
				// prepare data
				if (!is_array($data[$selector]))
				{
					$data[$selector] = array(
						$data[$selector]
					);
				}
				if (!isset($data[$selector]['classList']))
				{
					$data[$selector] = array(
						'classList' => $data[$selector]
					);
				}
				if (!isset($data[$selector]['affect']))
				{
					$data[$selector]['affect'] = array();
				}
				// apply classes to the block
				if ($selector == $wrapper)
				{
					$resultList = array(
						array_pop($doc->getChildNodesArray())
					);
				}
				// or by selector
				else
				{
					$resultList = $doc->querySelectorAll($selector);
				}
				foreach ($resultList as $resultNode)
				{
					if ($resultNode)
					{
						if ($resultNode->getNodeType() == $resultNode::ELEMENT_NODE)
						{
							$resultNode->setClassName(
								implode(' ', $data[$selector]['classList'])
							);
						}
						// affected styles
						if (!empty($data[$selector]['affect']))
						{
							$this->removeStyle(
								$resultNode,
								$data[$selector]['affect']
							);
						}
					}
				}
			}
		}
		// save rebuild html as text
		$this->saveContent($doc->saveHTML());
		return true;
	}

	/**
	 * Set attributes to nodes of block.
	 * @param array $data Attrs data array.
	 * @return void
	 */
	public function setAttributes($data)
	{
		$doc = $this->getDom();
		$manifest = $this->getManifest();

		// wrapper (not realy exist)
		$wrapper = '#' . $this->getAnchor($this->id);

		// find available nodes by manifest from data
		$attrs = $manifest['attrs'];
		$attrs[$wrapper] = array(
			//
		);

		// find attrs in style key
		if (isset($manifest['style']['nodes']))
		{
			foreach ($manifest['style']['nodes'] as $selector => $item)
			{
				if (isset($item['additional']) && is_array($item['additional']))
				{
					foreach ($item['additional'] as $itemAdditional)
					{
						if (
							isset($itemAdditional['attrs']) &&
							is_array($itemAdditional['attrs'])
						)
						{
							foreach ($itemAdditional['attrs'] as $attr)
							{
								if (!isset($attrs[$selector]))
								{
									$attrs[$selector] = array();
								}
								$attrs[$selector][] = $attr;
							}
						}
					}
				}
			}
		}

		foreach ($attrs as $selector => $item)
		{
			if (isset($data[$selector]))
			{
				// not multi
				if (!isset($item[0]))
				{
					$item = array($item);
				}
				// prepare attrs (and group attrs)
				$attrItems = array();
				foreach ($item as $key => $val)
				{
					if (
						isset($val['attrs']) &&
						is_array($val['attrs'])
					)
					{
						foreach ($val['attrs'] as $groupAttr)
						{
							$item[] = $groupAttr;
						}
						unset($item[$key]);
					}
				}
				foreach ($item as $val)
				{
					if (
						isset($val['attribute']) &&
						isset($data[$selector][$val['attribute']])
					)
					{
						$attrItems[$val['attribute']] = $data[$selector][$val['attribute']];
					}
				}
				// set attrs to the block
				if ($selector == $wrapper)
				{
					$resultList = array(
						array_pop($doc->getChildNodesArray())
					);
				}
				// or by selector
				else
				{
					$resultList = $doc->querySelectorAll($selector);
				}
				foreach ($resultList as $resultNode)
				{
					foreach ($attrItems as $code => $val)
					{
						$resultNode->setAttribute(
							\htmlspecialcharsbx($code),
							is_array($val)
							? json_encode($val)
							: $val
						);
					}
				}
			}
		}
		// save rebuild html as text
		$this->saveContent($doc->saveHTML());
	}

	/**
	 * Delete all blocks from db by codes.
	 * @param array $code Array of codes to delete.
	 * @return void
	 */
	public static function deleteByCode($code)
	{
		if (!is_array($code))
		{
			$code = array($code);
		}
		$res = parent::getList(array(
			'select' => array(
				'ID'
			),
			'filter' => array(
				'=CODE' => $code
			)
		));
		while ($row = $res->fetch())
		{
			self::parentDelete($row['ID']);
		}
	}

	/**
	 * Delete block row.
	 * @param int $id Block id.
	 * @return \Bitrix\Main\Result
	 */
	private static function parentDelete($id)
	{
		return parent::delete($id);
	}

	public static function add($fields)
	{
		throw new \Bitrix\Main\SystemException(
			'Disabled for direct access.'
		);
	}

	public static function update($id, $fields = array())
	{
		throw new \Bitrix\Main\SystemException(
			'Disabled for direct access.'
		);
	}

	public static function delete($id)
	{
		throw new \Bitrix\Main\SystemException(
			'Disabled for direct access.'
		);
	}

	public static function getList($fields = array())
	{
		throw new \Bitrix\Main\SystemException(
			'Disabled for direct access.'
		);
	}
}