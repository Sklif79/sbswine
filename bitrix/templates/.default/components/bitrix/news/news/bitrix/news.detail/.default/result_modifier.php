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



