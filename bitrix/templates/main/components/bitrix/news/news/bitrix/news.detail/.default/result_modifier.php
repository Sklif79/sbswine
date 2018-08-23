<?

$arFilter = Array('IBLOCK_ID'=>$arParams['IBLOCK_ID'], 'GLOBAL_ACTIVE'=>'Y',"ID" => $arResult["IBLOCK_SECTION_ID"]);
	$arSelect = Array('ID', 'NAME');
	$rsSect = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true, $arSelect);
	while ($arSect = $rsSect->GetNext())
	{
		$arResult['SECTION_INFO_NAME'] = $arSect['NAME'];

	}


if(intval($arResult['~DETAIL_PICTURE']) > 0) {
    $arResult['RESIZE_IMG'] = CFile::ResizeImageGet(
        $arResult['~DETAIL_PICTURE'],
        array("width" => "750", "height" => "600"),
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
    $cp->SetResultCacheKeys(array("OG","NAME"));
}