<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "купить вино в минске");
$APPLICATION->SetPageProperty("title", "Карта сайта сети магазинов \"ВИНО\"");
$APPLICATION->SetPageProperty("description", "Сеть магазинов ВИНО в формате \" У дома\"");
$APPLICATION->SetTitle("Карта сайта сети магазинов \"ВИНО\"");
?>


<? $APPLICATION->IncludeComponent(
    "bitrix:menu",
    "sitemap",
    array(
        "ROOT_MENU_TYPE" => "sitemap",
        "MENU_CACHE_TYPE" => "Y",
        "MENU_CACHE_TIME" => "36000000",
        "MENU_CACHE_USE_GROUPS" => "Y",
        "MENU_CACHE_GET_VARS" => array(),
        "MAX_LEVEL" => "2",
        "CHILD_MENU_TYPE" => "left",
        "USE_EXT" => "Y",
        "DELAY" => "N",
        "ALLOW_MULTI_SELECT" => "N",
        "COMPONENT_TEMPLATE" => ""
    ),
    false
);?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>