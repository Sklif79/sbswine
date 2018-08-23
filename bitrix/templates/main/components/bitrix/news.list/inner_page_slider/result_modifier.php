<?

foreach ($arResult['ITEMS'] as $key => $arElement){
    if(intval($arElement['~PREVIEW_PICTURE']) > 0) {
        $arResult['ITEMS'][$key]['RESIZE_IMG'] = CFile::ResizeImageGet(
            $arElement['~PREVIEW_PICTURE'],
            array("width" => "800", "height" => "800"),
            BX_RESIZE_IMAGE_PROPORTIONAL,
            //BX_RESIZE_IMAGE_EXACT,
            true
        );
    }
}