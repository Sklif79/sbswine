<?

foreach ($arResult['SECTIONS'] as $key => $arSect){
    if(intval($arSect['~PICTURE']) > 0) {
        $arResult['SECTIONS'][$key]['RESIZE_IMG'] = CFile::ResizeImageGet(
            $arSect['~PICTURE'],
            array("width" => "285", "height" => "400"),
            //BX_RESIZE_IMAGE_PROPORTIONAL,
            BX_RESIZE_IMAGE_EXACT,
            true
        );
    }
}