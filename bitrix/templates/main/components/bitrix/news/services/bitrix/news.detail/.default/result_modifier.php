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
if(count($arResult["PROPERTIES"]["DESC"]["VALUE"])>0){
    $arSelect = Array("ID","IBLOCK_ID", "NAME", "PREVIEW_TEXT","PROPERTY_SLIDER");
    $arFilter = Array(
        "IBLOCK_ID"=>$arResult["PROPERTIES"]["DESC"]["LINK_IBLOCK_ID"],
        "ID"=>$arResult["PROPERTIES"]["DESC"]["VALUE"],
        "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        $arProps = $ob->GetProperties();

        $arResult["DESC"][$arFields["ID"]]["NAME"] = $arFields["~NAME"];
        $arResult["DESC"][$arFields["ID"]]["PREVIEW_TEXT"] = $arFields["~PREVIEW_TEXT"];
        $slideId = $arProps["SLIDER"]["VALUE"][0];
        if(($slideId)){
            foreach($arProps["SLIDER"]["VALUE"] as $arSlide){
                if(!$arResult["DESC"][$arFields["ID"]]["SLIDER"][$arSlide]){
                    $arResult["DESC"][$arFields["ID"]]["SLIDER"][$arSlide] = $arResult['RESIZE_IMG'] = CFile::ResizeImageGet(
                        $arSlide,
                        array("width" => "750", "height" => "400"),
                        BX_RESIZE_IMAGE_PROPORTIONAL,
                        //BX_RESIZE_IMAGE_EXACT,
                        true
                    );
                }
            }
        }
    }

}


$arResult["CONSULTANT_INFO"]["ID"] = $arResult["PROPERTIES"]["CONSULTANT"]["VALUE"];
$arResult["CONSULTANT_INFO"]["IBLOCK_ID"] = $arResult["PROPERTIES"]["CONSULTANT"]["LINK_IBLOCK_ID"];



//OG:IMAGE
if (!empty($arResult['~PREVIEW_PICTURE'])){
    $idFile = $arResult['~PREVIEW_PICTURE'];
}elseif (!empty($arResult['~DETAIL_PICTURE'])) {
    $idFile = $arResult['~DETAIL_PICTURE'];
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
    "OG_DESC" => substr(strip_tags($arResult['~DETAIL_TEXT']),"0", "150"),
    "OG_TITLE" => $arResult["NAME"],
    "OG_IMAGE" => $urlSite.$og_image,
    "OG_IMAGE_HEIGHT" => $og_image_height,
    "OG_IMAGE_WIDTH" => $og_image_width
);

$cp = $this->__component;
if (is_object($cp))
{
    $cp->SetResultCacheKeys(array("CONSULTANT_INFO","OG","NAME","DESC","~DETAIL_TEXT"));
}