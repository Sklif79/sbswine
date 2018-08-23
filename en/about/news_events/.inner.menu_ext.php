<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$aMenuLinksAdd=$APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
    "IS_SEF" => "N",
    "SEF_BASE_URL" => "/en/about/news_events/",
    "SECTION_PAGE_URL" => "#SECTION_CODE#/",
    "DETAIL_PAGE_URL" => "#SECTION_CODE#/#ELEMENT_CODE#/",
    "IBLOCK_TYPE" => "content",
    "IBLOCK_ID" => "20",
    "DEPTH_LEVEL" => "1",
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "360000000"
),
    false,array("HIDE_ICONS" =>"Y")
);

$aMenuLinks = array_merge($aMenuLinks,$aMenuLinksAdd);
?>