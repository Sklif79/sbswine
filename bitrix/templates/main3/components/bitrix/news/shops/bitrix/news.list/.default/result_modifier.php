<?
if(count($arResult['ITEMS']) > 0){


    foreach ($arResult['ITEMS'] as $key => $arElement){
        if($arElement["PROPERTIES"]["LAN_LAT"]["VALUE"]){
            $arResult['ITEMS'][$key]['LAN_LAT'] = explode(",",$arElement["PROPERTIES"]["LAN_LAT"]["VALUE"]);
        }
        if(intval($arElement['~PREVIEW_PICTURE']) > 0) {
            $arResult['ITEMS'][$key]['RESIZE_IMG'] = CFile::ResizeImageGet(
                $arElement['~PREVIEW_PICTURE'],
                array("width" => "500", "height" => "440"),
                //BX_RESIZE_IMAGE_PROPORTIONAL,
                BX_RESIZE_IMAGE_EXACT,
                true
            );
        }
    }

}

