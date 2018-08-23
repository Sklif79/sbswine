<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

//автоматическая установка почтового события и шаблона
$arEventTypeFields = array(
    0 => array(
        'LID'         => 'ru',
        'EVENT_NAME'  => 'SLAM_EASY_FORM',
        'NAME'        => GetMessage('RU_ET_NAME'),
        'DESCRIPTION' => GetMessage('RU_ET_DESCRIPTION'),
    ),
    1 => array(
        'LID'         => 'en',
        'EVENT_NAME'  => 'SLAM_EASY_FORM',
        'NAME'        => GetMessage('RU_ET_NAME'),
        'DESCRIPTION' => GetMessage('RU_ET_DESCRIPTION'),
    ),
);

$eventType = new CEventType;
foreach($arEventTypeFields as $arField) {
    $rsET = $eventType->GetByID($arField['EVENT_NAME'], $arField['LID']);
    $arET = $rsET->Fetch();

    if(!$arET){
        $eventType->Add($arField);
        $installSendTemplates = true;
    }
}
unset($rsET, $arET, $arField);

//если тип почтового события установлен недавно, то установим и шаблоны
if($installSendTemplates){
    $arSiteId = array();
    $rsSite   = CSite::GetList($by = "sort", $order = "asc", Array("ACTIVE" => "Y"));
    while($arSite = $rsSite->fetch())
        $arSiteId[] = $arSite['LID'];

    $arEventMessFields = array(
        0 => array(
            'ACTIVE'     => 'Y',
            'EVENT_NAME' => 'SLAM_EASY_FORM',
            'LID'        => $arSiteId,
            'EMAIL_FROM' => GetMessage('EM_EMAIL_FROM'),
            'EMAIL_TO'   => GetMessage('EM_EMAIL_TO'),
            'BCC'   => GetMessage('EM_BCC'),
            'SUBJECT'    => GetMessage('EM_SUBJECT'),
            'BODY_TYPE'  => 'html',
            'MESSAGE'    => GetMessage('EM_MESSAGE'),
        )
    );

    $eventM = new CEventMessage;
    foreach($arEventMessFields as $arField) {
        $eventM->Add($arField);
    }
}

//поля по-умолчанию
$arFields =  array(
    'TITLE'               => array(
        'NAME' => GetMessage('FIELD_TITLE'),
        'TYPE' => 'text',
    ),
    'WORK_POSITION'       => array(
        'NAME' => GetMessage('FIELD_WORK_POSITION'),
        'TYPE' => 'text',
    ),
    'WORK_COMPANY'        => array(
        'NAME' => GetMessage('FIELD_WORK_COMPANY'),
        'TYPE' => 'text',
    ),
    'EMAIL'               => array(
        'NAME' => GetMessage('FIELD_EMAIL'),
        //'TYPE' => 'email',
        'TYPE' => 'text',
    ),
    'PHONE'               => array(
        'NAME' => GetMessage('FIELD_PHONE'),
        'TYPE' => 'tel',
    ),
    'ADDRESS'       => array(
        'NAME' => GetMessage('FIELD_ADDRESS'),
        'TYPE' => 'text',
    ),
    'SERVICES'       => array(
        'NAME' => GetMessage('FIELD_SERVICES'),
        'TYPE' => 'select',
    ),
    'MESSAGE'               => array(
        'NAME' => GetMessage('FIELD_MESSAGE'),
        'TYPE' => 'textarea',
    )
);


//библиотеки для катомной сортировки
use Bitrix\Main\Web\Json;

CBitrixComponent::includeComponentClass('bitrix:catalog.section');


$defaultFields = array('TITLE','EMAIL', 'PHONE', 'MESSAGE');
$defaultFieldsForReq = array();
$arFieldsResult = array();
foreach($arFields as $key => $arField){
    $arFieldsResult[ $key ] = $arField['NAME'];
    if(in_array($key, $defaultFields)){
        $defaultFieldsForReq[ $key ] = $arField['NAME'];
    }
}


if(is_array($arCurrentValues["DISPLAY_FIELDS"])) {
    foreach ($arCurrentValues["DISPLAY_FIELDS"] as $key => $arVal) {
        if(!empty($arVal)){
            if($arFieldsResult[$arVal]){
                $fieldName = $arFieldsResult[$arVal];
            }else{
                $fieldName = $arVal;
            }
            $arReqFields[$arVal] = $fieldName;
        }
    }
}

$curFields = !empty($arReqFields)?$arReqFields:$defaultFieldsForReq;



$arComponentParameters = array(
	'GROUPS'     => array(
        'RECORD'  => array(
            'NAME' => "запись в ИБ",
            'SORT' => 250,
        ),
		'MAIL'  => array(
			'NAME' => GetMessage('GROUP_MAIL'),
			'SORT' => 300,
		),
        'CAPTCHA' => array(
            'NAME' => GetMessage('CAPTCHA'),
            'SORT' => 350,
        ),
		'JS_VALIDATE_SETTINGS'    => array(
			'NAME' => GetMessage('GROUPS_JS_VALIDATE_SETTINGS'),
			'SORT' => 1400,
		)

	),

	'PARAMETERS' => array(
        'FORM_ID'             => Array(
            'NAME'    => GetMessage('UNIQUE_FORM_ID'),
            'TYPE'    => 'STRING',
            'DEFAULT' => 'FORM'. mt_rand(1,10),
            'PARENT'  => 'BASE',
        ),
        'DETAIL_RECORD_IBLOCK'  => Array(
            'NAME'    => "Запись в ИБ?",
            'TYPE'    => 'CHECKBOX',
            'DEFAULT' => 'Т',
            'PARENT'  => 'RECORD',
            "REFRESH" => "Y",
        ),
        'DISPLAY_FIELDS'             => array(
            'PARENT'            => 'BASE',
            'NAME'              => GetMessage('MFP_DISPLAY_FIELDS'),
            'TYPE'              => 'LIST',
            'MULTIPLE'          => 'Y',
            'REFRESH'          => 'Y',
            'VALUES'            => $arFieldsResult,
            'ADDITIONAL_VALUES' => 'Y',
            'SIZE'              => 6,
            'DEFAULT'           => $defaultFields,
        ),
        'REQUIRED_FIELDS'            => Array(
            'NAME'     => GetMessage('MFP_REQUIRED_FIELDS'),
            'TYPE'     => 'LIST',
            'MULTIPLE' => 'Y',
            'VALUES'   => $curFields,
            'SIZE'     => 6,
            'REFRESH'  => 'Y',
            'DEFAULT'  => array('EMAIL'),
            'PARENT'   => 'BASE',
        ),

        'FIELDS_ORDER'            => Array(
            'NAME'     => GetMessage('FIELDS_ORDER'),
            'PARENT'   => 'BASE',
            'TYPE' => 'CUSTOM',
            'JS_FILE' => CatalogSectionComponent::getSettingsScript('/bitrix/components/bitrix/catalog.section', 'dragdrop_order'),
            'JS_EVENT' => 'initDraggableOrderControl',
            'JS_DATA' => Json::encode($curFields),
            'DEFAULT' => 'TITLE,EMAIL,PHONE,MESSAGE'
        ),


        'HIDE_FIELD_NAME'   => array(
            'NAME'    => GetMessage('HIDE_FIELD_NAME'),
            'TYPE'    => 'CHECKBOX',
            'DEFAULT' => '',
            'PARENT'  => 'BASE',
        ),
        'HIDE_ASTERISK'     => array(
            'NAME'    => GetMessage('HIDE_ASTERISK'),
            'TYPE'    => 'CHECKBOX',
            'DEFAULT' => '',
            'PARENT'  => 'BASE',
        ),
        'FORM_AUTOCOMPLETE' => array(
            'NAME'    => GetMessage('FORM_AUTOCOMPLETE'),
            'TYPE'    => 'CHECKBOX',
            'DEFAULT' => 'Y',
            'PARENT'  => 'BASE',
        ),
        'FORM_SUBMIT_VALUE'  => array(
            'NAME'    => GetMessage('FORM_SUBMIT_VALUE'),
            'TYPE'    => 'STRING',
            'DEFAULT' => GetMessage('FORM_SUBMIT_VALUE_DEFAULT'),
            'COLS'    => 50,
            'PARENT'  => 'BASE',
        ),
        'OK_TEXT_TITLE'                    => Array(
            'NAME'    => "заголовок для ответа",
            'TYPE'    => 'STRING',
            'PARENT'  => 'BASE',
            'COLS'    => 47,
            'ROWS'    => 4,
        ),
        'OK_TEXT'                    => Array(
            'NAME'    => GetMessage('MFP_OK_MESSAGE'),
            'TYPE'    => 'STRING',
            'DEFAULT' => GetMessage('MFP_OK_TEXT'),
            'PARENT'  => 'BASE',
            'COLS'    => 47,
            'ROWS'    => 4,
        ),

        'ERROR_TEXT'                    => Array(
            'NAME'    => GetMessage('MFP_ERROR_MESSAGE'),
            'TYPE'    => 'STRING',
            'DEFAULT' => GetMessage('MFP_ERROR_TEXT'),
            'PARENT'  => 'BASE',
            'COLS'    => 47,
            'ROWS'    => 4,
        ),
        'OK_TEXT_AFTER'              => Array(
            'NAME'    => GetMessage('OK_TEXT_AFTER'),
            'TYPE'    => 'STRING',
            'DEFAULT' => GetMessage('OK_TEXT_AFTER_DEFAULT'),
            'PARENT'  => 'BASE',
            'COLS'    => 47,
            'ROWS'    => 4,
        ),

        'DISABLE_SEND_MAIL'          => array(
            'NAME'    => GetMessage('DISABLE_SEND_MAIL'),
            'TYPE'    => 'CHECKBOX',
            'REFRESH' => 'Y',
            'DEFAULT' => 'N',
            'PARENT'  => 'MAIL',
        ),
		'USE_CAPTCHA'                => array(
			'NAME'    => GetMessage('USE_CAPTCHA'),
			'TYPE'    => 'CHECKBOX',
			'DEFAULT' => 'N',
			'PARENT'  => 'CAPTCHA',
            "REFRESH" => "Y",
		),

        'USE_JQUERY'             => array(
            'NAME'    => GetMessage('INCLUDE_JQUERY'),
            'TYPE'    => 'CHECKBOX',
            'DEFAULT' => 'N',
            'PARENT'  => 'JS_VALIDATE_SETTINGS',
        ),
        'USE_BOOTSRAP_CSS'             => array(
            'NAME'    => GetMessage('USE_BOOTSRAP_CSS'),
            'TYPE'    => 'CHECKBOX',
            'DEFAULT' => 'Y',
            'PARENT'  => 'JS_VALIDATE_SETTINGS',
        ),
        'USE_BOOTSRAP_JS'             => array(
            'NAME'    => GetMessage('USE_BOOTSRAP_JS'),
            'TYPE'    => 'CHECKBOX',
            'DEFAULT' => 'N',
            'PARENT'  => 'JS_VALIDATE_SETTINGS',
        )
	),
);


if($arCurrentValues["DETAIL_RECORD_IBLOCK"] == 'Y'){
    $arComponentParameters["PARAMETERS"]["IBLOCK_ID_RECORD"] = array(
        'NAME'    => "ID для записи в инфоблок",
        'TYPE'    => 'STRING',
        'DEFAULT' => '',
        'PARENT'  => 'RECORD',
    );
}

if($arCurrentValues["USE_CAPTCHA"] == 'Y'){
    $arComponentParameters["PARAMETERS"]["CAPTCHA_KEY"] = array(
        'NAME'    => GetMessage('CAPTCHA_KEY'),
        'TYPE'    => 'STRING',
        'DEFAULT' => '',
        'PARENT'  => 'CAPTCHA',
    );
    $arComponentParameters["PARAMETERS"]["CAPTCHA_SECRET_KEY"] = array(
        'NAME'    => GetMessage('CAPTCHA_SECRET_KEY'),
        'TYPE'    => 'STRING',
        'DEFAULT' => '',
        'PARENT'  => 'CAPTCHA',
    );
}

if($arCurrentValues["DISABLE_SEND_MAIL"] != 'Y'){
    $defaultEvent = '';
    $arEvent = Array();
    $arFilter = Array("TYPE_ID" => "SLAM_EASY_FORM", "ACTIVE" => "Y");
    $dbType = CEventMessage::GetList($by="ID", $order="DESC", $arFilter);
    while($arType = $dbType->GetNext()){
        if(!$defaultEvent){
            $defaultEvent = $arType["ID"];
        }

        $arEvent[$arType["ID"]] = "[".$arType["ID"]."] ".$arType["SUBJECT"];
    }



     $arComponentParameters["PARAMETERS"]["EVENT_MESSAGE_ID"] = array(
         "PARENT" => "MAIL",
         "NAME" => GetMessage("MFP_EMAIL_TEMPLATES"),
         "TYPE"=>"LIST",
         "VALUES" => $arEvent,
         "DEFAULT"=>$defaultEvent,
         "MULTIPLE"=>"Y",
         "COLS"=>25,
     );
    $arComponentParameters["PARAMETERS"]["REPLACE_FIELD_FROM"] = array(
        "PARENT" => "MAIL",
        "NAME" =>  GetMessage('REPLACE_FIELD_FROM'),
        'TYPE'    => 'CHECKBOX',
        'DEFAULT' => 'N',
    );
    $arComponentParameters["PARAMETERS"]["EMAIL_TO"] = array(
        'NAME'    => GetMessage('MFP_EMAIL_TO'),
        'TYPE'    => 'STRING',
        'DEFAULT' => '={htmlspecialchars(COption::GetOptionString("main","DEF_EMAIL",""))}',
        'PARENT'  => 'MAIL',
    );
    $arComponentParameters["PARAMETERS"]["BCC"] = array(
        'NAME'    => GetMessage('MFP_BCC'),
        'TYPE'    => 'STRING',
        'DEFAULT' => '',
        'PARENT'  => 'MAIL',
    );
    $arComponentParameters["PARAMETERS"]["MAIL_SUBJECT_ADMIN"] = array(
        'NAME'     => GetMessage('MAIL_SUBJECT_ADMIN'),
        'TYPE'     => 'STRING',
        'DEFAULT'  => GetMessage('MAIL_SUBJECT_ADMIN_DEFAULT'),
        'COLS'     => 50,
        'PARENT'   => 'MAIL',
    );
    $arComponentParameters["PARAMETERS"]["WRITE_MESS_FILDES_TABLE"] = array(
        'NAME'    => GetMessage('WRITE_MESS_FILDES_TABLE'),
        'TYPE'    => 'CHECKBOX',
        'DEFAULT' => 'N',
        'REFRESH' => 'N',
        'PARENT'  => 'MAIL',
    );
    $arComponentParameters["PARAMETERS"]["MAIL_SEND_USER"] = array(
        'NAME'    => GetMessage('MAIL_SEND_USER'),
        'TYPE'    => 'CHECKBOX',
        'DEFAULT' => 'N',
        'PARENT'  => 'MAIL',
        'REFRESH' => 'Y'
    );


    if($arCurrentValues["MAIL_SEND_USER"] == 'Y'){
        $arComponentParameters["PARAMETERS"]["MAIL_SUBJECT_USER"] = array(
            'NAME'     => GetMessage('MAIL_SUBJECT_USER'),
            'TYPE'     => 'STRING',
            'DEFAULT'  => GetMessage('MAIL_SUBJECT_USER_DEFAULT'),
            'COLS'     => 50,
            'PARENT'   => 'MAIL',
        );
    }
}

if(!empty($arCurrentValues['DISPLAY_FIELDS'])){
    $arDisplayFields = array_diff((array)$arCurrentValues['DISPLAY_FIELDS'], array(''));
    if(strlen($arCurrentValues["FIELDS_ORDER"]) > 0) {
        $arSortField = explode(',', $arCurrentValues['FIELDS_ORDER']);
    }
    if(false){
        $arFormFields = $arSortField;
    }else{
        $arFormFields = $arDisplayFields;
    }
}else{
    $arFormFields = $defaultFields;
}



if(is_array($arFormFields)){
    $sort=480;
    foreach($arFormFields as $arVal){
        $fieldName = $arFieldsResult[$arVal]?$arFieldsResult[$arVal]:$arVal;
        $defaultFieldType = $arFields[$arVal]['TYPE']?$arFields[$arVal]['TYPE']:"text";
        $isFieldReq = in_array($arVal, $arCurrentValues["REQUIRED_FIELDS"])?"Y":"N";
        $isMultipleVal = "N";
        $defaultReq = "";

        if($arCurrentValues['CATEGORY_'.$arVal.'_TYPE']){
            if($arCurrentValues['CATEGORY_'.$arVal.'_TYPE'] == 'select'){
                $isSelectField = true;
                $isMultipleVal = "Y";
            }
        }elseif($arFields[$arVal]['TYPE'] == 'select'){
            $isSelectField = true;
            $isMultipleVal = "Y";
        }



        $arComponentParameters["GROUPS"]["CATEGORY_".$arVal] = array(
            "NAME" => $fieldName.GetMessage('GROUP_FIELD_TITLE'),
            'SORT' => $sort,
        );
        $arComponentParameters["PARAMETERS"]["CATEGORY_".$arVal."_TITLE"] = array(
            "PARENT" => "CATEGORY_".$arVal,
            "NAME" => GetMessage('GROUP_FIELD_NAME'),
            "TYPE" => "STRING",
            "DEFAULT" => $fieldName,
        );

        $arComponentParameters["PARAMETERS"]["CATEGORY_".$arVal."_TYPE"] = array(
            "PARENT" => "CATEGORY_".$arVal,
            "NAME" => GetMessage('TYPE_FIELD'),
            "TYPE" => "LIST",
            "VALUES" => array(
                'text' => 'text',
                'hiddet_text' => 'hiddet_text',
                'email' => 'email',
                'tel' => 'number',
                'textarea' => 'textarea',
                'file' => 'file',
                'rating' => 'rating',
                //'select' => 'select',
//                'multiselect' => 'multiselect',
//                'checkbox' => 'checkbox',
//                'radio' => 'radio',
                'url' => 'url',
                //'number' => 'number',
//                'hidden' => 'hidden',
                //'iblock_select' => 'iblock_select',
                //'stars' => 'stars',
            ),
            "REFRESH" => "Y",
            "DEFAULT" => $defaultFieldType,
            "ADDITIONAL_VALUES" => "N",
        );
//        $arComponentParameters["PARAMETERS"]["CATEGORY_".$arVal."_REQ"] = array(
//            "PARENT" => "CATEGORY_".$arVal,
//            "NAME" => "Обязательное?",
//            "TYPE" => "CHECKBOX",
//            "DEFAULT" => $isFieldReq,
//            "REFRESH" => "Y",
//        );

        if($isFieldReq == 'Y'){
            $arComponentParameters["PARAMETERS"]["CATEGORY_".$arVal."_TYPE_VALIDATION"] = array(
                "PARENT" => "CATEGORY_".$arVal,
                "NAME" => GetMessage('GROUP_FIELD_REQ'),
                "TYPE" => "STRING",
                "MULTIPLE" => "N",
                "REFRESH" => "N",
                "DEFAULT" => $defaultReq,
                "ADDITIONAL_VALUES" => "N",
                'COLS'    => 60,
                'ROWS'    => 8,
            );
        }

        $arComponentParameters["PARAMETERS"]["CATEGORY_".$arVal."_PLACEHOLDER"] = array(
            "PARENT" => "CATEGORY_".$arVal,
            "NAME" => "Placeholder",
            "TYPE" => "STRING",
        );
//        $arComponentParameters["PARAMETERS"]["CATEGORY_".$arVal."_DECR"] = array(
//            "PARENT" => "CATEGORY_".$arVal,
//            "NAME" => GetMessage("CP_BST_CATEGORY_DECR"),
//            "TYPE" => "STRING",
//        );


        $arComponentParameters["PARAMETERS"]["CATEGORY_".$arVal."_VALUE"] = array(
            "PARENT" => "CATEGORY_".$arVal,
            "NAME" => GetMessage('GROUP_FIELD_VALUE'),
            "TYPE" => "STRING",
            "MULTIPLE" => $isMultipleVal,
            "ADDITIONAL_VALUES" => "N",
        );

        if($isSelectField){
            $arComponentParameters["PARAMETERS"]["CATEGORY_".$arVal."_ADD_VAL"] = array(
                "PARENT" => "CATEGORY_".$arVal,
                "NAME" => GetMessage('GROUP_FIELD_SELECT_ADD'),
                "TYPE" => "STRING",
                "DEFAULT" => GetMessage('GROUP_FIELD_SELECT_ADD_DEF'),
                "ADDITIONAL_VALUES" => "N",
            );
        }
        $sort++;
    }

}


?>

