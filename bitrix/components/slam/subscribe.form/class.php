<?

//Ссылка на отписку от рассылок
AddEventHandler("subscribe", "BeforePostingSendMail", array("SubscribeHandlers", "BeforePostingSendMailHandler"));
class SubscribeHandlers
{
    function BeforePostingSendMailHandler($arFields)
    {
        $rsSub = CSubscription::GetByEmail($arFields["EMAIL"]);
        $arSub = $rsSub->Fetch();

        $arFields["BODY"] = str_replace("#MAIL_ID#", $arSub["ID"], $arFields["BODY"]);
        $arFields["BODY"] = str_replace("#MAIL_MD5#", SubscribeHandlers::GetMailHash($arFields["EMAIL"]), $arFields["BODY"]);

        return $arFields;
    }

    function GetMailHash($email)
    {
        return md5(md5($email) . MAIL_SALT);
    }
}
    class CSlamSubscribeForm  extends CBitrixComponent
    {
        private $ob;

        function onPrepareComponentParams($arParams) {

            if (!\Bitrix\Main\Loader::includeModule("subscribe")) {
                throw new \Exception(GetMessage("SUBSCRIBE_MODULE_NOT_INSTALLED"));
            }

            return $arParams;
        }

        function ob() {
            if (empty($this->ob)) {
                $this->ob = new CSubscription;
            }
            return $this->ob;
        }

        function subscribe($email) {

            CModule::IncludeModule("iblock");
            $el = new CIBlockElement;

            $arLoadProductArray = Array(
                "IBLOCK_ID" => 13,
                "DATE_ACTIVE_FROM" => ConvertDateTime(date("d.m.Y H:i:s"),CSite::GetDateFormat("FULL")),
                "NAME" => $email,
                "ACTIVE" => "Y",

            );
            $PRODUCT_ID = $el->Add($arLoadProductArray);
//*/
            global $USER;

            $arFields = array(
                'ACTIVE' => 'Y',
                'EMAIL' => $email,
                "FORMAT" => "html"
            );

            //$dbl = CRubric::GetList(array(), array("ACTIVE"=>"Y", "LID" => "s2"));
            $dbl = CRubric::GetList();
            while($arRes = $dbl->Fetch())
                $arFields['RUB_ID'][] = $arRes['ID'];

            if( $USER->IsAuthorized() ){
                $arFields['USER_ID'] = $USER->GetID();

            }
            $arFields['CONFIRMED'] = 'Y';
            $arFields['SEND_CONFIRM'] = 'N';


            return $this->ob()->Add($arFields);
        }

        function confirm($id, $code) {
            $id = intval($id);
            if ($sub = CSubscription::GetByID($id)->Fetch()) {
                if ($code == $sub['CONFIRM_CODE']) {
                    $this->ob()->Update($id, array("CONFIRMED" => "Y"));
                    return true;
                }
            }
        }

        function unsubscribe($id) {
            $id = intval($id);
            CSubscription::Delete($id);
        }



        function jsAction($action, $data = array())
        {
            global $APPLICATION;

            $APPLICATION->RestartBuffer();

            echo json_encode(array('action' => "_{$action}", 'data' => $data));
            die();
        }


        function executeComponent() {
            global $USER, $APPLICATION;
            $isAjax = true;
            $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

            //\Bitrix\Main\Page\Asset::getInstance()->addJs("{$this->getPath()}/script.js");

            if (!empty($_REQUEST['ID']) && !empty($_REQUEST['CONFIRM_CODE'])) {

                $this->confirm($_REQUEST['ID'], $_REQUEST['CONFIRM_CODE']);
                $_SESSION['ON_LOAD_MESSAGE'] = GetMessage("SUBSCRIBE_ON_LOAD_MESSAGE");

            } elseif (!empty($_REQUEST['unsubscribe'])) {

                $this->unsubscribe($_REQUEST['unsubscribe']);
                $this->jsAction('alert_success', array('text' => GetMessage("SUBSCRIBE_UN_SUCCESS") ));

            } elseif ( !empty( $_REQUEST['subscribe'] ) && isset($_REQUEST['EMAIL']) && check_bitrix_sessid()) {

                if (!empty($_REQUEST['EMAIL'])) {
                    $this->arResult['EMAIL'] = $_REQUEST['EMAIL'];

                    $id = $this->subscribe($this->arResult['EMAIL']);

                    if (!empty($id)) {
                        CSubscription::Authorize($id);


                        $this->arResult['SUCCESS'] = true;
                        $this->arResult['MESSAGE'] =  GetMessage("SUBSCRIBE_SUCCESS");



                        $arFields = array();
                        $arFields['EMAIL'] =  $this->arResult['EMAIL'];
                        $arFields['MAIL_ID'] = $id;
                        $arFields['MAIL_MD5'] = SubscribeHandlers::GetMailHash($arFields["EMAIL"]);



                        $event = new CEvent;
                        $event->Send("SUBSCRIBE_FORM", SITE_ID, $arFields);

                    } else {
                        $this->arResult['MESSAGE'] = $this->ob()->LAST_ERROR;
                    }
                } else {
                    $this->arResult['MESSAGE'] =  GetMessage("SUBSCRIBE_ERROR_EMAIL");
                }




                if(empty($this->arResult['SUCCESS'])) {
                    $result = array(
                        'result'  => 'error',
                        'message' => $this->arResult['MESSAGE'],

                    );
                } else {
                    $result = array(
                        'result'  => 'ok',
                        'message' => $this->arResult['MESSAGE'],
                        'modal' => "#subscribe-answer",
                    );
                }

                if($isAjax){
                    $APPLICATION->RestartBuffer();
                    echo \Bitrix\Main\Web\Json::encode($result);
                    die();
                }
            }

            $this->includeComponentTemplate();

       

        }
    }