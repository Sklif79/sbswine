<?
require_once($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");

$err_list = $_REQUEST["ID_COUNTRY"];


//print json_encode(array('status' => $status, 'params' => $arResult, 'message' => $err_list, 'NEW_ID' => $ID));

$GLOBALS['arrFilteBrandAjax']['PROPERTY_COUNTRY_VALUE'] = $_REQUEST["ID_COUNTRY"];


$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "list_brands",
    array(
        "IS_AJAX"	=>	"Y",
        "ACTIVE_DATE_FORMAT" => "",
        "ADD_SECTIONS_CHAIN" => "N",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "Y",
        "SET_TITLE" => "N",
        "CACHE_TIME" => "360000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array(
            0 => "PREVIEW_TEXT",
            1 => "PREVIEW_PICTURE",
        ),
        "FILTER_NAME" => "arrFilteBrandAjax",
        "IBLOCK_ID" => $_REQUEST["IBLOCK_ID"],
        "IBLOCK_TYPE" => "content",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "70",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array(
            0 => "LINK",
        ),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",

        "SORT_BY1" => "SORT",
        "SORT_BY2" => "ID",
        "SORT_ORDER1" => "",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N",
        "COMPONENT_TEMPLATE" => "index_page_slider",

    ),
    false
);?>


