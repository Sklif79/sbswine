<?

foreach ($arResult['SECTIONS'] as $key => $arElement){
    if(intval($arElement['~PICTURE']) > 0) {
        $arResult['SECTIONS'][$key]['RESIZE_IMG'] = CFile::ResizeImageGet(
            $arElement['~PICTURE'],
            array("width" => "265", "height" => "365"),
            // BX_RESIZE_IMAGE_PROPORTIONAL,
            BX_RESIZE_IMAGE_EXACT,
            true
        );
    }
}