<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

global $APPLICATION;

$aMenuLinksAdd=$APPLICATION->IncludeComponent("slam:menu.catalog", "", array(
    "IS_SEF" => "N",
    "SEF_BASE_URL" => "/catalog/",
    "SECTION_PAGE_URL" => "#SECTION_CODE#/",
    "DETAIL_PAGE_URL" => "#SECTION_CODE#/#ELEMENT_CODE#/",
    "IBLOCK_TYPE" => "catalog",
    "IBLOCK_ID" => "5",
    "DEPTH_LEVEL" => "1",
    "CACHE_TYPE" => "A",
    "CACHE_TIME" => "3600000"
),
    false
);
//pr($aMenuLinksAdd);
$aMenuLinks = array_merge($aMenuLinks,$aMenuLinksAdd);
?>