<?
if(intval($arResult["CONSULTANT_INFO"]["ID"])>0){
    $GLOBALS["CONSULTANT_INFO"] = $arResult["CONSULTANT_INFO"];
}
$GLOBALS["SERVICES_HIDDEN_NAME"] = $arResult["NAME"];
if(!empty($arResult['OG'])){
    $APPLICATION->AddHeadString('<meta property="og:description" content="'.$arResult['OG']['OG_DESC'].'" /> ',true);
    $APPLICATION->AddHeadString('<meta property="og:title" content="'.$arResult['OG']['OG_TITLE'].'" /> ',true);
    if($arResult['OG']['OG_IMAGE']){
        $APPLICATION->AddHeadString('<meta property="og:image" content="'.$arResult['OG']['OG_IMAGE'].'" /> ',true);
        $APPLICATION->AddHeadString('<meta property="og:image:width" content="'.$arResult['OG']['OG_IMAGE_WIDTH'].'" /> ',true);
        $APPLICATION->AddHeadString('<meta property="og:image:height" content="'.$arResult['OG']['OG_IMAGE_HEIGHT'].'" /> ',true);
    }
}