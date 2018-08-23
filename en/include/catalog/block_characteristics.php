<?$APPLICATION->IncludeComponent(
    "energosoft:energosoft.group_property_manual",
    ".default",
    array(
        "CACHE_NOTES" => "",
        "CACHE_TIME" => "36000000000",
        "CACHE_TYPE" => "A",
        "ES_ELEMENT" => $arParams["ITEM_ID"],
        "ES_GROUP_COUNT" => "3",
        "ES_IBLOCK_CATALOG" => $arParams["IBLOCK_ID"],
        "ES_IBLOCK_TYPE_CATALOG" => "catalog",
        "ES_REMOVE_HREF" => "N",
        "ES_SHOW_EMPTY" => "N",
        "ES_SHOW_EMPTY_PROPERTY" => "N",
        "COMPONENT_TEMPLATE" => ".default",
        "ES_GROUP_NAME_0" => "Construction and capacity",
        "ES_GROUP_0" => array(
            0 => "PROP_3",
            1 => "PROP_2",
        ),
        "ES_GROUP_NAME_1" => "Performance and Energy Efficiency",
        "ES_GROUP_1" => array(
            0 => "TYPE",
            1 => "TYPE_2",
        ),
        "ES_GROUP_NAME_2" => "Control and display",
        "ES_GROUP_2" => array(
            0 => "PROP_3",
            1 => "TYPE_2",
        )
    ),
    false
);?>