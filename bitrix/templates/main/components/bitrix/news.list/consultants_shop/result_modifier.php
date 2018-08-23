<?

foreach ($arResult['ITEMS'] as $key => $arElement){
    if(intval($arElement['~PREVIEW_PICTURE']) > 0) {
        $arResult['ITEMS'][$key]['RESIZE_IMG'] = CFile::ResizeImageGet(
            $arElement['~PREVIEW_PICTURE'],
            array("width" => "225", "height" => "425"),
            BX_RESIZE_IMAGE_PROPORTIONAL,
            //BX_RESIZE_IMAGE_EXACT,
            true
        );
    }
}