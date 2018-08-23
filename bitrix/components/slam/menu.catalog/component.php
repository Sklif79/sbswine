<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();



if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;

$arParams["ID"] = intval($arParams["ID"]);
$arParams["IBLOCK_ID"] = intval($arParams["IBLOCK_ID"]);

$arParams["DEPTH_LEVEL"] = intval($arParams["DEPTH_LEVEL"]);
if($arParams["DEPTH_LEVEL"]<=0)
	$arParams["DEPTH_LEVEL"]=1;

$arResult["SECTIONS"] = array();
$arResult["ELEMENT_LINKS"] = array();

if($this->StartResultCache())
{
	if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
	}
	else
	{
		$arFilter = array(
			"IBLOCK_ID"=>$arParams["IBLOCK_ID"],
			"GLOBAL_ACTIVE"=>"Y",
			"IBLOCK_ACTIVE"=>"Y",
			"<="."DEPTH_LEVEL" => $arParams["DEPTH_LEVEL"],
		);
		$arOrder = array(
			"left_margin"=>"asc",
		);

		$rsSections = CIBlockSection::GetList($arOrder, $arFilter, false, array(
			"ID",
			"DEPTH_LEVEL",
			"NAME",
			"SECTION_PAGE_URL",
		));
		if($arParams["IS_SEF"] !== "Y")
			$rsSections->SetUrlTemplates("", $arParams["SECTION_URL"]);
		else
			$rsSections->SetUrlTemplates("", $arParams["SEF_BASE_URL"].$arParams["SECTION_PAGE_URL"]);
		while($arSection = $rsSections->GetNext())
		{


            $property_enums = CIBlockPropertyEnum::GetList(Array("DEF"=>"asc", "SORT"=>"ASC"), Array("IBLOCK_ID"=>$arParams["IBLOCK_ID"], "CODE"=>"MANUFACTURE"));
            while($enum_fields = $property_enums->GetNext())
            {
                $idCode = $enum_fields["PROPERTY_ID"];
                $arResult["arElements"][$enum_fields["ID"]]["NAME"] = $enum_fields["VALUE"];
                $arResult["arElements"][$enum_fields["ID"]]["ID"] = $enum_fields["ID"];
            }

            $arElementFilter = array(
                "IBLOCK_ID" => 5,
                "SUBSECTION" => $arSection["ID"],
                "ACTIVE" => "Y",
                "!PROPERTY_MANUFACTURE_VALUE" => false,
            );

            $rsElements = CIBlockElement::GetPropertyValues($arParams["IBLOCK_ID"], $arElementFilter,false,Array( "ID" => $idCode));
            while($arRt = $rsElements->Fetch()){
                $arResult['arElements'][$arRt['10']]["ITEMS"][$arRt['IBLOCK_ELEMENT_ID']] = $arRt['IBLOCK_ELEMENT_ID'];
            }

            foreach($arResult['arElements'] as $arFilter){
            	if($arFilter["ITEMS"]){
                    $arNewFilter[] = $arFilter;
				}
			}

            $arResult["SECTIONS"][] = array(
                "ID" => $arSection["ID"],
                "DEPTH_LEVEL" => $arSection["DEPTH_LEVEL"],
                "~NAME" => $arSection["~NAME"],
                "~SECTION_PAGE_URL" => $arSection["~SECTION_PAGE_URL"],
                "SECT_FILTER" => $arNewFilter,
                "ID_FILTER" => $idCode,
            );
            $arResult["ELEMENT_LINKS"][$arSection["ID"]] = array();
            unset($arResult['arElements']);
            unset($arNewFilter);
		}
		$this->EndResultCache();
	}
}

$aMenuLinksNew = array();
$menuIndex = 0;
$previousDepthLevel = 1;
foreach($arResult["SECTIONS"] as $arSection)
{
	if ($menuIndex > 0)
		$aMenuLinksNew[$menuIndex - 1][3]["IS_PARENT"] = $arSection["DEPTH_LEVEL"] > $previousDepthLevel;
	$previousDepthLevel = $arSection["DEPTH_LEVEL"];

	$arResult["ELEMENT_LINKS"][$arSection["ID"]][] = urldecode($arSection["~SECTION_PAGE_URL"]);
	$aMenuLinksNew[$menuIndex++] = array(
		htmlspecialcharsbx($arSection["~NAME"]),
		$arSection["~SECTION_PAGE_URL"],
		$arResult["ELEMENT_LINKS"][$arSection["ID"]],
		array(
			"FROM_IBLOCK" => true,
			"IS_PARENT" => false,
			"DEPTH_LEVEL" => $arSection["DEPTH_LEVEL"],
            "ID_FILTER" => $arSection["ID_FILTER"],
            "FILTER" => $arSection["SECT_FILTER"]
		),

	);
}

return $aMenuLinksNew;


?>
