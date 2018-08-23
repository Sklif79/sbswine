<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$aMenuLinksAdd=$APPLICATION->IncludeComponent("bitrix:menu.sections", "", array(
    "IS_SEF" => "N",
    "SEF_BASE_URL" => "/about/news_events/",
    "SECTION_PAGE_URL" => "#SECTION_CODE#/",
    "DETAIL_PAGE_URL" => "#SECTION_CODE#/#ELEMENT_CODE#/",
    "IBLOCK_TYPE" => "content",
    "IBLOCK_ID" => "3",
    "DEPTH_LEVEL" => "1",
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "3600000"
),
    false
);

$aMenuLinks = array_merge($aMenuLinks,$aMenuLinksAdd);
?>