<?
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
{
	die();
}

use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(
	\Bitrix\Landing\Manager::getDocRoot() .
	'/bitrix/modules/landing/blocks/.sections.php'
);

return array(
	'last' => Loc::getMessage('LD_BLOCK_SECTION_LAST'),
	'new_year' => Loc::getMessage('LD_BLOCK_SECTION_NEW_YEAR'),
	'cover' => Loc::getMessage('LD_BLOCK_SECTION_COVER'),
	'about' => Loc::getMessage('LD_BLOCK_SECTION_ABOUT'),
	'title' => Loc::getMessage('LD_BLOCK_SECTION_TITLE'),
	'text' => Loc::getMessage('LD_BLOCK_SECTION_TEXT'),
	'image' => Loc::getMessage('LD_BLOCK_SECTION_IMAGE'),
	'gallery' => Loc::getMessage('LD_BLOCK_SECTION_GALLERY'),
	'video' => Loc::getMessage('LD_BLOCK_SECTION_VIDEO'),
	'phrase' => Loc::getMessage('LD_BLOCK_SECTION_PHRASE'),
	'benefits' => Loc::getMessage('LD_BLOCK_SECTION_BENEFITS'),
	'columns' => Loc::getMessage('LD_BLOCK_SECTION_COLUMNS'),
	'separator' => Loc::getMessage('LD_BLOCK_SECTION_SEPARATOR'),
	'menu' => Loc::getMessage('LD_BLOCK_SECTION_MENU'),
	'footer' => Loc::getMessage('LD_BLOCK_SECTION_FOOTER'),
	'pages' => Loc::getMessage('LD_BLOCK_SECTION_PAGES'),
	'tiles' => Loc::getMessage('LD_BLOCK_SECTION_TILES'),
	'forms' => Loc::getMessage('LD_BLOCK_SECTION_FORMS'),
	'team' => Loc::getMessage('LD_BLOCK_SECTION_TEAM'),
	'feedback' => Loc::getMessage('LD_BLOCK_SECTION_FEEDBACK'),
	'schedule' => Loc::getMessage('LD_BLOCK_SECTION_SCHEDULE'),
	'steps' => Loc::getMessage('LD_BLOCK_SECTION_STEPS'),
	'contacts' => Loc::getMessage('LD_BLOCK_SECTION_CONTACTS'),
	'social' => Loc::getMessage('LD_BLOCK_SECTION_SOCIAL'),
	'tariffs' => Loc::getMessage('LD_BLOCK_SECTION_TARIFFS'),
	'partners' => Loc::getMessage('LD_BLOCK_SECTION_PARTNERS'),
	'holidays' => Loc::getMessage('LD_BLOCK_SECTION_HOLIDAYS'),
	'store' => Loc::getMessage('LD_BLOCK_SECTION_STORE'),
	'other' => Loc::getMessage('LD_BLOCK_SECTION_OTHER'),
	'popular' => Loc::getMessage('LD_BLOCK_SECTION_POPULAR'),
);