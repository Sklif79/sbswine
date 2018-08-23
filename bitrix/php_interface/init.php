<?


AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "catalogSortPriceList");
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "catalogSortPriceList");

function catalogSortPriceList($id){
    if($id["IBLOCK_ID"]=="5" || $id["IBLOCK_ID"]=="14"){
        CModule::IncludeModule("iblock");
        $arFilter = array(
            "IBLOCK_ID" => $id["IBLOCK_ID"],
            "ID" => $id["ID"],

        );
        $arSelect = Array("ID", "NAME","PROPERTY_PRICE");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while($aritem = $res->GetNext())
        {
            if($aritem["PROPERTY_PRICE_VALUE"]){
                $priceItem = preg_replace('/[^0-9+]/','', $aritem["PROPERTY_PRICE_VALUE"]);
            }
        }
        if(intval($priceItem)>0){
            CModule::IncludeModule("iblock");

            $property_enums = CIBlockPropertyEnum::GetList(Array("sort"=>"asc"), Array("IBLOCK_ID"=>5, "CODE"=>"PRICE_SORT"));
            while($enum_fields = $property_enums->GetNext()){
                $arList[$enum_fields["ID"]] = $enum_fields["XML_ID"];
            }
            $count = count($arList);
            $i=1;foreach($arList as $key => $arIm){
                if($priceItem <= $arIm || $count == $i){
                    $valId = $key;
                    break;
                }
                $i=$i+1;
            }
            CIBlockElement::SetPropertyValuesEx(
                $id["ID"],
                false,
                array(
                    "PRICE_SORT" => $valId,
                )
            );
        }
    }
}
//*/

function pr($item) {
    global $USER;
    if ($USER->IsAdmin()) {
        if (!$item) echo ' <br />пусто <br />';
        elseif (is_array($item) && empty($item)) echo '<br />массив пуст <br />';
        else echo ' <pre>' . print_r($item, true) . ' </pre>';
    }
}

// Ищем быстрые фильтры для категории
function getFilterList($iblock, $sectionCode)
{

    $IDSectionCode = getIDByCode($iblock, $sectionCode);

    if($IDSectionCode > 0)
    {
        $result = array();

        $arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", "PROPERTY_URL");
        $arFilter = Array("IBLOCK_ID"=>(int)$iblock, "ACTIVE"=>"Y", "PROPERTY_SECTION" => $IDSectionCode);
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        while($ob = $res->GetNextElement())
        {
            $arFields = $ob->GetFields();
            $result[] = $arFields;
        }
        return $result;
    }

}

// Получаем ID раздела по его коду
function getIDByCode($iblock, $code)
{
    $arFilter = Array('IBLOCK_ID'=>5, 'CODE'=>$code);
    $db_list = CIBlockSection::GetList(Array('ID'=>'ASC'), $arFilter, false, array('ID'));
    while($ar_result = $db_list->GetNext())
    {
        return $ar_result['ID'];
    }
}

// Ищем быстрый фильтр по ссылке
function getDescByUrl($iblock, $url)
{
    $iblock = (int)$iblock;
    if(!$iblock)
        return false;

    $arSelect = Array("ID", "NAME", "DETAIL_PICTURE", "PROPERTY_URL", "PREVIEW_TEXT");
    $arFilter = Array("IBLOCK_ID"=>(int)$iblock, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
        //print_r(strpos($_SERVER['REQUEST_URI'], $arFields['PROPERTY_URL_VALUE']));
        if(strpos($_SERVER['REQUEST_URI'], $arFields['PROPERTY_URL_VALUE']) !== false)
            return $arFields;
    }

}

// Ищем описание производителя
function getDescManByID($iblock, $id)
{
    $iblock = (int)$iblock;
    if(!$iblock)
        return false;

    $arSelect = Array("ID", "NAME", "PREVIEW_PICTURE", "PREVIEW_TEXT");
    $arFilter = Array("IBLOCK_ID"=>(int)$iblock, "ID" => (int)$id);
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
    while($ob = $res->GetNextElement())
    {
        $arFields = $ob->GetFields();
            return $arFields;
    }

}