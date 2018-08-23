<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("History");
?>
    <div class="news-page-inner-item">
    <div class="news-page-inner-item__block animateThis" data-anim="fadeInUp">
        <h2>Every day we are engaged in wine</h2>
        <p>Вот уже 20 лет наша команда тщательно выбирает напитки, достойные и соответствующие предпочтениям наших клиентов. Не важно, ищете ли вы «то самое вино» или хотите открыть что-то новое, планируете семейный ужин или грандиозный банкет – вы можете полностью на нас положиться</p>
    </div>
<?
$APPLICATION->IncludeComponent(
	"bitrix:news.list", 
	"inner_page_slider", 
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
			2 => "",
		),
		"FILTER_NAME" => "filterMainSlider",
		"IBLOCK_ID" => "15",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "15",
		"PARENT_SECTION" => "13",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(
			0 => "LINK",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N",
		"COMPONENT_TEMPLATE" => "inner_page_slider",
		"DETAIL_URL" => "",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"SET_META_KEYWORDS" => "Y",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "News",
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
    <div class="news-page-inner-item__block animateThis" data-anim="fadeInUp">
        <h3 class="upper">миссия наших магазинов</h3>
        <p>Главная миссия наших магазинов и компании в целом — повышать качество жизни людей в Беларуси, посвящая их в секреты мировой культуры пития. С нами вы обнаружите, что поход за покупками может превратиться в захватывающее событие, о котором вы будете рассказывать снова и снова</p>
        <ul>
            <li><span>Сорта разных ценовых категорий</span></li>
            <li><span>Много сортов</span></li>
            <li><span>Душевная атмосфера</span></li>
            <li><span>Удобство расположения</span></li>
            <li><span>Преимиальный алкоголь</span></li>
        </ul>
    </div>
    </div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>