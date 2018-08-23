<?
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
	die();

/**
 * Bitrix vars
 *
 * @var CBitrixComponent $this
 * @var array            $arParams
 * @var array            $arResult
 * @var string           $componentPath
 * @var string           $componentName
 * @var string           $componentTemplate
 *
 * @var CDatabase        $DB
 * @var CUser            $USER
 * @var CMain            $APPLICATION
 *
 */

use Bitrix\Main;
use Bitrix\Main\Loader;
use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;

$context = Application::getInstance()->getContext();
$request = $context->getRequest();
$server = $context->getServer();




//==============================================================================
// $arParams
//==============================================================================
$arParams['FORM_ID'] = $arParams['FORM_ID'] ? trim($arParams['FORM_ID']) : $this->GetEditAreaId($this->__currentCounter);

$arParams['HTTP_PROTOCOL'] = $request->isHttps() ? 'https://' : 'http://';
$arParams['HTTP_HOST']     = $arParams['HTTP_PROTOCOL'] . $server->getHttpHost();
$arParams['EVENT_NAME']    = 'SLAM_EASY_FORM';


$arParams['DISPLAY_FIELDS']  = array_diff((array)$arParams['DISPLAY_FIELDS'], array(''));
$arParams['REQUIRED_FIELDS'] = array_diff((array)$arParams['REQUIRED_FIELDS'], array(''));

$arSortField = explode(',', $arParams['FIELDS_ORDER']);
if(!empty($arSortField) && count($arSortField) == count($arParams['DISPLAY_FIELDS']) ){
    $arParams['DISPLAY_FIELDS'] = $arSortField;
}

$arParams['FORM_FIELDS'] = array();
foreach($arParams['DISPLAY_FIELDS'] as $fieldCode){
    $arParams['FORM_FIELDS'][$fieldCode] = array(
        'ID' => trim($arParams['FORM_ID']) .'_FIELD_'. $fieldCode,
        'TITLE' => !empty($arParams['CATEGORY_'.$fieldCode.'_TITLE']) ? $arParams['CATEGORY_'.$fieldCode.'_TITLE'] : $fieldCode,
        'TYPE' => !empty($arParams['CATEGORY_'.$fieldCode.'_TYPE']) ? $arParams['CATEGORY_'.$fieldCode.'_TYPE'] : 'text',
        'NAME' => 'FIELDS['.$fieldCode.']',
        'CODE' => $fieldCode,
        'REQUAIRED' => in_array($fieldCode, $arParams['REQUIRED_FIELDS']) ? true : false,
        'VALUE' => !empty($arParams['CATEGORY_'.$fieldCode.'_VALUE']) ? $arParams['CATEGORY_'.$fieldCode.'_VALUE'] : '',
        'PLACEHOLDER' => !empty($arParams['CATEGORY_'.$fieldCode.'_PLACEHOLDER']) ? $arParams['CATEGORY_'.$fieldCode.'_PLACEHOLDER'] : false,
        'TYPE_VALIDATION' => !empty($arParams['CATEGORY_'.$fieldCode.'_TYPE_VALIDATION']) ? $arParams['CATEGORY_'.$fieldCode.'_TYPE_VALIDATION'] : $arParams['CATEGORY_'.$fieldCode.'_TYPE_VALIDATION']
    );

    //дополнительные значения для селектов
    if(strlen(trim($arParams[ 'CATEGORY_' . $fieldCode . "_ADD_VAL" ])) > 0){
        $arParams['FORM_FIELDS'][$fieldCode]['SET_ADDITION_SELECT_VAL'] = true;
        $arParams['FORM_FIELDS'][$fieldCode]['SET_ADDITION_SELECT_ID'] = $arParams['FORM_FIELDS'][$fieldCode]['ID'].'_add';
        $arParams['FORM_FIELDS'][$fieldCode]['ADDITION_SELECT_VAL'] = $arParams[ 'CATEGORY_' . $fieldCode . "_ADD_VAL" ];
        $arParams['FORM_FIELDS'][$fieldCode]['ADDITION_SELECT_NAME'] = 'FIELDS['.$fieldCode.'_ADD]';
    }
}


$arParams["USE_CAPTCHA"] = $arParams["USE_CAPTCHA"] == 'Y' && strlen($arParams["CAPTCHA_KEY"]) > 1 && strlen($arParams["CAPTCHA_SECRET_KEY"]) > 1;

if($arParams["USE_CAPTCHA"]){
    $arParams["CAPTCHA_KEY"] = trim($arParams["CAPTCHA_KEY"]);
    $arParams["CAPTCHA_SECRET_KEY"] = trim($arParams["CAPTCHA_SECRET_KEY"]);
}


$arParams['USER_EMAIL']    = '';
$arParams['EMAIL_TO']      = trim($arParams['EMAIL_TO']);
$arParams['BCC']           = trim($arParams['BCC']);

$arParams['OK_TEXT']       = $arParams['OK_TEXT'] ? htmlspecialcharsback(trim($arParams['OK_TEXT'])) : GetMessage('MESS_OK_TEXT');
$arParams['ERROR_TEXT'] = $arParams['ERROR_TEXT'] ? htmlspecialcharsback(trim($arParams['ERROR_TEXT'])) : GetMessage('MESS_ERROR_TEXT');


//EVENT_MESSAGE_SETTINGS
$arParams['WRITE_MESS_FILDES_TABLE']      = $arParams['WRITE_MESS_FILDES_TABLE'] == 'Y';

$arParams['MAIL_SUBJECT_ADMIN'] = trim($arParams['MAIL_SUBJECT_ADMIN']);
$arParams['MAIL_SUBJECT_USER']  = trim($arParams['MAIL_SUBJECT_USER']);
$arParams['MAIL_SEND_USER']     = $arParams['MAIL_SEND_USER'] == 'Y';

//BASE SETTINGS
$arParams['DISABLE_SEND_MAIL']  = $arParams['DISABLE_SEND_MAIL'] === 'Y';
$arParams['REPLACE_FIELD_FROM'] = $arParams['REPLACE_FIELD_FROM'] === 'Y';

//Include jQuery plugins
$arParams['USE_JQUERY']      = $arParams['USE_JQUERY'] === 'Y';


//VISUAL_SETTINGS
$arParams['HIDE_FIELD_NAME']     = $arParams['HIDE_FIELD_NAME'] === 'Y';
$arParams['HIDE_ASTERISK']       = $arParams['HIDE_ASTERISK'] === 'Y';
$arParams['FORM_AUTOCOMPLETE']   = $arParams['FORM_AUTOCOMPLETE'] === 'Y';
$arParams['FORM_SUBMIT_VALUE']   = htmlspecialcharsback($arParams['FORM_SUBMIT_VALUE']);





//==============================================================================
// Work with $_REQUEST
//==============================================================================

$arMessageError = array();
$arFields  = array();

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

if($request->isPost() && $arParams['FORM_ID'] == $request['FORM_ID'])
{
    if(1)
	{
		//==============================================================================
		// CSS ANTIBOT
		//==============================================================================
		if(isset($_REQUEST['ANTIBOT']) && is_array($_REQUEST['ANTIBOT']))
		{
			foreach($_REQUEST['ANTIBOT'] as $k => $v)
				if(empty($v))
					unset($_REQUEST['ANTIBOT'][ $k ]);
		}

		if($_REQUEST['ANTIBOT'] || !isset($_REQUEST['ANTIBOT']))
		{
			$APPLICATION->RestartBuffer();
			die();
		}


        //reCaptcha
        if($arParams["USE_CAPTCHA"]){

            // однократное включение файла autoload.php (клиентская библиотека reCAPTCHA PHP)
            require_once (dirname(__FILE__).'/lib/recaptcha/autoload.php');
            // если в массиве $_POST существует ключ g-recaptcha-response, то...
            if (isset($_REQUEST['g-recaptcha-response'])) {
                // создать экземпляр службы recaptcha, используя секретный ключ
                $recaptcha = new \ReCaptcha\ReCaptcha($arParams["CAPTCHA_SECRET_KEY"]);
                // получить результат проверки кода recaptcha
                $resp = $recaptcha->verify($_REQUEST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);

                // если результат положительный, то...
                if ($resp->isSuccess()){
                    // действия, если код captcha прошёл проверку

                } else {
                    // иначе передать ошибку
                    $errors = $resp->getErrorCodes();
                    $arMessageError[] = GetMessage('CAPTCHA_ERROR');
                }
            }
        }



		//==============================================================================
		// VALIDATE $_REQUEST FIELDS
		//==============================================================================
		$arPostFieldsTmp = (array)$request['FIELDS'];
        $arPostFields = array();
        $emptyForm = true;
        foreach($arPostFieldsTmp as $key => $field)
        {
            if(strlen(trim($field)) > 0){
                $emptyForm = false;
            }

            if($lastkey."_ADD" == $key){
                if(!empty($field)){
                    $arPostFields[ $lastkey ] = nl2br(htmlspecialcharsbx($field)).GetMessage('ADD_SELECT_MESS');
                }
            }else{
                $arPostFields[ $key ] = nl2br(htmlspecialcharsbx($field));
            }

            $lastkey = $key;
        }

        if($emptyForm){
            $arMessageError[] = GetMessage('EMPTY_FORM_ERROR');
        }


		//==============================================================================
		// VALIDATE REQUIRED FIELDS
		//==============================================================================
        $_REQUEST['FIELDS']['TITLE'] = 0;
		if(!in_array('NONE', $arParams['REQUIRED_FIELDS']))
		{
			foreach($arParams['REQUIRED_FIELDS'] as $FIELD)
			{
				$message_field = $arParams['FORM_FIELDS'][ $FIELD ]['TITLE'];

				if((empty($arParams['REQUIRED_FIELDS']) || in_array($FIELD, $arParams['REQUIRED_FIELDS'])) && strlen($arPostFields[ $FIELD ]) == 0){
                    $arMessageError[] = GetMessage("FIELD_ERROR_MESS", array("#FIELD_NAME#" => $message_field));
                }
			}
			unset($FIELD);
		}


		//Validate e-mail
		if(!empty($arPostFields['EMAIL']) && !check_email($arPostFields['EMAIL']))
            $arMessageError[] = GetMessage('EMAIL_ERROR');


     
        
        
		if(empty($arMessageError) && $arParams['DISABLE_SEND_MAIL'] != 'Y')
		{
            $arServiceFields = Array(
				'FORM_FIELDS'       => '',
                'AUTHOR_NAME'       => '',
                'AUTHOR_EMAIL'       => '',
                'SUBJECT'       => '', //название формы
                'EMAIL_FROM'       => '', //Email отправителя письма
				'EMAIL_TO'        => $arParams['EMAIL_TO'], //Email получателя письма
                'EMAIL_BCC'       => $arParams['EMAIL_BCC'], //Email скрытой копии
                'DEFAULT_EMAIL_FROM'       => COption::GetOptionString("main","email_from",""), //Email по умолчанию
				'FORM_TITLE'      => $arParams['FORM_TITLE'], //обратная связь
                'SITE_NAME' => COption::GetOptionString("main", "site_name", $GLOBALS['SERVER_NAME']),
				'SERVER_NAME'     => $request->getHttpHost(),
				'IP'              => $request->getRemoteAddress(),

			);

			if(!Main\Application::isUtfMode()){
                $arPostFields = Main\Text\Encoding::convertEncoding($arPostFields, 'UTF-8', $context->getCulture()->getCharset());
                $arServiceFields = Main\Text\Encoding::convertEncoding($arServiceFields, 'UTF-8', $context->getCulture()->getCharset());
            }



            $arFoto = array();
            $arPostFields['PHOTO'] = '';
            // вот тут сохраняем файлы в DB и удаляем их из временной директории
            if (!empty($_SESSION['TMP_FILES'][$_SESSION['fixed_session_id']])) {
                foreach ($_SESSION['TMP_FILES'][$_SESSION['fixed_session_id']] as $file_path) {

                    $file_path = \CFile::MakeFileArray($file_path);
                    $f_id = \CFile::SaveFile($file_path, 'forms');
                    
                    
                    $arFoto[] = $f_id;

                    $href = $arParams['HTTP_HOST'].CFile::GetPath($f_id);
                    $hrefUrl = CFile::GetPath($f_id);

                    $arPostFields['PHOTO'] .=  '<a href="'.$href.'">'.($file_path['name'] ? : $href).'</a>';

                    unlink(Application::getDocumentRoot() . $file_path);
                }
                unset($_SESSION['TMP_FILES'][$_SESSION['fixed_session_id']]);
            }

            

            //EMAIL_FROM
            if($arParams['REPLACE_FIELD_FROM'] == 'Y' && $arPostFields['EMAIL'] && strlen($arPostFields['EMAIL']) > 0){
                $arServiceFields['EMAIL_FROM'] = $arPostFields['EMAIL'];
            }else{
                $arServiceFields['EMAIL_FROM'] = $arServiceFields['DEFAULT_EMAIL_FROM'];
            }


            //FORM_FIELDS
            if($arPostFields){

                if($arParams['WRITE_MESS_FILDES_TABLE'])
                {
                    $nameStyle  = 'max-width: 200px; color: #848484; vertical-align: middle; padding: 5px 30px 5px 0px; border-bottom: 1px solid #e0e0e0; border-top: 1px solid #e0e0e0;';
                    $valueStyle = 'vertical-align: middle; padding: 5px 30px 5px 0px; border-bottom: 1px solid #e0e0e0; border-top: 1px solid #e0e0e0;';

                    $strFieldsNames .= '<table style="' . $arParams['WRITE_MESS_TABLE_STYLE'] . '"><tbody>';

                    foreach($arPostFields as $code => $val)
                    {
                        $name = $arParams['FORM_FIELDS'][$code]['TITLE'] ? $arParams['FORM_FIELDS'][$code]['TITLE'] : $code;
                        $curVal = is_array($val) ? implode('<br>', $val) : $val;
                        $strFieldsNames .= '<tr>';
                        $strFieldsNames .= '<td style="' . $nameStyle . '">' . $name . '</td>';
                        $strFieldsNames .= '<td style="' . $valueStyle . '">' . $curVal . '</td>';
                        $strFieldsNames .= '</tr>';
                    }

                    $strFieldsNames .= '</tbody></table>';
                }
                else
                {
                    $nameStyle    = 'font-weight:bold;';
                    $defaultStyle = "padding:10px;border-bottom:1px dashed #dadada;";
                    foreach($arPostFields as $code => $val)
                    {
                        $name = $arParams['FORM_FIELDS'][$code]['TITLE'] ? $arParams['FORM_FIELDS'][$code]['TITLE'] : $code;
                        $curVal = is_array($val) ? implode('<br>', $val) : $val;

                        $strFieldsNames .= "\n<div style=\"" . $defaultStyle . "\">";
                        $strFieldsNames .= "\n\t<div style=\"" . $nameStyle . "\">" . $name . "</div>";
                        $strFieldsNames .= "\n\t<div>" . $curVal . "</div>";
                        $strFieldsNames .= "\n</div>";
                    }
                }

                $arServiceFields['FORM_FIELDS'] = $strFieldsNames;

                /// form iblock element
                ///
                ///



                if(intval($arParams['IBLOCK_ID_RECORD'])>0 && $arParams['DETAIL_RECORD_IBLOCK'] == "Y"){
                    $PROP = array();
                    $Title = "";
                    $message = "";
                    foreach($arPostFields as $code => $val){
                        if($code == 'PHONE'){
                            $PROP['PHONE'] = $arPostFields['PHONE'];
                            $dopTitle = $arPostFields['PHONE'];
                        }elseif($code == 'EMAIL'){
                            $PROP['MAIL'] = $arPostFields['EMAIL'];
                        }elseif($code == 'RATING'){
                            $PROP['RATING'] = $arPostFields['RATING'];
                        }elseif($code == 'TITLE'){
                            $PROP['NAME'] = $arPostFields['TITLE'];
                        }elseif($code == 'ITEM_NAME'){
                            $Title = $arPostFields['ITEM_NAME'];
                        }elseif($code == 'MESSAGE'){
                            $message = $arPostFields['MESSAGE'];
                        }
/*
                        $curVal = is_array($val) ? implode('<br>', $val) : $val;
                        $name = $arParams['FORM_FIELDS'][$code]['TITLE'] ? $arParams['FORM_FIELDS'][$code]['TITLE'] : $code;
                        $strFieldsElement .= $name.": ".$curVal."\n"."\n";
//*/
                    }
                }
            }

            //AUTHOR_NAME and AUTHOR_EMAIL
            foreach($arPostFields as $code => $val) {
                if ($code == 'TITLE') {
                    $arServiceFields['AUTHOR_NAME'] = $val;
                }
                if ($code == 'EMAIL') {
                    $arServiceFields['AUTHOR_EMAIL'] = $val;
                }
            }

            /// запиьс в ИБ

            if(intval($arParams['IBLOCK_ID_RECORD'])>0 && $arParams['DETAIL_RECORD_IBLOCK'] == "Y"){
                CModule::IncludeModule("iblock");

                $el = new CIBlockElement;

                $arLoadProductArray = Array(
                    "PROPERTY_VALUES"=> $PROP,
                    "IBLOCK_ID"     	=> 12,
                    'ACTIVE_FROM' => ConvertDateTime(date("d.m.Y H:i:s"),CSite::GetDateFormat("FULL")),
                    "NAME"				=> $Title?$Title:$dopTitle,
                    "ACTIVE"        	=> "N",
                    "PREVIEW_PICTURE"    	=> $hrefUrl ? CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]. $hrefUrl) : "",
                    "PREVIEW_TEXT"    	=> $message,
                    "PREVIEW_TEXT_TYPE"  => 'text',
                    //"DETAIL_TEXT"    	=> $strFieldsElement,
                    //"DETAIL_TEXT_TYPE"  => 'text',
                );

                $PRODUCT_ID = $el->Add($arLoadProductArray);
            }




            //отправка письма администратору
            $arServiceFields['SUBJECT'] = str_replace('#SITE_NAME#', $arServiceFields['SERVER_NAME'], $arParams['MAIL_SUBJECT_ADMIN']);

            if(is_array($arParams['EVENT_MESSAGE_ID']) && !empty($arParams['EVENT_MESSAGE_ID'])){
                foreach($arParams['EVENT_MESSAGE_ID'] as $arMessID){
                    if(!CEvent::Send($arParams['EVENT_NAME'], SITE_ID, $arServiceFields, 'N', $arMessID))
                    {
                        $arMessageError[] = GetMessage('SEND_ERROR_MESS', array("#MESS_ID#" => $arMessID));
                    }
                }
            }else{
                if(!CEvent::Send($arParams['EVENT_NAME'], SITE_ID, $arServiceFields, 'N'))
                {
                    $arMessageError[] = GetMessage('SEND_ERROR');
                }
            }


			//отправка письма Юзеру
//			if($arParams['MAIL_SEND_USER'])
//			{
//				$arFields['SUBJECT'] = $arParams['MAIL_SUBJECT_USER'];
//				if(!$obApiFeedbackEx->Send($arParams['EVENT_NAME'], SITE_ID, $arFields, $arFieldsCodeName, $arParams, true))
//				{
//					if($obApiFeedbackEx->isSuccess())
//						$arMessage['warning'][] = implode('<br>', $obApiFeedbackEx->getErrors());
//					else
//						$arMessage['warning'][] = GetMessage('SEND_MESSAGE_ERROR_USER');
//				}
//			}
		}

		$arResult['FIELDS'] = $arPostFields;
	}


	//==============================================================================
	// View result
	//==============================================================================
	if(!empty($arMessageError))
	{
		$result = array(
			'result'  => 'error',
			'message' => implode("</br>", $arMessageError),
			'html'    => $arPostFieldsTmp,

		);
	}
	else
	{
		$result = array(
		    'result'  => 'ok',
            'message' => $arParams['OK_TEXT'],
            'modal' => '#'.trim($arParams['FORM_ID'])."-answer"
        );
	}

    if($isAjax){
        $APPLICATION->RestartBuffer();
        echo Bitrix\Main\Web\Json::encode($result);
        die();
    }else{
        $arResult['STATUS'] = empty($arMessageError) ? 'ok' : 'error';
        $arResult['ERROR_MSG'] = $arMessageError;
    }

}


//CSS ANTIBOT
$arResult['ANTIBOT'] = $_REQUEST['ANTIBOT'];

$this->IncludeComponentTemplate();

//подключение системного JS-файла
if(!defined("SLAM_FORM_JS_INCLUDE")){
    $APPLICATION->AddHeadScript($componentPath.'/files.js');
    define("SLAM_FORM_JS_INCLUDE", "Y");
}

