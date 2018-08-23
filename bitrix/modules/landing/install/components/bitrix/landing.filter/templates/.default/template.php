<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if ($arResult['FATAL'])
{
	return;
}

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$curUrl = $request->getRequestUri();

$uriAjax = new \Bitrix\Main\Web\Uri($curUrl);
$uriAjax->addParams(array(
	'IS_AJAX' => 'Y'
));

$isBitrix24Template = SITE_TEMPLATE_ID === 'bitrix24';

$bodyClass = $APPLICATION->GetPageProperty('BodyClass');
$APPLICATION->SetPageProperty('BodyClass', ($bodyClass ? $bodyClass.' ' : '') . 'pagetitle-toolbar-field-view');
?>

<?php
if ($isBitrix24Template)
{
	$this->SetViewTarget('inside_pagetitle');
}
?>

<?if (!$isBitrix24Template):?>
<div class="tasks-interface-filter-container">
<?endif;?>

	<div class="pagetitle-container<?if (!$isBitrix24Template) {?> pagetitle-container-light<?}?> pagetitle-flexible-space">
		<?$APPLICATION->IncludeComponent(
			'bitrix:main.ui.filter',
			'',
			array(
				'FILTER_ID' => $arParams['FILTER_ID'],
				'GRID_ID' => $arParams['FILTER_ID'],
				'FILTER' => array(),
				'FILTER_PRESETS' => array(),
				'ENABLE_LABEL' => true,
				'ENABLE_LIVE_SEARCH' => true,
				'RESET_TO_DEFAULT_MODE' => true
			),
			$this->__component,
			array('HIDE_ICONS' => true)
		);?>
		<script type="text/javascript">
			var landingAjaxPath = '<?= \CUtil::jsEscape($uriAjax->getUri());?>';
		</script>
	</div>

	<style type="text/css">
		#popup-window-content-<?= $arParams['FILTER_ID']?>_search_container {
			display: none!important;
		}
	</style>

	<?if ($arParams['BUTTON_ACTION_LINK'] && $arParams['BUTTON_ACTION_TITLE']):?>
	<div class="pagetitle-container pagetitle-align-right-container">
		<a href="<?= $arParams['BUTTON_ACTION_LINK']?>" class="webform-small-button webform-small-button-blue">
			<?= $arParams['BUTTON_ACTION_TITLE']?>
		</a>
	</div>
	<?endif;?>

<?if (!$isBitrix24Template):?>
</div>
<?endif;?>

<?php
if ($isBitrix24Template)
{
	$this->EndViewTarget();
}
?>