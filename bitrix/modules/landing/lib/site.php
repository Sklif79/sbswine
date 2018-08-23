<?php
namespace Bitrix\Landing;

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class Site extends \Bitrix\Landing\Internals\BaseTable
{
	/**
	 * Internal class.
	 * @var string
	 */
	public static $internalClass = 'SiteTable';

	/**
	 * Get public url for site.
	 * @param int $id Site id.
	 * @param boolean $full Return full site url with relative path.
	 * @return string
	 */
	public static function getPublicUrl($id, $full = true)
	{
		$res = self::getList(array(
			'select' => array(
				'DOMAIN_PROTOCOL' => 'DOMAIN.PROTOCOL',
				'DOMAIN_NAME' => 'DOMAIN.DOMAIN',
				'CODE'
			),
			'filter' => array(
				'ID' => $id
			)
		));
		if ($row = $res->fetch())
		{
			$bitrix24 = \Bitrix\Main\ModuleManager::isModuleInstalled('bitrix24');
			return $row['DOMAIN_PROTOCOL'] . '://' .
					$row['DOMAIN_NAME'] .
					(!$bitrix24 ? '/pub/site' : '') . //@todo
					(!$bitrix24 && $full ? $row['CODE'] : '');
		}
		return '';
	}

	/**
	 * Get hooks of Site.
	 * @param int $id Site id.
	 * @return array Array of Hook.
	 */
	public static function getHooks($id)
	{
		return Hook::getForSite($id);
	}


	/**
	 * Get additional fields of Landing.
	 * @param int $id Landing id.
	 * @return array Array of Field.
	 */
	public static function getAdditionalFields($id)
	{
		$fields = array();

		// now we can get additional fields only from hooks
		foreach (self::getHooks($id) as $hook)
		{
			$fields += $hook->getPageFields();
		}

		return $fields;
	}

	/**
	 * Save additional fields for Site.
	 * @param int $id Site id.
	 * @param array $data Data array.
	 * @return void
	 */
	public static function saveAdditionalFields($id, array $data)
	{
		// now we can get additional fields only from hooks
		Hook::saveForSite($id, $data);
	}

	/**
	 * Get existed site types.
	 * @return array
	 */
	public static function getTypes()
	{
		static $types = null;

		if ($types !== null)
		{
			return $types;
		}

		$types = array(
			'PAGE' => Loc::getMessage('LANDING_TYPE_PAGE'),
			'STORE' => Loc::getMessage('LANDING_TYPE_STORE')
		);

		return $types;
	}

	/**
	 * Get default site type.
	 * @return string
	 */
	public static function getDefaultType()
	{
		return 'PAGE';
	}

	/**
	 * Delete site by id.
	 * @param int $id Site id.
	 * @return \Bitrix\Main\Result
	 */
	public static function delete($id)
	{
		$result = parent::delete($id);
		return $result;
	}
}