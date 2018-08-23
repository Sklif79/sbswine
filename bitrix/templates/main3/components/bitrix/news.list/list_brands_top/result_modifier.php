<?

$property_enums = CIBlockPropertyEnum::GetList(Array("SORT"=>"ASC","ID"=>"ASC", ), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "CODE"=>"COUNTRY"));
while($enum_fields = $property_enums->GetNext())
{
    $arResult["LIST_COUNTRY"][$enum_fields["EXTERNAL_ID"]]["NAME"] = $enum_fields["VALUE"];
}

foreach ($arResult['ITEMS'] as $key => $arElement){
    $arResult["LIST_COUNTRY"][$arElement["PROPERTIES"]["COUNTRY"]['VALUE_XML_ID']]["ITEMS"] = true;
    if(intval($arElement['~PREVIEW_PICTURE']) > 0) {
        $arResult['ITEMS'][$key]['RESIZE_IMG'] = CFile::ResizeImageGet(
            $arElement['~PREVIEW_PICTURE'],
            array("width" => "119", "height" => "70"),
            BX_RESIZE_IMAGE_PROPORTIONAL,
            //BX_RESIZE_IMAGE_EXACT,
            true
        );
    }
}
