<?


if(intval($arResult['~DETAIL_PICTURE']) > 0) {
    $arResult['RESIZE_IMG'] = CFile::ResizeImageGet(
        $arResult['~DETAIL_PICTURE'],
        array("width" => "750", "height" => "600"),
        BX_RESIZE_IMAGE_PROPORTIONAL,
        //BX_RESIZE_IMAGE_EXACT,
        true
    );
}

if(count($arResult['PROPERTIES']["SLIDER"]["VALUE"])>0){
    foreach ($arResult['PROPERTIES']["SLIDER"]["VALUE"] as $key => $arImg){
        $arResult['IMAGES'][] = CFile::ResizeImageGet(
            $arImg,
            array("width" => "750", "height" => "380"),
            BX_RESIZE_IMAGE_PROPORTIONAL,
            //BX_RESIZE_IMAGE_EXACT,
            true
        );

    }
}


//OG:IMAGE
if (!empty($arResult['~PREVIEW_PICTURE'])){
    $idFile = $arResult['~PREVIEW_PICTURE'];
}elseif (!empty($arResult['~DETAIL_PICTURE'])) {
    $idFile = $arResult['~DETAIL_PICTURE'];
}elseif ($arResult['PROPERTIES']["SLIDER"]["VALUE"][0]) {
    $idFile = $arResult['PROPERTIES']["SLIDER"]["VALUE"][0];
}

if ($idFile) {
    $arFileTmp_small = CFile::ResizeImageGet(
        $idFile,
        array("width" => 650, "height" => 400), //ширина картинки в соцсетях при шаринге
        BX_RESIZE_IMAGE_PROPORTIONAL,
        true, false
    );
    $og_image = $arFileTmp_small["src"];
    $og_image_width = $arFileTmp_small["width"];
    $og_image_height = $arFileTmp_small["height"];
}





$urlSite = (CMain::IsHTTPS()) ? "https://" : "http://" . $_SERVER["SERVER_NAME"];

$arResult['OG'] = array(
    "OG_TITLE" => $arResult["NAME"],
    "OG_IMAGE" => $urlSite.$og_image,
    "OG_IMAGE_HEIGHT" => $og_image_height,
    "OG_IMAGE_WIDTH" => $og_image_width
);
//////////Open Graph//////////
if(count($arResult['PROPERTIES']["PERSON"]["VALUE"])>0 && $arResult['PROPERTIES']["PERSON"]["VALUE"][0]){
    $arResult["LIST_PERSON"]["ID"] = $arResult['PROPERTIES']["PERSON"]["VALUE"];
    $arResult["LIST_PERSON"]["IBLOCK_ID"] = $arResult['PROPERTIES']["PERSON"]["LINK_IBLOCK_ID"];
}


$cp = $this->__component;   /// component_epilog
if (is_object($cp))
{
    $cp->SetResultCacheKeys(array("OG","LIST_PERSON","NAME"));
}