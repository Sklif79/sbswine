<?php
namespace Bitrix\Landing;

use \Bitrix\Main\Localization\Loc;
use \Bitrix\Main\Config\Option;
use \Bitrix\Main\Application;
use \Bitrix\Main\Entity;

Loc::loadMessages(__FILE__);

class Manager
{
	/**
	 * Feature name for create new site.
	 */
	const FEATURE_CREATE_SITE = 'create_site';

	/**
	 * Feature name for create new page.
	 */
	const FEATURE_CREATE_PAGE = 'create_page';

	/**
	 * Feature name for allow custom domain name.
	 */
	const FEATURE_CUSTOM_DOMAIN = 'custom_domain';

	/**
	 * Feature name for enable all hooks.
	 */
	const FEATURE_ENABLE_ALL_HOOKS = 'enable_all_hooks';

	/**
	 * Selected template theme id.
	 * @var string
	 */
	private static $themeId = '';

	/**
	 * Get main instance of \CMain.
	 * @return \CMain
	 */
	public static function getApplication()
	{
		return $GLOBALS['APPLICATION'];
	}

	/**
	 * Get main instance of \CUser.
	 * @return \CUser
	 */
	public static function getUserInstance()
	{
		return $GLOBALS['USER'];
	}

	/**
	 * Get instance of CACHE_MANAGER;
	 * @return \CCacheManager
	 */
	public static function getCacheManager()
	{
		return $GLOBALS['CACHE_MANAGER'];
	}

	/**
	 * Get instance of USER_FIELD_MANAGER.
	 * @return \CUserTypeManager
	 */
	public static function getUfManager()
	{
		return $GLOBALS['USER_FIELD_MANAGER'];
	}

	/**
	 * Get current user id.
	 * @return int
	 */
	public static function getUserId()
	{
		$user = self::getUserInstance();
		if ($user instanceof \CUser)
		{
			return $user->getId();
		}
		return 0;
	}

	/**
	 * Admin or not.
	 * @return boolean
	 */
	public static function isAdmin()
	{
		$user = self::getUserInstance();

		if (\Bitrix\Main\ModuleManager::isModuleInstalled('bitrix24'))
		{
			return $user->canDoOperation('bitrix24_config');
		}
		else
		{
			return $user->isAdmin();
		}
	}

	/**
	 * Get option from module settings.
	 * @param string $code Option code.
	 * @param mixed $default Default value.
	 * @return type
	 */
	public static function getOption($code, $default = null)
	{
		return Option::get('landing', $code, $default);
	}

	/**
	 * Famous document root.
	 * @return string
	 */
	public static function getDocRoot()
	{
		static $docRoot = null;

		if ($docRoot === null)
		{
			$context = Application::getInstance()->getContext();
			$server = $context->getServer();
			$docRoot = $server->getDocumentRoot();
		}

		return $docRoot;
	}

	/**
	 * Get path for publication sites.
	 * @param string|int $siteCode Site id or site code.
	 * @return string
	 */
	public static function getPublicationPath($siteCode)
	{
		$path = '/pub/site/#id#/';
		return str_replace('#id#', $siteCode, $path);
	}

	/**
	 * Add some class to some marker.
	 * @param string $marker Marker.
	 * @param string $class Class.
	 * @deprecated since version 18.1.5
	 * @return void
	 */
	public static function setPageClass($marker, $class)
	{
		self::setPageView($marker, $class);
	}

	/**
	 * Add some content to some marker.
	 * @param string $marker Marker.
	 * @param string $content Content.
	 * @return void
	 */
	public static function setPageView($marker, $content)
	{
		$content = trim($content);
		if ($content)
		{
			$application = self::getApplication();
			$existClass = $application->getPageProperty($marker);
			$application->setPageProperty(
				$marker,
				$existClass . ($existClass != '' ? ' ' : '') . $content
			);
		}
	}

	/**
	 * Get some content from some marker.
	 * @param string $marker Marker.
	 * @return string
	 */
	public static function getPageView($marker)
	{
		return self::getApplication()->getPageProperty($marker);
	}

	/**
	 * Get themes from template dir.
	 * @param string $tplId Site template id.
	 * @return array
	 */
	public static function getThemes($tplId)
	{
		$themes = array();

		$path = self::getDocRoot() . getLocalPath('templates/' . $tplId) . '/themes/';
		if (($handle = opendir($path)))
		{
			while ((($entry = readdir($handle)) !== false))
			{
				if ($entry != '.' && $entry != '..')
				{
					$themes[] = pathinfo($entry, PATHINFO_FILENAME);
				}
			}
		}

		return $themes;
	}

	/**
	 * Get site template id for landing view.
	 * @return string
	 */
	public static function getTemplateId()
	{
		static $tplId = null;

		if ($tplId === null)
		{
			$tplId = self::getOption('site_template_id', 'landing24');
		}

		return $tplId;
	}

	/**
	 * Set new colored theme id.
	 * @param string $themeId Theme id.
	 * @return void
	 */
	public static function setThemeId($themeId)
	{
		self::$themeId = $themeId;
	}

	/**
	 * Set current selected or default color theme.
	 * @return void
	 */
	public static function setTheme()
	{
		$tplId = self::getTemplateId();
		$themes = Manager::getThemes($tplId);

		if (
			!self::$themeId ||
			!in_array(self::$themeId, $themes)
		)
		{
			self::setThemeId(array_pop($themes));
		}

		if (self::$themeId)
		{
			$themePath = \getLocalPath('templates/' . $tplId, BX_PERSONAL_ROOT) . '/themes/' . self::$themeId;
			$themePathAbsolute = self::getDocRoot() . $themePath;
			if (is_dir($themePathAbsolute))
			{
				if ($handle = opendir($themePathAbsolute))
				{
					while (($file = readdir($handle)) !== false)
					{
						if ($file != '.' && $file != '..')
						{
							\Bitrix\Main\Page\Asset::getInstance()->addCSS($themePath . '/' . $file);
						}
					}
					closedir($handle);
				}
			}
			elseif (is_file($themePathAbsolute . '.css'))
			{
				\Bitrix\Main\Page\Asset::getInstance()->addCSS($themePath . '.css');
			}
		}
	}

	/**
	 * Save picture to db.
	 * @param mixed $file File array or path to file.
	 * @param string $ext File extension (if can't detected by file name).
	 * @param array $params Some file params.
	 * @return array|false Local file array or false on error.
	 */
	public static function savePicture($file, $ext = false, $params = array())
	{
		// url of picture
		if (!is_array($file))
		{
			$httpClient = new \Bitrix\Main\Web\HttpClient();
			$httpClient->setTimeout(5);
			$httpClient->setStreamTimeout(5);
			$urlComponents = parse_url($file);

			// detect tmp file name
			if ($urlComponents && $urlComponents['path'] != '')
			{
				$tempPath = \CFile::getTempName('', bx_basename(urldecode($urlComponents['path'])));
			}
			else
			{
				$tempPath = \CFile::getTempName('', bx_basename(urldecode($file)));
			}
			if ($ext !== false && in_array($ext, explode(',', \CFile::getImageExtensions())))
			{
				if (substr($tempPath, -3) != $ext)
				{
					$tempPath = $tempPath . '.' . $ext;
				}
			}

			// download and save
			if ($httpClient->download($file, $tempPath))
			{
				$fileName = $httpClient->getHeaders()->getFilename();
				$file = \CFile::makeFileArray($tempPath);
				if ($file && $fileName)
				{
					$file['name'] = $fileName;
				}
			}
		}

		// base64
		elseif (
			is_array($file) &&
			isset($file[0]) &&
			isset($file[1])
		)
		{
			$tempPath = \CFile::getTempName('', $file[0]);
			$fileIO = new \Bitrix\Main\IO\File(
				$tempPath
			);
			$fileIO->putContents(
				base64_decode($file[1])
			);
			$file = \CFile::makeFileArray($tempPath);
		}

		// post array or file from prev. steps
		if (\CFile::checkImageFile($file, 0, 0, 0, array('IMAGE')) === null)
		{
			// resize if need
			if (
				isset($params['width']) &&
				isset($params['height'])
			)
			{
				$params['width'] = intval($params['width']);
				$params['height'] = intval($params['height']);
				\CFile::resizeImage(
					$file,
					$params,
					isset($params['resize_type'])
					? $params['resize_type']
					: BX_RESIZE_IMAGE_PROPORTIONAL);
			}
			// save
			$module = 'landing';
			$file['MODULE_ID'] = $module;
			$file = \CFile::saveFile($file, $module);
			if ($file)
			{
				$file = \CFile::getFileArray($file);
			}
			if ($file)
			{
				return $file;
			}
		}

		return false;
	}

	/**
	 * Check is feature is enabled.
	 * @param string $feature Featire name.
	 * @return boolean
	 */
	public static function checkFeature($feature)
	{
		if ($feature == self::FEATURE_CREATE_SITE)
		{
			$limit = self::getOption('site_limit_count');
			if ($limit)
			{
				$check = Site::getList(array(
					'select' => array(
						'CNT' => new Entity\ExpressionField('CNT', 'COUNT(ID)')
					),
					'filter' => array(
						'CHECK_PERMISSIONS' => 'N'
					),
					'group' => array()
				))->fetch();
				if ($check && $check['CNT'] >= $limit)
				{
					return false;
				}
			}
			return true;
		}
		elseif ($feature == self::FEATURE_CREATE_PAGE)
		{
			$limit = self::getOption('pages_limit_count');
			if ($limit)
			{
				$check = Landing::getList(array(
					'select' => array(
						'CNT' => new Entity\ExpressionField('CNT', 'COUNT(ID)')
					),
					'filter' => array(
						'CHECK_PERMISSIONS' => 'N'
					),
					'group' => array()
				))->fetch();
				if ($check && $check['CNT'] >= $limit)
				{
					return false;
				}
			}
			return true;
		}
		elseif ($feature == self::FEATURE_CUSTOM_DOMAIN)
		{
			return (int)self::getOption('site_custom_domain_allow') > 0;
		}
		elseif ($feature == self::FEATURE_ENABLE_ALL_HOOKS)
		{
			if (!\Bitrix\Main\Loader::includeModule('bitrix24'))
			{
				return true;
			}
			return \CBitrix24::isLicensePaid();
		}

		return false;
	}

	/**
	 * Get site zone (ru, ua, en, etc).
	 * @return string
	 */
	public static function getZone()
	{
		if (\Bitrix\Main\Loader::includeModule('bitrix24'))
		{
			$zone = \CBitrix24::getPortalZone();
		}
		else
		{
			$zone = Application::getInstance()->getContext()->getLanguage();
		}

		return $zone;
	}
}