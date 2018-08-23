<?php
namespace Bitrix\Landing\PublicAction;

use \Bitrix\Landing\Error;
use \Bitrix\Landing\PublicActionResult;
use \Bitrix\Main\UrlPreview\UrlPreview;

class Utils
{
	/**
	 * Get meta-data by URL.
	 * @param string $url Url.
	 * @return \Bitrix\Landing\PublicActionResult
	 */
	public static function getUrlPreview($url)
	{
		$result = new PublicActionResult();

		if (is_string($url) && $url !== '')
		{
			$urlPreview = new UrlPreview();
			$result->setResult(
				$urlPreview->getMetadataByUrl($url)
			);
		}
		else
		{
			$error = new Error;
			$error->addError('EMPTY_URL', 'Empty URL');
			$result->setError($error);
		}

		return $result;
	}

	/**
	 * Save some internal settings.
	 * @param array $settings Settings array.
	 * @return \Bitrix\Landing\PublicActionResult
	 */
	public static function saveSettings(array $settings)
	{
		static $internal = true;

		$result = new PublicActionResult();
		$result->setResult(true);

		foreach ($settings as $key => $value)
		{
			\Bitrix\Main\Config\Option::set('landing', $key, $value);
		}

		return $result;
	}
}