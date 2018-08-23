<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)
{
	die();
}

\Bitrix\Landing\Update\Stepper::show();
?>

<?$result = $APPLICATION->IncludeComponent(
	'bitrix:landing.sites',
	'.default',
	array(
		'TYPE' => $arParams['TYPE'],
		'PAGE_URL_SITE' => $arParams['PAGE_URL_SITE_SHOW'],
		'PAGE_URL_SITE_EDIT' => $arParams['PAGE_URL_SITE_EDIT'],
		'PAGE_URL_LANDING_EDIT' => $arParams['PAGE_URL_LANDING_EDIT']
	),
	$component
);?>

<?/*if (empty($result['SITES'])):?>
	<?$APPLICATION->IncludeComponent(
		'bitrix:landing.demo',
		'.default',
		array(
			'PAGE_URL_SITES' => $arParams['PAGE_URL_SITES'],
			'PAGE_URL_LANDING_VIEW' => $arParams['PAGE_URL_LANDING_VIEW']
		),
		$component
	);?>
<?endif;*/?>