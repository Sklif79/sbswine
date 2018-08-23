<div class="age-confirm">
    <div class="age-confirm__modal">
        <?/*?>
        <div class="age-confirm__decor"><img src="<?=SITE_TEMPLATE_PATH?>/img/index/age-confirm-bochka.png" alt="18 year"></div>
        <?//*/?>
        <div class="age-confirm__info">
            <div class="age-confirm__title">Внимание</div>
            <div class="age-confirm__description">Сайт содержит информацию, не рекомендованную для лиц, не достигших совершеннолетнего возраста. Для доступа на сайт, вы должны подтвердить своё совершеннолетие!</div>
            <div class="checkbox age-confirm_item">
                <input class="checkbox__input" id="age-confirm" name="age-confirm" type="checkbox">
                <label class="checkbox__label" for="age-confirm">
                    <div class="checkbox__check-wrapper">
                        <div class="checkbox__check"></div>
                    </div>
                    <div class="checkbox__name">Я старше 18 лет</div>
                </label>
            </div>
            <button class="age-confirm__btn red-button">Отправить</button>
        </div>
    </div>
</div>
<?

$rsSites = CSite::GetByID("s1");
$arSite = $rsSites->Fetch();

$mail =$arSite["EMAIL"];

$APPLICATION->IncludeComponent(
    "slam:easyform",
    "form",
    array(
        "BCC" => "",
        "CATEGORY_EMAIL_PLACEHOLDER" => "",
        "CATEGORY_EMAIL_TITLE" => "E-mail",
        "CATEGORY_EMAIL_TYPE" => "email",
        "CATEGORY_EMAIL_TYPE_VALIDATION" => "",
        "CATEGORY_EMAIL_VALUE" => "",
        "CATEGORY_MESSAGE_PLACEHOLDER" => "",
        "CATEGORY_MESSAGE_TITLE" => "Комментарий",
        "CATEGORY_MESSAGE_TYPE" => "textarea",
        "CATEGORY_MESSAGE_TYPE_VALIDATION" => "",
        "CATEGORY_MESSAGE_VALUE" => "",
        "CATEGORY_PHONE_PLACEHOLDER" => "",
        "CATEGORY_PHONE_TITLE" => "Телефон",
        "CATEGORY_PHONE_TYPE" => "tel",
        "CATEGORY_PHONE_TYPE_VALIDATION" => "",
        "CATEGORY_PHONE_VALUE" => "",
        "CATEGORY_TITLE_PLACEHOLDER" => "",
        "CATEGORY_TITLE_TITLE" => "ФИО",
        "CATEGORY_TITLE_TYPE" => "text",
        "CATEGORY_TITLE_TYPE_VALIDATION" => "",
        "CATEGORY_TITLE_VALUE" => "",
        "CATEGORY_WORK_COMPANY_PLACEHOLDER" => "",
        "CATEGORY_WORK_COMPANY_TITLE" => "Компания",
        "CATEGORY_WORK_COMPANY_TYPE" => "text",
        "CATEGORY_WORK_COMPANY_TYPE_VALIDATION" => "",
        "CATEGORY_WORK_COMPANY_VALUE" => "",
        "DISABLE_SEND_MAIL" => "N",
        "DISPLAY_FIELDS" => array(
            0 => "TITLE",
            1 => "EMAIL",
            2 => "PHONE",
            3 => "MESSAGE",

        ),
        "EMAIL_TO" => $mail,
        "ERROR_TEXT" => "Произошла ошибка. Сообщение не отправлено.",
        "EVENT_MESSAGE_ID" => array(
            0 => "31",
        ),
        "FIELDS_ORDER" => "TITLE,EMAIL,PHONE,ITEM_NAME,MESSAGE",
        "FORM_AUTOCOMPLETE" => "Y",
        "FORM_ID" => "callback-form-modal",
        "FORM_SUBMIT_VALUE" => "Отправить",
        "HIDE_ASTERISK" => "N",
        "HIDE_FIELD_NAME" => "N",
        "MAIL_SEND_USER" => "N",
        "MAIL_SUBJECT_ADMIN" => "#SITE_NAME#: Сообщение из формы обратной связи Заказать звонок",
        "OK_TEXT_TITLE" => "Спасибо за сообщение!",
        "OK_TEXT" => "Наш менеджер свяжется с вами в ближайшее время.",
        "OK_TEXT_AFTER" => "Заказать звонок",

        "REPLACE_FIELD_FROM" => "N",
        "REQUIRED_FIELDS" => array(
            0 => "TITLE",
            1 => "EMAIL",
            2 => "PHONE",
        ),
        "USE_BOOTSRAP_CSS" => "N",
        "USE_BOOTSRAP_JS" => "N",
        "USE_CAPTCHA" => "N",
        "USE_JQUERY" => "N",
        "WIDTH_FORM" => "",
        "WRITE_MESS_FILDES_TABLE" => "N",
        "COMPONENT_TEMPLATE" => "form",

    ),
    false
);?>

