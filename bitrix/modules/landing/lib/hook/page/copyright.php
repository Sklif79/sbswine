<?php
namespace Bitrix\Landing\Hook\Page;

use \Bitrix\Landing\Manager;
use \Bitrix\Landing\Field;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class Copyright extends \Bitrix\Landing\Hook\Page
{
	/**
	 * Map of the field.
	 * @return array
	 */
	protected function getMap()
	{
		return array(
			'SHOW' => new Field\Checkbox('SHOW', array(
				'title' => Loc::getMessage('LANDING_HOOK_COPYRIGHT_SHOW')
			))
		);
	}

	/**
	 * Enable only in high plan.
	 * @return boolean
	 */
	public function isFree()
	{
		return false;
	}

	/**
	 * Enable or not the hook.
	 * @return boolean
	 */
	public function enabled()
	{
		return $this->fields['SHOW']->getValue() != 'N';
	}

	/**
	 * Exec hook. Show or not any copiright.
	 * @return boolean
	 */
	public function exec()
	{
		return true;
	}
}
