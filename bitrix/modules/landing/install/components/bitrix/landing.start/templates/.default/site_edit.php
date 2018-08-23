<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
{
	die();
}
?>

<?if ($arResult['VARS']['site_edit']):?>

	<?$APPLICATION->IncludeComponent(
		'bitrix:landing.site_edit',
		'.default',
		array(
			'TYPE' => $arParams['TYPE'],
			'SITE_ID' => $arResult['VARS']['site_edit'],
			'PAGE_URL_SITES' => $arParams['PAGE_URL_SITES'],
			'PAGE_URL_LANDING_VIEW' => $arParams['PAGE_URL_LANDING_VIEW']
		),
		$component
	);?>

<?else:?>

	<?$APPLICATION->IncludeComponent(
		'bitrix:landing.demo',
		'.default',
		array(
			'TYPE' => $arParams['TYPE'],
			'PAGE_URL_SITES' => $arParams['PAGE_URL_SITES'],
			'PAGE_URL_LANDING_VIEW' => $arParams['PAGE_URL_LANDING_VIEW']
		),
		$component
	);?>

<?endif;?>
