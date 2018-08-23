<?

$APPLICATION->SetTitle($arResult["SECTION_NAME"]);

if(!empty($arResult['OG'])){
    $APPLICATION->AddHeadString('<meta property="og:description" content="'.substr(strip_tags($arResult["~DETAIL_TEXT"]),"0","200").'" /> ',true);
    $APPLICATION->AddHeadString('<meta property="og:title" content="'.$arResult['OG']['OG_TITLE'].'" /> ',true);
    if($arResult['OG']['OG_IMAGE']){
        $APPLICATION->AddHeadString('<meta property="og:image" content="'.$arResult['OG']['OG_IMAGE'].'" /> ',true);
        $APPLICATION->AddHeadString('<meta property="og:image:width" content="'.$arResult['OG']['OG_IMAGE_WIDTH'].'" /> ',true);
        $APPLICATION->AddHeadString('<meta property="og:image:height" content="'.$arResult['OG']['OG_IMAGE_HEIGHT'].'" /> ',true);
    }
}

$GLOBALS["DETAIL_TEXT"] = $arResult["~DETAIL_TEXT"];
$GLOBALS["CATALOG_HIDDEN_NAME"] = $arResult["NAME"];

if(count($arResult["PROPERTIES"]["SHOPS"]["VALUE"])>0 && $arResult["PROPERTIES"]["SHOPS"]["VALUE"][0]){
    $GLOBALS["SHOP_INFO"]["ID"] = $arResult["PROPERTIES"]["SHOPS"]["VALUE"];
    $GLOBALS["SHOP_INFO"]["IBLOCK_ID"] = $arResult["PROPERTIES"]["SHOPS"]["LINK_IBLOCK_ID"];
}