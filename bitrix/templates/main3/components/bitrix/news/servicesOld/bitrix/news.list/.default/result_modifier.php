<?
if(count($arResult['ITEMS']) > 0){

    $arFilter = Array(
        'IBLOCK_ID'=>$arParams['IBLOCK_ID'],
        'GLOBAL_ACTIVE'=>'Y',
        'CODE'=>'events',
    );
    $arSelect = Array('ID', 'NAME');
    $rsSect = CIBlockSection::GetList(Array("SORT"=>"ASC"), $arFilter, true, $arSelect);
    while ($arSect = $rsSect->GetNext())
    {
        $arResult['FLG_EVENT']= $arSect['ID'];
    }



    foreach ($arResult['ITEMS'] as $key => $arElement){
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

