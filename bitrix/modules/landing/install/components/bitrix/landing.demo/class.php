<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use \Bitrix\Landing\Site;
use \Bitrix\Landing\Landing;
use \Bitrix\Landing\Domain;
use \Bitrix\Landing\Manager;
use \Bitrix\Landing\Template;
use \Bitrix\Landing\TemplateRef;
use \Bitrix\Highloadblock;

\CBitrixComponent::includeComponentClass('bitrix:landing.base');

class LandingSiteDemoComponent extends LandingBaseComponent
{
	/**
	 * Path with demo templates data for site.
	 * @var string
	 */
	protected $demoDirSite = '/data/site';

	/**
	 * Path with demo templates data for page.
	 * @var string
	 */
	protected $demoDirPage = '/data/page';

	/**
	 * Relative url for new site.
	 * @var string
	 */
	protected $urlTpl = '/#rand#/';

	/**
	 * Redirect to the landing.
	 * @param int $landingId Landing id.
	 * @return boolean If error.
	 */
	protected function redirectToLanding($landingId)
	{
		$landing = Landing::createInstance($landingId);
		if ($landing->exist())
		{
			$siteId = $landing->getSiteId();
			$redirect = str_replace(
				array('#site_show#', '#landing_edit#'),
				array($siteId, $landingId),
				$this->arParams['PAGE_URL_LANDING_VIEW']
			);
			$redirect .= (strpos($redirect, '?') === false ? '?' : '&')
						. 'IFRAME=N';
			\localRedirect($redirect, true);
		}
		else
		{
			$this->setErrors($landing->getError()->getErrors());
			return false;
		}
	}

	/**
	 * Create one page in site.
	 * @param int $siteId Site id.
	 * @param string $code Page code.
	 * @return boolean|int Id of new landing.
	 */
	protected function createPage($siteId, $code)
	{
		$demo = $this->getDemoPage();

		if (isset($demo[$code]))
		{
			$data = $demo[$code]['DATA'];
			$pageData = $data['fields'];
			$pageData['SITE_ID'] = $siteId;
			$pageData['PUBLIC'] = 'N';
			$pageData['XML_ID'] = $data['name'] . '|' . $code;
			if ($this->request($this->arParams['ACTION_FOLDER']))
			{
				$pageData['FOLDER_ID'] = $this->request(
					$this->arParams['ACTION_FOLDER']
				);
			}
			Landing::setEditMode();
			$res = Landing::add($pageData);
			// and fill each page with blocks
			if ($res->isSuccess())
			{
				$landingId = $res->getId();
				$landing = Landing::createInstance($landingId);
				if ($landing->exist())
				{
					$blocks = array();
					foreach ($data['items'] as $k => $block)
					{
						if (is_array($block))
						{
							// to correct charset
							$block['CONTENT'] = \Bitrix\Main\Text\Encoding::convertEncoding(
								$block['CONTENT'],
								'cp1251',
								SITE_CHARSET
							);
							$block['PUBLIC'] = 'N';
							$blockId = $landing->addBlock(
								isset($block['CODE']) ? $block['CODE'] : $k,
								$block
							);
							$blocks[$k] = $blockId;
						}
						else
						{
							$blockId = $landing->addBlock($block, array(
								'PUBLIC' => 'N',
							));
							$blocks[$block] = $blockId;
						}
					}
					// redefine content of blocks
					foreach ($landing->getBlocks() as $block)
					{
						$content = $block->getContent();
						foreach ($blocks as $blockCode => $blockId)
						{
							$content = str_replace(
								'@block[' . $blockCode . ']',
								$blockId,
								$content
							);
							if (isset($data['replace']) && is_array($data['replace']))
							{
								foreach ($data['replace'] as $find => $replace)
								{
									$content = str_replace(
										$find,
										$replace,
										$content
									);
								}
							}
						}
						$block->saveContent($content);
						$block->save();
					}
					return $landing->getId();
				}
				else
				{
					$this->setErrors($landing->getError()->getErrors());
					return false;
				}
			}
			else
			{
				$this->setErrors($res->getErrors());
				return false;
			}
		}

		return true;
	}

	/**
	 * Create site or page by template.
	 * @param string $code Demo site code.
	 * @return boolean
	 */
	protected function actionSelect($code)
	{
		// create page in the site
		if ($this->arParams['SITE_ID'] > 0)
		{
			$landingId = $this->createPage(
				$this->arParams['SITE_ID'],
				$code
			);
			if ($landingId)
			{
				if (!$this->redirectToLanding($landingId))
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		// else create site and pages into
		$demo = $this->getDemoSite();
		if (isset($demo[$code]))
		{
			$data = $demo[$code]['DATA'];
			$siteData = $data['fields'];
			$siteData['DOMAIN_ID'] = !\Bitrix\Main\Loader::includeModule('bitrix24')
									? Domain::getCurrentId()
									: ' ';
			$siteData['CODE'] = str_replace(
				'#rand#',
				strtolower(\randString(5)),
				$this->urlTpl
			);
			$siteData['XML_ID'] = $data['name'] . '|' . $code;
			$siteData['TYPE'] = $demo[$code]['TYPE'];
			// callbacks
			if (
				isset($data['callbacks']['beforeCreate']) &&
				is_callable($data['callbacks']['beforeCreate'])
			)
			{
				$callbackRes = $data['callbacks']['beforeCreate']();
				if ($callbackRes !== true)
				{
					$this->addError('CALLBACK_ERROR', $callbackRes);
					return false;
				}
			}
			// first create site
			$res = Site::add($siteData);
			if ($res->isSuccess())
			{
				$siteData['ID'] = $res->getId();
				$firstLandingId = false;
				$landings = array();
				// then create pages
				if (empty($data['items']))
				{
					$data['items'][] = $code;
				}
				foreach ($data['items'] as $page)
				{
					$landingId = $this->createPage($siteData['ID'], $page);
					if (!$landingId)
					{
						return false;
					}
					elseif (!$firstLandingId)
					{
						$firstLandingId = $landingId;
					}
					$landings[$page] = $landingId;
				}
				// redefine content of pages
				foreach ($landings as $landCode => $landId)
				{
					$landing = Landing::createInstance($landId);
					if ($landing->exist())
					{
						foreach ($landing->getBlocks() as $block)
						{
							$content = $block->getContent();
							foreach ($landings as $landCode => $landId)
							{
								$content = str_replace(
									'@landing[' . $landCode . ']',
									$landId,
									$content
								);
							}
							$block->saveContent($content);
							$block->save();
						}
						$landing->publication();
					}
				}
				// set layout
				if (isset($data['layout']['code']))
				{
					$res = Template::getList(array(
						'select' => array(
							'ID', 'AREA_COUNT'
						),
						'filter' => array(
							'=XML_ID' => $data['layout']['code']
						)
					));
					if ($tpl = $res->fetch())
					{
						Site::update($siteData['ID'], array(
							'TPL_ID' => $tpl['ID']
						));
						$ref = array();
						for ($i = 1; $i <= $tpl['AREA_COUNT']; $i++)
						{
							if (
								isset($data['layout']['ref'][$i]) &&
								isset($landings[$data['layout']['ref'][$i]])
							)
							{
								$ref[$i] = $landings[$data['layout']['ref'][$i]];
							}
						}
						if (!empty($ref))
						{
							TemplateRef::setForSite(
								$siteData['ID'],
								$ref
							);
						}
					}
				}
				// set pages to folders
				if (isset($data['folders']) && is_array($data['folders']))
				{
					foreach ($data['folders'] as $folder => $items)
					{
						if (isset($landings[$folder]) && is_array($items))
						{
							foreach ($items as $item)
							{
								if (isset($landings[$item]))
								{
									Landing::update($landings[$item], array(
										'FOLDER_ID' => $landings[$folder]
									));
								}
							}
						}
					}
				}
				// create system refs
				if (isset($data['syspages']) && is_array($data['syspages']))
				{
					foreach ($data['syspages'] as $sysCode => $pageCode)
					{
						if (isset($landings[$pageCode]))
						{
							\Bitrix\Landing\Syspage::set(
								$siteData['ID'],
								$sysCode,
								$landings[$pageCode]
							);
						}
					}
				}
				$this->redirectToLanding($firstLandingId);
			}
			else
			{
				$this->setErrors($res->getErrors());
				return false;
			}
			return true;
		}

		return false;
	}

	/**
	 * Get demo templates.
	 * @param string $subDir Subdir for data dir.
	 * @return array
	 */
	protected function getDemo($subDir)
	{
		static $data = array();

		if (!isset($data[$subDir]))
		{
			$items = array();
			$data[$subDir] = array();
			$pathLocal = $this->getPath() . $subDir;
			$path = Manager::getDocRoot() . $pathLocal;
			$siteTypeDef = Site::getDefaultType();
			$siteTypeCurr = $this->arParams['TYPE'];
			$dir = array();

			// read demo from dear
			if (($handle = opendir($path)))
			{
				while ((($entry = readdir($handle)) !== false))
				{
					if ($entry != '.' && $entry != '..')
					{
						$descPath = $path . '/' . $entry . '/.description.php';
						if (file_exists($descPath))
						{
							$dir[] = $entry;
						}
						else if (($handleSubdir = opendir($path . '/' . $entry)))
						{
							while ((($entrySubdir = readdir($handleSubdir)) !== false))
							{
								if ($entrySubdir != '.' && $entrySubdir != '..')
								{
									$descPath = $path . '/' . $entry . '/' . $entrySubdir . '/.description.php';
									if (file_exists($descPath))
									{
										$dir[] = $entry . '/' . $entrySubdir;
									}
								}
							}
						}
					}
				}
			}

			// and work with this
			foreach ($dir as $entry)
			{
				$itemData = include $path . '/' . $entry . '/.description.php';
				if (!isset($itemData['type']))
				{
					$itemData['type'] = $siteTypeDef;
				}
				else
				{
					$itemData['type'] = strtoupper($itemData['type']);
				}
				if ($siteTypeCurr == $itemData['type'] && isset($itemData['name']))
				{
					if (!isset($itemData['fields']) || !is_array($itemData['fields']))
					{
						$itemData['fields'] = array();
					}
					if (!isset($itemData['items']) || !is_array($itemData['items']))
					{
						$itemData['items'] = array();
					}
					// predefined
					$itemData['fields']['ACTIVE'] = 'Y';
					if (!isset($itemData['fields']['TITLE']))
					{
						$itemData['fields']['TITLE'] = $itemData['name'];
					}
					$items[$entry] = array(
						'ID' => $entry,
						'TYPE' => $itemData['type'],
						'TITLE' => $itemData['name'],
						'HIDE' => isset($itemData['hide']) ? $itemData['hide'] : false,
						'ACTIVE' => isset($itemData['active']) ? $itemData['active'] : true,
						'AVAILABLE' => isset($itemData['available']) ? $itemData['available'] : true,
						'DESCRIPTION' => isset($itemData['description'])
							? $itemData['description']
							: '',
						'SORT' => isset($itemData['sort']) ? $itemData['sort'] : 0,
						'PREVIEW' => file_exists($path . '/' . $entry . '/preview.png')
							? $pathLocal . '/' . $entry . '/preview.png'
							: '',
						'PREVIEW2X' => file_exists($path . '/' . $entry . '/preview@2x.png')
							? $pathLocal . '/' . $entry . '/preview@2x.png'
							: '',
						'PREVIEW3X' => file_exists($path . '/' . $entry . '/preview@3x.png')
							? $pathLocal . '/' . $entry . '/preview@3x.png'
							: '',
						'DATA' => $itemData
					);
				}
			}

			// sort by abc
			uasort($items, function($a, $b)
			{
				if ($a['SORT'] != $b['SORT'])
				{
					return
						$a['SORT'] == 0 ? $b['SORT'] :
						$b['SORT'] == 0 ? $a['SORT'] :
						$a['SORT'] < $b['SORT'] ? -1 : 1;
				}
				else
				{
					if ($a['TITLE'] == $b['TITLE'])
					{
						return 0;
					}
					return ($a['TITLE'] < $b['TITLE']) ? -1 : 1;
				}
			});

			// available - first
			foreach ($items as $key => $item)
			{
				if(!$item['ACTIVE'])
				{
					unset($items[$key]);
					continue;
				}
				elseif ($item['AVAILABLE'])
				{
					$data[$subDir][$key] = $item;
					unset($items[$key]);
				}
			}
			$data[$subDir] += $items;
		}

		return $data[$subDir];
	}

	/**
	 * Get demo site templates.
	 * @return array
	 */
	protected function getDemoSite()
	{
		return $this->getDemo($this->demoDirSite);
	}

	/**
	 * Get demo page templates.
	 * @return array
	 */
	protected function getDemoPage()
	{
		return $this->getDemo($this->demoDirPage);
	}
	
	/**
	 * Checking site or page activity depending on portal zone
	 * Format:
	 * $zones['ONLY_IN'] - show site only in these zones
	 * $zones['EXCEPT'] - not show site, if zone in this list
	 * @param array $zones Zones array.
	 * @return bool
	 */
	public static function checkActive($zones = array())
	{
		if (!empty($zones))
		{
			$currentZone = Manager::getZone();
			if (
				isset($zones['ONLY_IN']) &&
				is_array($zones['ONLY_IN']) && !empty($zones['ONLY_IN']) &&
				!in_array($currentZone, $zones['ONLY_IN'])
			)
			{
				return false;
			}
			if (
				isset($zones['EXCEPT']) &&
				is_array($zones['EXCEPT']) && !empty($zones['EXCEPT']) &&
				in_array($currentZone, $zones['EXCEPT'])
			)
			{
				return false;
			}
			return true;
		}
	}

	/**
	 * Create some highloadblocks.
	 * @return void
	 */
	public static function createHLblocks()
	{
		if (!\Bitrix\Main\Loader::includeModule('highloadblock'))
		{
			return;
		}

		$xmlPath = '/bitrix/components/bitrix/landing.demo/data/xml';

		// demo data
		$sort = 0;
		$colorValues = array();
		$colors = array(
			'PURPLE' => 'colors_files/iblock/0d3/0d3ef035d0cf3b821449b0174980a712.jpg',
			'BROWN' => 'colors_files/iblock/f5a/f5a37106cb59ba069cc511647988eb89.jpg',
			'SEE' => 'colors_files/iblock/f01/f01f801e9da96ae5a7f26aae01255f38.jpg',
			'BLUE' => 'colors_files/iblock/c1b/c1ba082577379bdc75246974a9f08c8b.jpg',
			'ORANGERED' => 'colors_files/iblock/0ba/0ba3b7ecdef03a44b145e43aed0cca57.jpg',
			'REDBLUE' => 'colors_files/iblock/1ac/1ac0a26c5f47bd865a73da765484a2fa.jpg',
			'RED' => 'colors_files/iblock/0a7/0a7513671518b0f2ce5f7cf44a239a83.jpg',
			'GREEN' => 'colors_files/iblock/b1c/b1ced825c9803084eb4ea0a742b2342c.jpg',
			'WHITE' => 'colors_files/iblock/b0e/b0eeeaa3e7519e272b7b382e700cbbc3.jpg',
			'BLACK' => 'colors_files/iblock/d7b/d7bdba8aca8422e808fb3ad571a74c09.jpg',
			'PINK' => 'colors_files/iblock/1b6/1b61761da0adce93518a3d613292043a.jpg',
			'AZURE' => 'colors_files/iblock/c2b/c2b274ad2820451d780ee7cf08d74bb3.jpg',
			'JEANS' => 'colors_files/iblock/24b/24b082dc5e647a3a945bc9a5c0a200f0.jpg',
			'FLOWERS' => 'colors_files/iblock/64f/64f32941a654a1cbe2105febe7e77f33.jpg'
		);
		foreach ($colors as $colorName => $colorFile)
		{
			$sort += 100;
			$colorValues[] = array(
				'UF_NAME' => $colorName,
				'UF_FILE' =>
					array (
						'name' => strtolower($colorName) . '.jpg',
						'type' => 'image/jpeg',
						'tmp_name' => Manager::getDocRoot() . $xmlPath . '/hl/' . $colorFile
					),
				'UF_SORT' => $sort,
				'UF_DEF' => ($sort > 100) ? '0' : '1',
				'UF_XML_ID' => strtolower($colorName)
			);
		}
		$sort = 0;
		$brandValues = array();
		$brands = array(
			'Company1' => 'brands_files/cm-01.png',
			'Company2' => 'brands_files/cm-02.png',
			'Company3' => 'brands_files/cm-03.png',
			'Company4' => 'brands_files/cm-04.png',
			'Brand1' => 'brands_files/bn-01.png',
			'Brand2' => 'brands_files/bn-02.png',
			'Brand3' => 'brands_files/bn-03.png',
		);
		foreach ($brands as $brandName => $brandFile)
		{
			$sort += 100;
			$brandValues[] = array(
				'UF_NAME' => $brandName,
				'UF_FILE' =>
					array (
						'name' => strtolower($brandName) . '.jpg',
						'type' => 'image/jpeg',
						'tmp_name' => Manager::getDocRoot() . $xmlPath . '/hl/' . $brandFile
					),
				'UF_SORT' => $sort,
				'UF_XML_ID' => strtolower($brandName)
			);
		}

		// some tables
		$tables = array(
			'eshop_color_reference' => array(
				'name' => 'ColorReference',
				'fields' => array(
					array(
						'FIELD_NAME' => 'UF_NAME',
						'USER_TYPE_ID' => 'string',
						'XML_ID' => 'UF_COLOR_NAME'
					),
					array(
						'FIELD_NAME' => 'UF_FILE',
						'USER_TYPE_ID' => 'file',
						'XML_ID' => 'UF_COLOR_FILE'
					),
					array(
						'FIELD_NAME' => 'UF_SORT',
						'USER_TYPE_ID' => 'double',
						'XML_ID' => 'UF_COLOR_SORT'
					),
					array(
						'FIELD_NAME' => 'UF_DEF',
						'USER_TYPE_ID' => 'boolean',
						'XML_ID' => 'UF_COLOR_DEF'
					),
					array(
						'FIELD_NAME' => 'UF_XML_ID',
						'USER_TYPE_ID' => 'string',
						'XML_ID' => 'UF_XML_ID'
					)
				),
				'values' => $colorValues
			),
			'eshop_brand_reference' => array(
				'name' => 'BrandReference',
				'fields' => array(
					array(
						'FIELD_NAME' => 'UF_NAME',
						'USER_TYPE_ID' => 'string',
						'XML_ID' => 'UF_BRAND_NAME'
					),
					array(
						'FIELD_NAME' => 'UF_FILE',
						'USER_TYPE_ID' => 'file',
						'XML_ID' => 'UF_BRAND_FILE'
					),
					array(
						'FIELD_NAME' => 'UF_SORT',
						'USER_TYPE_ID' => 'double',
						'XML_ID' => 'UF_BRAND_SORT'
					),
					array(
						'FIELD_NAME' => 'UF_XML_ID',
						'USER_TYPE_ID' => 'string',
						'XML_ID' => 'UF_XML_ID'
					)
				),
				'values' => $brandValues
			)
		);

		// create tables and fill with demo-data
		foreach ($tables as $tableName => &$table)
		{
			// if this hl isn't exist
			$res = Highloadblock\HighloadBlockTable::getList(
				array(
					'filter' => array(
						'NAME' => $table['name'],
						'TABLE_NAME' => $tableName
					)
				)
			);
			if (!$res->fetch())
			{
				// add new hl block
				$result = Highloadblock\HighloadBlockTable::add(array(
					'NAME' => $table['name'],
					'TABLE_NAME' => $tableName
				));
				if ($result->isSuccess())
				{
					$sort = 100;
					$tableId = $result->getId();
					// add fields
					$userField  = new \CUserTypeEntity;
					foreach ($table['fields'] as $field)
					{
						$field['ENTITY_ID'] = 'HLBLOCK_' . $tableId;
						$res = \CUserTypeEntity::getList(
							array(),
							array(
								'ENTITY_ID' => $field['ENTITY_ID'],
								'FIELD_NAME' => $field['FIELD_NAME']
							)
						);
						if (!$res->Fetch())
						{
							$field['SORT'] = $sort;
							$userField->Add($field);
							$sort += 100;
						}
					}
					// add data
					$hldata = Highloadblock\HighloadBlockTable::getById($tableId)->fetch();
					$hlentity = Highloadblock\HighloadBlockTable::compileEntity($hldata);
					$entityClass = $hlentity->getDataClass();
					foreach ($table['values'] as $item)
					{
						$entityClass::add($item);
					}
				}
			}
		}
	}

	/**
	 * Create products in CRM catalog.
	 * @return bool|string True or error message.
	 */
	public static function createCatalog($xmlcode)
	{
		$currentZone = Manager::getZone();
		$xmlProductCatalog = 'CRM_PRODUCT_CATALOG';
		$xmlPath = '/bitrix/components/bitrix/landing.demo/data/xml';
		$xmls = array(
			'catalog' => 0,
			'catalog_prices' => 0,
			'catalog_sku' => 0,
			'catalog_prices_sku' => 0
		);

		if (
			!\Bitrix\Main\Loader::includeModule('iblock') ||
			!\Bitrix\Main\Loader::includeModule('catalog')
		)
		{
			return Loc::getMessage('LANDING_CMP_ERROR_MASTER_NO_SERVICE');
		}

		self::createHLblocks();

		// ru-zones
		if (in_array($currentZone, array('ru')))
		{
			// import xml
			\Bitrix\Catalog\Product\Sku::disableUpdateAvailable();
			foreach ($xmls as $xml => &$bid)
			{
				$res = \importXMLFile(
					$xmlPath . '/' . $xmlcode . '_ru/' . $xml . '.xml',
					$xmlProductCatalog,
					array(SITE_ID),
					false, false, false,
					false, false, true,
					true
				);
				// error
				if (intval($res) <= 0)
				{
					return $res;
				}
				else
				{
					$bid = $res;
				}
			}
			\Bitrix\Catalog\Product\Sku::enableUpdateAvailable();

			// link iblocks
			$propId = \CCatalog::linkSKUIBlock(
				$xmls['catalog'],
				$xmls['catalog_sku']
			);
			$res = \CCatalog::getList(
				array(),
				array(
					'IBLOCK_ID' => $xmls['catalog_sku']
				),
				false,
				false,
				array(
					'IBLOCK_ID'
				)
			);
			if ($res->fetch())
			{
				\CCatalog::update(
					$xmls['catalog_sku'],
					array(
						'PRODUCT_IBLOCK_ID' => $xmls['catalog'],
						'SKU_PROPERTY_ID' => $propId
					)
				);
			}
			else
			{
				\CCatalog::add(array(
					'IBLOCK_ID' => $xmls['catalog_sku'],
					'PRODUCT_IBLOCK_ID' => $xmls['catalog'],
					'SKU_PROPERTY_ID' => $propId
				));
			}

			// additional updates -- common
			foreach (array('catalog', 'catalog_sku') as $ibCode)
			{
				$iblockId = $xmls[$ibCode];
				// uniq code
				$defValueCode = array (
					'UNIQUE' => 'Y',
					'TRANSLITERATION' => 'Y',
					'TRANS_LEN' => 100,
					'TRANS_CASE' => 'L',
					'TRANS_SPACE' => '_',
					'TRANS_OTHER' => '_',
					'TRANS_EAT' => 'Y',
					'USE_GOOGLE' => 'Y'
				);
				$iblock = new \CIBlock;
				$iblock->update($iblockId, array(
					'FIELDS' => array(
						'CODE' => array (
							'IS_REQUIRED' => 'N',
							'DEFAULT_VALUE' => $defValueCode
						),
						'SECTION_CODE' => array (
							'IS_REQUIRED' => 'N',
							'DEFAULT_VALUE' => $defValueCode
						)
					)
				));
				// delete all props
				$toDelete = array(
					/*'CML2_TAXES', 'CML2_BASE_UNIT', 'CML2_TRAITS', 'CML2_ATTRIBUTES', 'CML2_ARTICLE',
					'CML2_BAR_CODE', 'CML2_MANUFACTURER', */'CML2_PICTURES', 'CML2_FILES'
				);
				foreach ($toDelete as $code)
				{
					$res = \CIBlockProperty::getList(
						array(),
						array(
							'IBLOCK_ID' => $iblockId,
							'XML_ID' => $code
						)
					);
					if($row = $res->GetNext())
					{
						\CIBlockProperty::delete($row['ID']);
					}
				}
				// reindex
				$index = \Bitrix\Iblock\PropertyIndex\Manager::createIndexer(
					$iblockId
				);
				$index->startIndex();
				$index->continueIndex(0);
				$index->endIndex();
			}

			// update only for catalog - some magic
			$iblockId = $xmls['catalog'];
			$count = \Bitrix\Iblock\ElementTable::getCount(array(
				'=IBLOCK_ID' => $iblockId,
				'=WF_PARENT_ELEMENT_ID' => null
			));
			if ($count > 0)
			{
				$catalogReindex = new \CCatalogProductAvailable('', 0, 0);
				$catalogReindex->initStep($count, 0, 0);
				$catalogReindex->setParams(array(
					'IBLOCK_ID' => $iblockId
				));
				$catalogReindex->run();
			}

			// update only for offers - some magic
			$iblockId = $xmls['catalog_sku'];
			$count = \Bitrix\Iblock\ElementTable::getCount(array(
				'=IBLOCK_ID' => $iblockId,
				'=WF_PARENT_ELEMENT_ID' => null
			));
			if ($count > 0)
			{
				$catalogReindex = new \CCatalogProductAvailable('', 0, 0);
				$catalogReindex->initStep($count, 0, 0);
				$catalogReindex->setParams(array(
					'IBLOCK_ID' => $iblockId
				));
				$catalogReindex->run();
			}
			$iterator = \Bitrix\Catalog\ProductTable::getList(array(
				'select' => array(
					'ID'
				),
				'filter' => array(
					'=IBLOCK_ELEMENT.IBLOCK_ID' => $iblockId
				),
				'order' => array(
					'ID' => 'ASC'
				)
			));
			while ($row = $iterator->fetch())
			{
				$check = \Bitrix\Catalog\MeasureRatioTable::getList(array(
					'filter' => array(
						'PRODUCT_ID' => $row['ID'],
						'RATIO' => 1
					)
				));
				if (!$check->fetch())
				{
					\Bitrix\Catalog\MeasureRatioTable::add(array(
						'PRODUCT_ID' => $row['ID'],
						'RATIO' => 1
					));
				}
			}

			return true;
		}
		else
		{
			return Loc::getMessage('LANDING_CMP_ERROR_MASTER_NO_DATA');
		}
	}

	/**
	 * Base executable method.
	 * @return void
	 */
	public function executeComponent()
	{
		$init = $this->init();

		if ($init)
		{
			$this->checkParam('SITE_ID', 0);
			$this->checkParam('TYPE', '');
			$this->checkParam('ACTION_FOLDER', 'folderId');
			$this->checkParam('PAGE_URL_SITES', '');
			$this->checkParam('PAGE_URL_LANDING_VIEW', '');

			if ($this->arParams['SITE_ID'] > 0)
			{
				$this->arResult['DEMO'] = $this->getDemoPage();
				$this->arResult['LIMIT_REACHED'] = !Manager::checkFeature(
					Manager::FEATURE_CREATE_PAGE
				);
			}
			else
			{
				$this->arResult['DEMO'] = $this->getDemoSite();
				$this->arResult['LIMIT_REACHED'] = !Manager::checkFeature(
					Manager::FEATURE_CREATE_SITE
				);
			}
		}

		parent::executeComponent();
	}
}