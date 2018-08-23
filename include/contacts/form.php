
<?

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
        "EMAIL_TO" => htmlspecialchars(COption::GetOptionString("main","DEF_EMAIL","")),
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
        "MAIL_SUBJECT_ADMIN" => "#SITE_NAME#: Сообщение из формы обратной связи в Контактах",
        "OK_TEXT" => "Сообщение успешно отправлено",
        "OK_TEXT_AFTER" => "Форма обратной связи",

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
        "CATEGORY_RATING_TITLE" => "Оценка",
        "CATEGORY_RATING_TYPE" => "rating",
        "CATEGORY_RATING_PLACEHOLDER" => "",
        "CATEGORY_RATING_VALUE" => "",
        "CATEGORY_ITEM_NAME_TITLE" => "Услуга",
        "CATEGORY_ITEM_NAME_TYPE" => "hidden_text",
        "CATEGORY_ITEM_NAME_PLACEHOLDER" => "",
        "CATEGORY_ITEM_NAME_VALUE" => $GLOBALS["SERVICES_HIDDEN_NAME"],
        "CATEGORY_PHOTO_TITLE" => "Добавить фото",
        "CATEGORY_PHOTO_TYPE" => "file",
        "CATEGORY_PHOTO_PLACEHOLDER" => "",
        "CATEGORY_PHOTO_VALUE" => "",
        "CATEGORY_RATING_TYPE_VALIDATION" => "",
        "CATEGORY_ITEM_NAME_TYPE_VALIDATION" => "",
        "CATEGORY_PHOTO_TYPE_VALIDATION" => "",


    ),
    false
);?>