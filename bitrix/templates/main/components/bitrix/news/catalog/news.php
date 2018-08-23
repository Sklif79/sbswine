<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
?>
<?$this->SetViewTarget('header_css');?>
<?$APPLICATION->IncludeFile($arParams["SEF_FOLDER"]."css_head_news.php");?>
<?$this->EndViewTarget();?>

<?$this->SetViewTarget('header_block_title');?>
    <h1><?=GetMessage("NAIN_CATALOG_TITLE")?></h1>
<?$this->EndViewTarget();?>

<?$this->SetViewTarget('aside_block_menu');?>
<? $APPLICATION->IncludeComponent(
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
); ?>

<?$this->EndViewTarget();
//*/?>
<div class="index-services index-services--advanced">
    <?$APPLICATION->IncludeFile(
        $arParams['SEF_FOLDER'].'seo_top_news.php',
        Array(),
        Array("MODE"=>"html", "SHOW_BORDER" => true, "NAME" => "SEO TOP", 'TEMPLATE' => 'default.php')
    );?>
    <?$APPLICATION->IncludeComponent(
        "bitrix:catalog.section.list",
        "sections",
        array(
            "IBLOCK_TYPE" => $arParams["IBLOCK_TYPE"],
            "IBLOCK_ID" => $arParams["IBLOCK_ID"],
            "CACHE_TYPE" => $arParams["CACHE_TYPE"],
            "CACHE_TIME" => $arParams["CACHE_TIME"],
            "CACHE_GROUPS" => $arParams["CACHE_GROUPS"],
            "COUNT_ELEMENTS" => $arParams["SECTION_COUNT_ELEMENTS"],
            "TOP_DEPTH" => $arParams["SECTION_TOP_DEPTH"],
            "PAGINATION_COUNT" => $arParams["PAGINATION_COUNT"],
            "SECTION_URL" => $arResult["FOLDER"].$arResult["URL_TEMPLATES"]["section"],
            "VIEW_MODE" => $arParams["SECTIONS_VIEW_MODE"],
            "DISPLAY_SECTION_IMG_WIDTH" => $arParams["DISPLAY_SECTION_IMG_WIDTH"],
            "DISPLAY_SECTION_IMG_HEIGHT" => $arParams["DISPLAY_SECTION_IMG_HEIGHT"],
            "TYPE_IMG_THUMB" => $arParams["TYPE_IMG_THUMB"],
            'SECTION_USER_FIELDS' => array('UF_*'),
            "SHOW_PARENT_NAME" => $arParams["SECTIONS_SHOW_PARENT_NAME"]
        ),
        $component
    );
    ?>

</div>
<?$APPLICATION->IncludeFile(
    $arParams['SEF_FOLDER'].'seo_footer_news.php',
    Array(),
    Array("MODE"=>"html", "SHOW_BORDER" => true, "NAME" => "SEO FOOTER", 'TEMPLATE' => 'default.php')
);?>

<?//*/?>
<?$this->SetViewTarget('footer_view_text');?>
<?$APPLICATION->IncludeFile(
    SITE_DIR . 'include/block_list_brands.php',
    Array(),
    Array("MODE" => "text", "SHOW_BORDER" => false, 'TEMPLATE' => 'default.php')
);?>

<?$this->EndViewTarget();?>





