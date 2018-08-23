<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

if (!CModule::IncludeModule('iblock'))
    return;

$arProperty_LNS = array();
$rsProp = CIBlockProperty::GetList(Array("sort"=>"asc", "name"=>"asc"), Array("ACTIVE"=>"Y", "IBLOCK_ID"=>$arCurrentValues["IBLOCK_ID"]));
while ($arr=$rsProp->Fetch())
{
    $arProperty[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    if (in_array($arr["PROPERTY_TYPE"], array("L", "N", "S", "E")))
    {
        $arProperty_LNS[$arr["CODE"]] = "[".$arr["CODE"]."] ".$arr["NAME"];
    }
}

$arTemplateParameters = array(
    "DETAIL_PROPERTY_CHAR" => array(
        "PARENT" => "DETAIL_SETTINGS",
        "NAME" => "Основные характеристики в карточке",
        "TYPE" => "LIST",
        "MULTIPLE" => "Y",
        "VALUES" => $arProperty_LNS,
        "ADDITIONAL_VALUES" => "Y",
    ),

);
$arTemplateParameters = array(
    "SECTION_PROPERTY_CHAR" => array(
        "PARENT" => "LIST_SETTINGS",
        "NAME" => "Основные характеристики в списке",
        "TYPE" => "LIST",
        "MULTIPLE" => "Y",
        "VALUES" => $arProperty_LNS,
        "ADDITIONAL_VALUES" => "Y",
    ),

);


$arTemplateParameters['FILTER_CONTENER'] = array(
    'PARENT' => 'VISUAL',
    'NAME' =>"ID FILTER CONTENER",
    'TYPE' => 'STING',
    'DEFAULT' => 'ajax_filter',
);
