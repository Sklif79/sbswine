<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();



$obCache = new CPHPCache;
$life_time = 86400*7;
$IBLOCK_ID = 4;


$cache_id = "menuItem".SITE_ID.$IBLOCK_ID;
$cache_path = "/servicesMenu/".SITE_ID."/".$IBLOCK_ID."/";

if($obCache->InitCache($life_time, $cache_id, $cache_path)) :
    $vars = $obCache->GetVars();
    $aMenuLinksExt = $vars["SECTION_TITLE"];


else :
    CModule::IncludeModule("iblock");
    global $CACHE_MANAGER;
    $CACHE_MANAGER->StartTagCache($cache_path);
    $CACHE_MANAGER->RegisterTag("iblock_id_".$IBLOCK_ID);

    $arOrder = Array("SORT"=>"ASC");
    $arSelect = Array("ID", "NAME", "IBLOCK_ID", "DETAIL_PAGE_URL");
    $arFilter = Array(
        "IBLOCK_ID"=>$IBLOCK_ID,
        "ACTIVE"=>"Y"
    );
    $res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);

    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $aMenuLinksExt[] = Array(
            strip_tags($arFields['~NAME']),
            $arFields['DETAIL_PAGE_URL'],
            Array(),
            Array(),
            ""
        );
    }


    $CACHE_MANAGER->EndTagCache();

    if($obCache->StartDataCache()):
        $obCache->EndDataCache(array(
            "SECTION_TITLE" => $aMenuLinksExt
        ));

    endif;

endif;
//*/


/*
    $IBLOCK_ID = 4;
    $arOrder = Array("SORT"=>"ASC");
    $arSelect = Array("ID", "NAME", "IBLOCK_ID", "DETAIL_PAGE_URL");
    $arFilter = Array(
        "IBLOCK_ID"=>$IBLOCK_ID,
        "ACTIVE"=>"Y"
    );
    $res = CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);

    while($arFields = $res->GetNext())
    {

        $aMenuLinksExt[] = Array(
            strip_tags($arFields['~NAME']),
            $arFields['DETAIL_PAGE_URL'],
            Array(),
            Array(),
            ""
        );
    }
//*/

$aMenuLinks = array_merge($aMenuLinksExt, $aMenuLinks);


?>