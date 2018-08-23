<?

foreach($arResult as $key => $arElement){
    foreach($arElement["PROPERTIES"] as $num =>$arProp){
        if($arProp["VALUE"]){
            $arResult["SHOW_CHAR"] = "Y";
        }else{
            unset($arResult[$key]["PROPERTIES"][$num]);
        }
    }

}