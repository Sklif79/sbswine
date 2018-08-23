<?


if(count($arParams["DETAIL_PROPERTY_CHAR"])>0){

    foreach ($arResult['PROPERTIES'] as $arProp){
        if(array_search($arProp["CODE"], $arParams["DETAIL_PROPERTY_CHAR"])!==false && $arProp["VALUE"]){
            $arResult["MAIN_PROPERTIES"][] = $arProp;
        }
    }
}
//pr($arResult["MAIN_PROPERTIES"]);
$arFilter = array(
    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
    'ID' => $arResult['IBLOCK_SECTION_ID'],
);
$rsSect = CIBlockSection::GetList(array('sort' => 'asc'),$arFilter);
while ($arSect = $rsSect->GetNext())
{
    $arResult["SECTION_NAME"] =  $arSect["NAME"];
}



foreach ($arResult['PROPERTIES']["SLIDER"]["VALUE"] as $key => $arImg){
    $arResult['IMAGES'][$arImg]['IMG'] = CFile::ResizeImageGet(
        $arImg,
        array("width" => "650", "height" => "400"),
        BX_RESIZE_IMAGE_PROPORTIONAL,
        //BX_RESIZE_IMAGE_EXACT,
        true
    );
    $arResult['IMAGES'][$arImg]['SMALL_IMG'] = CFile::ResizeImageGet(
        $arImg,
        array("width" => "140", "height" => "140"),
        BX_RESIZE_IMAGE_PROPORTIONAL,
        //BX_RESIZE_IMAGE_EXACT,
        true
    );
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
        array("width" => 400, "height" => 400), //ширина картинки в соцсетях при шаринге
        BX_RESIZE_IMAGE_PROPORTIONAL,
        true, false
    );
    $og_image = $arFileTmp_small["src"];
    $og_image_width = $arFileTmp_small["width"];
    $og_image_height = $arFileTmp_small["height"];
    $urlSite = (CMain::IsHTTPS()) ? "https://" : "http://" . $_SERVER["SERVER_NAME"];

    $arResult['OG'] = array(
        "OG_TITLE" => $arResult["NAME"],
        "OG_IMAGE" => $urlSite.$og_image,
        "OG_IMAGE_HEIGHT" => $og_image_height,
        "OG_IMAGE_WIDTH" => $og_image_width
    );
}



$cp = $this->__component;
if (is_object($cp))
{
    $cp->SetResultCacheKeys(array("PROPERTIES", "~DETAIL_TEXT","OG","NAME","SECTION_NAME"));
}

