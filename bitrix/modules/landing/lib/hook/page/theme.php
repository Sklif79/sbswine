<?php
namespace Bitrix\Landing\Hook\Page;

use \Bitrix\Landing\Field;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

class Theme extends \Bitrix\Landing\Hook\Page
{
	/**
	 * Relative (dir template) path for themes.
	 */
	const THEME_RELATIVE_PATH = '/themes/';

	/**
	 * Map of the field.
	 * @return array
	 */
	protected function getMap()
	{
		return array(
			'CODE' => new Field\Select('CODE', array(
				'title' => Loc::getMessage('LANDING_HOOK_THEMECODE'),
				'options' => array(
					'' => Loc::getMessage('LANDING_HOOK_THEMECODE_DEF'),
					'1construction' => Loc::getMessage('LANDING_HOOK_THEMECODE_CONSTRUCTION'),
					'2business' => Loc::getMessage('LANDING_HOOK_THEMECODE_BUSINESS'),
					'3corporate' => Loc::getMessage('LANDING_HOOK_THEMECODE_CORPORATE'),
					'accounting' => 'accounting',
					'agency' => 'agency',
					'app' => 'app',
					'architecture' => 'architecture',
					'charity' => 'charity',
					'consulting' => 'consulting',
					'courses' => 'courses',
					'event' => 'event',
					'gym' => 'gym',
					'lawyer' => 'lawyer',
					'music' => 'music',
					'photography' => 'photography',
					'real-estate' => 'real-estate',
					'restaurant' => 'restaurant',
					'shipping' => 'shipping',
					'spa' => 'spa',
					'travel' => 'travel',
					'wedding' => 'wedding',
				)
			))
		);
	}

	/**
	 * Enable or not the hook.
	 * @return boolean
	 */
	public function enabled()
	{
		return trim($this->fields['CODE']) != '';
	}

	/**
	 * Exec hook.
	 * @return void
	 */
	public function exec()
	{
		$code = \htmlspecialcharsbx(trim($this->fields['CODE']));
		\Bitrix\Landing\Manager::setThemeId($code);
	}
}
