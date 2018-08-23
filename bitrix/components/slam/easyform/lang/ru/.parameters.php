<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

//DEFAULT_FIELDS
$MESS['FIELD_TITLE'] = 'Ваше имя';
$MESS['FIELD_WORK_POSITION'] = 'Должность';
$MESS['FIELD_WORK_COMPANY'] = 'Компания';
$MESS['FIELD_EMAIL'] = 'Ваш E-mail';
$MESS['FIELD_PHONE'] = 'Мобильный телефон';
$MESS['FIELD_ADDRESS'] = 'Адрес';
$MESS['FIELD_SERVICES'] = 'Услуга';
$MESS['FIELD_MESSAGE'] = 'Сообщение';


//VISUAL
$MESS['CAPTCHA'] = 'Капча';
$MESS['USE_CAPTCHA'] = 'Использовать капчу reCAPTCHA';
$MESS['USE_CAPTCHA_TIP'] = 'Умная капча от Google';
$MESS['CAPTCHA_KEY'] = 'Ключ reCAPTCHA';
$MESS['CAPTCHA_KEY_TIP'] = 'Получить ключ вы можете на сайте https://www.google.com/recaptcha/admin';
$MESS['CAPTCHA_SECRET_KEY'] = 'Секретный ключ reCAPTCHA';
$MESS['CAPTCHA_SECRET_KEY_TIP'] = 'Получить секретный ключ вы можете на сайте https://www.google.com/recaptcha/admin';

$MESS['FIELDS_ORDER'] = 'Расположение полей формы';
$MESS['UNIQUE_FORM_ID'] = 'ID формы';
$MESS['WIDTH_FORM'] = 'Ширина формы';
$MESS['HIDE_FIELD_NAME'] = 'Скрывать названия полей  формы';
$MESS['MFP_FORM_TITLE_VALUE'] = 'Обратная связь';
$MESS['FORM_SUBMIT_VALUE_DEFAULT'] = 'Отправить';
$MESS['FORM_SUBMIT_VALUE'] = 'Название кнопки';
$MESS['MFP_OK_MESSAGE'] = 'Сообщение об успешной отправке';
$MESS['MFP_OK_TEXT'] = 'Сообщение успешно отправлено';
$MESS['MFP_ERROR_MESSAGE'] = 'Сообщение об ошибке';
$MESS['MFP_ERROR_TEXT'] = 'Произошла ошибка. Сообщение не отправлено.';
$MESS['OK_TEXT_AFTER'] = 'Текст под сообщением';
$MESS['OK_TEXT_AFTER_DEFAULT'] = 'Спасибо! Мы рассмотрим сообщение и обязательно свяжемся с Вами.<br>Пожалуйста, дождитесь ответа.';
$MESS['MFP_EMAIL_TO'] = 'E-mail, на который будет отправлено письмо';
$MESS['MFP_BCC'] = 'Скрытая копия';
$MESS['MFP_DISPLAY_FIELDS'] = 'Поля';
$MESS['MFP_REQUIRED_FIELDS'] = 'Обязательные поля';
$MESS['REPLACE_FIELD_FROM'] = 'Заменять в письме поле "От" на e-mail посетителя';
$MESS['HIDE_ASTERISK'] = 'Убрать двоеточие и звездочки';
$MESS['FORM_AUTOCOMPLETE'] = 'Автокомплит значений полей формы';


//MAIL
$MESS['GROUP_MAIL'] = 'Настройки отправки писем';
$MESS['DISABLE_SEND_MAIL'] = 'Отключить отправку писем';
$MESS['MFP_EMAIL_TEMPLATES'] = 'Шаблон письма';
$MESS['MAIL_SUBJECT_ADMIN'] = 'Тема сообщения для администратора';
$MESS['MAIL_SUBJECT_USER'] = 'Тема сообщения для посетителя';
$MESS['MAIL_SUBJECT_ADMIN_DEFAULT'] = '#SITE_NAME#: Сообщение из формы обратной связи';
$MESS['MAIL_SUBJECT_USER_DEFAULT'] = '#SITE_NAME#: Копия сообщения из формы обратной связи';
$MESS['MAIL_SEND_USER'] = 'Отправить копию письма посетителю';
$MESS['WRITE_MESS_FILDES_TABLE'] = 'Записывать поля в почтовый шаблон таблицей';



//GROUP_JS_VALIDATE_SETTINGS
$MESS['GROUPS_JS_VALIDATE_SETTINGS'] = "JS-плагины";
$MESS['INCLUDE_JQUERY'] = 'Подключить jQuery-1.12.4';
$MESS['USE_BOOTSRAP_CSS'] = 'Подключить стандартные стили Bootstrap 3';
$MESS['USE_BOOTSRAP_JS'] = 'Подключить стандартный JS Bootstrap 3';
$MESS['USE_BOOTSRAP_JS_TIP'] = 'Необходим для работы модального окна';

//GROUP FIELDS
$MESS['GROUP_FIELD_TITLE'] = ' - настройки поля';
$MESS['GROUP_FIELD_NAME'] = 'Название';
$MESS['TYPE_FIELD'] = 'Тип поля';
$MESS['GROUP_FIELD_REQ'] = 'Дополнительные правила валидации';
$MESS['GROUP_FIELD_VALUE'] = 'Значение';
$MESS['GROUP_FIELD_SELECT_ADD'] = 'Дополнительное значение (вводимое вручную)';
$MESS['GROUP_FIELD_SELECT_ADD_DEF'] = 'Другое (напишите свой вариант)';

//EVENT_TYPE RU
$MESS['RU_ET_NAME']        = 'Отправка сообщения через суперформу SLAM';
$MESS['RU_ET_DESCRIPTION'] = '=== Служебные макросы ===
#AUTHOR_NAME# - Автор сообщения
#SUBJECT# - Тема письма
#FORM_NAME# - Название формы
#FORM_FIELDS# - Содержание всех полей в табличном либо строчном виде (в зависимости от настроек компонента формы)
#EMAIL_FROM# - Email отправителя письма (E-mail по-умолчанию, либо значение поля формы "E-mail", в зависимости от настроек)
#EMAIL_TO# - Email получателя письма (устанавливается в настройках комопнента)
#EMAIL_BCC# - Email скрытой копии (устанавливается в настройках комопнента)

=== Макросы полей формы по умолчанию ===
#TITLE# - Ваше Имя
#WORK_POSITION# - Должность
#WORK_COMPANY# - Компания
#EMAIL# - E-mail
#PHONE# - Мобильный телефон
#ADDRESS# - Адрес
#SERVICES# - Услуга
#MESSAGE# - Сообщение

=== Любые поля формы===
Значение символьного кода любого поля, например:
#EMAIL#

=== Системные макросы ===
';


//EVENT_MESSAGE ADMIN
$MESS['EM_EMAIL_FROM']    = '#EMAIL_FROM#';
$MESS['EM_EMAIL_TO']      = '#EMAIL_TO#';
$MESS['EM_BCC']      = '#EMAIL_BCC#';
$MESS['EM_SUBJECT'] = '#SUBJECT#';
$MESS['EM_MESSAGE']       = 'Информационное сообщение сайта #SITE_NAME#<br>
------------------------------------------<br>
<br>
Вам было отправлено сообщение через форму #FORM_NAME#<br>
<br>
Текст сообщения:<br>
#FORM_FIELDS#<br>
<br>
Сообщение сгенерировано автоматически.
';





