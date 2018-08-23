<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
use Bitrix\Main\Loader;
use Bitrix\Main\ModuleManager;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;
use Bitrix\Main\Web\Uri;
$this->setFrameMode(true);
?>
<?$this->SetViewTarget('header_css');?>
<?$APPLICATION->IncludeFile($arParams["SEF_FOLDER"]."css_head_list.php");?>
<?$this->EndViewTarget();?>

<?
global $USER;
$arParams['USE_FILTER'] = (isset($arParams['USE_FILTER']) && $arParams['USE_FILTER'] == 'Y' ? 'Y' : 'N');
$isFilter = ($arParams['USE_FILTER'] == 'Y');

if ($isFilter) {

    $arFilter = array(
        "IBLOCK_ID" => $arParams["IBLOCK_ID"],
        "ACTIVE" => "Y",
        "GLOBAL_ACTIVE" => "Y",
    );
    if (0 < intval($arResult["VARIABLES"]["SECTION_ID"]))
        $arFilter["ID"] = $arResult["VARIABLES"]["SECTION_ID"];
    elseif ('' != $arResult["VARIABLES"]["SECTION_CODE"])
        $arFilter["=CODE"] = $arResult["VARIABLES"]["SECTION_CODE"];
    else
        $arFilter["=ID"] = 0;

    $obCache = new CPHPCache();
    if ($obCache->InitCache(36000, serialize($arFilter), "/iblock/catalog")) {
        $arCurSection = $obCache->GetVars();
    } elseif ($obCache->StartDataCache()) {
        $arCurSection = array();
        if (Loader::includeModule("iblock")) {
            $dbRes = CIBlockSection::GetList(array(), $arFilter, false, array("ID"));

            if (defined("BX_COMP_MANAGED_CACHE")) {
                global $CACHE_MANAGER;
                $CACHE_MANAGER->StartTagCache("/iblock/catalog");

                if ($arCurSection = $dbRes->Fetch())
                    $CACHE_MANAGER->RegisterTag("iblock_id_" . $arParams["IBLOCK_ID"]);

                $CACHE_MANAGER->EndTagCache();
            } else {
                if (!$arCurSection = $dbRes->Fetch())
                    $arCurSection = array();
            }
        }
        $obCache->EndDataCache($arCurSection);
    }
    if (!isset($arCurSection))
        $arCurSection = array();

    $idContenerFilter =  $arParams["FILTER_CONTENER"] ? : 'ajax_filter';
    $this->SetViewTarget('aside_block_menu');?>
<div class="advanced-page__aside">
    <?
    /*
$APPLICATION->IncludeComponent(
    "bitrix:menu",
    "aside",
    array(
        "ROOT_MENU_TYPE" => "left",
        "MENU_CACHE_TYPE" => "Y",
        "MENU_CACHE_TIME" => "36000000",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "MENU_CACHE_GET_VARS" => array(),
        "MAX_LEVEL" => "1",
        "CHILD_MENU_TYPE" => "left",
        "USE_EXT" => "Y",
        "DELAY" => "N",
        "ALLOW_MULTI_SELECT" => "N",
        "COMPONENT_TEMPLATE" => ""
    ),
    false
);
//*/
    $APPLICATION->IncludeComponent(
        "bitrix:catalog.smart.filter",
        "catalog",
        array(

            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "SECTION_ID" => intval($arCurSection['ID']),
            "SECTION_CODE" => "",
            "FILTER_NAME" => $arParams["FILTER_NAME"],
            "FILTER_CONTENER" => $idContenerFilter,
            "HIDE_NOT_AVAILABLE" => "N",
            "TEMPLATE_THEME" => "blue",
            "FILTER_VIEW_MODE" => "horizontal",
            "DISPLAY_ELEMENT_COUNT" => "Y",
            "SEF_MODE" => "N",
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_FILTER" => $arParams["CACHE_FILTER"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],

            "SAVE_IN_SESSION" => "N",
            "INSTANT_RELOAD" => "Y",
            "PAGER_PARAMS_NAME" => "arrPager",
            "PRICE_CODE" => array(),
            "XML_EXPORT" => "N",
            "SECTION_TITLE" => "-",
            "SECTION_DESCRIPTION" => "-",
            "POPUP_POSITION" => "left",
            "SECTION_CODE_PATH" => "",
            "SMART_FILTER_PATH" => $arResult["FOLDER"],

        ),
        false, array('HIDE_ICONS' => 'Y')
    );?>
</div>
    <?$this->EndViewTarget();

}

?>

<div id="<?=$idContenerFilter?>"><?
    $AjaxCatalog = isset($_REQUEST[$idContenerFilter]) && 'Y' == $_REQUEST[$idContenerFilter];
    if ($AjaxCatalog) {
        $APPLICATION->RestartBuffer();
        if (!defined('PUBLIC_AJAX_MODE')) {
            define('PUBLIC_AJAX_MODE', true);
        }
        //удаляем параметр, чтобы случайно его не использовать!
        $request = Application::getInstance()->getContext()->getRequest()->getRequestUri();
        $uri = new Uri($request);
        $uri->deleteParams(array($idContenerFilter));
    }
?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:news.list",
            "",
            Array(
                "SECTION_PROPERTY_CHAR" => $arParams["SECTION_PROPERTY_CHAR"],
                "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
                "IBLOCK_ID" => $arParams["IBLOCK_ID"],
                "NEWS_COUNT" => $arParams["NEWS_COUNT"],
                "SORT_BY1" => $arParams["SORT_BY1"],
                "SORT_ORDER1" => $arParams["SORT_ORDER1"],
                "SORT_BY2" => $arParams["SORT_BY2"],
                "SORT_ORDER2" => $arParams["SORT_ORDER2"],
                "FIELD_CODE" => $arParams["LIST_FIELD_CODE"],
                "PROPERTY_CODE" => $arParams["LIST_PROPERTY_CODE"],
                "DISPLAY_PANEL" => $arParams["DISPLAY_PANEL"],
                "SET_TITLE" => $arParams["SET_TITLE"],
                "SET_LAST_MODIFIED" => $arParams["SET_LAST_MODIFIED"],
                "MESSAGE_404" => $arParams["MESSAGE_404"],
                "SET_STATUS_404" => $arParams["SET_STATUS_404"],
                "SHOW_404" => $arParams["SHOW_404"],
                "FILE_404" => $arParams["FILE_404"],
                "INCLUDE_IBLOCK_INTO_CHAIN" => $arParams["INCLUDE_IBLOCK_INTO_CHAIN"],
                "ADD_SECTIONS_CHAIN" => $arParams["ADD_SECTIONS_CHAIN"],
                "CACHE_TYPE" => $arParams["CACHE_TYPE"],
                "CACHE_TIME" => $arParams["CACHE_TIME"],
                "CACHE_FILTER" => $arParams["CACHE_FILTER"],
                "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
                "DISPLAY_TOP_PAGER" => $arParams["DISPLAY_TOP_PAGER"],
                "DISPLAY_BOTTOM_PAGER" => $arParams["DISPLAY_BOTTOM_PAGER"],
                "PAGER_TITLE" => $arParams["PAGER_TITLE"],
                "PAGER_TEMPLATE" => $arParams["PAGER_TEMPLATE"],
                "PAGER_SHOW_ALWAYS" => $arParams["PAGER_SHOW_ALWAYS"],
                "PAGER_DESC_NUMBERING" => $arParams["PAGER_DESC_NUMBERING"],
                "PAGER_DESC_NUMBERING_CACHE_TIME" => $arParams["PAGER_DESC_NUMBERING_CACHE_TIME"],
                "PAGER_SHOW_ALL" => $arParams["PAGER_SHOW_ALL"],
                "PAGER_BASE_LINK_ENABLE" => $arParams["PAGER_BASE_LINK_ENABLE"],
                "PAGER_BASE_LINK" => $arParams["PAGER_BASE_LINK"],
                "PAGER_PARAMS_NAME" => $arParams["PAGER_PARAMS_NAME"],
                "DISPLAY_DATE" => $arParams["DISPLAY_DATE"],
                "DISPLAY_NAME" => "Y",
                "DISPLAY_PICTURE" => $arParams["DISPLAY_PICTURE"],
                "DISPLAY_PREVIEW_TEXT" => $arParams["DISPLAY_PREVIEW_TEXT"],
                "PREVIEW_TRUNCATE_LEN" => $arParams["PREVIEW_TRUNCATE_LEN"],
                "ACTIVE_DATE_FORMAT" => $arParams["LIST_ACTIVE_DATE_FORMAT"],
                "USE_PERMISSIONS" => $arParams["USE_PERMISSIONS"],
                "GROUP_PERMISSIONS" => $arParams["GROUP_PERMISSIONS"],
                "FILTER_NAME" => $arParams["FILTER_NAME"],
                "HIDE_LINK_WHEN_NO_DETAIL" => $arParams["HIDE_LINK_WHEN_NO_DETAIL"],
                "CHECK_DATES" => $arParams["CHECK_DATES"],
                "STRICT_SECTION_CHECK" => $arParams["STRICT_SECTION_CHECK"],

                "PARENT_SECTION" => $arResult["VARIABLES"]["SECTION_ID"],
                "PARENT_SECTION_CODE" => $arResult["VARIABLES"]["SECTION_CODE"],
                "DETAIL_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["detail"],
                "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
                "IBLOCK_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["news"],
            ),
            $component
        );?>

<?
    if ($isFilter) {
        if($AjaxCatalog) die();

    ?></div><?
}?>

