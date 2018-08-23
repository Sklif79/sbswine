<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Contacts");

?>
<div class="advanced-page__half advanced-page__half--left-half">
    <?$APPLICATION->IncludeFile(
        SITE_DIR . 'include/contacts/text_left_info.php',
        Array(),
        Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "text_left_info", 'TEMPLATE' => 'default.php')
    );?>
</div>
<div class="advanced-page__half advanced-page__half--right-half">
    <div class="advanced-page__map-wrapper">
        <?$APPLICATION->IncludeFile(
            SITE_DIR . 'include/contacts/map_info.php',
            Array(),
            Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "map_info", 'TEMPLATE' => 'default.php')
        );?>
    </div>
    <div class="advanced-page__company-info">
        <?$APPLICATION->IncludeFile(
            SITE_DIR . 'include/contacts/rekvizit.php',
            Array(),
            Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "rekvizit", 'TEMPLATE' => 'default.php')
        );?>
    </div>
</div>


<?$APPLICATION->IncludeFile(
    SITE_DIR . 'include/main_form.php',
    Array(),
    Array("MODE" => "text", "SHOW_BORDER" => false, 'TEMPLATE' => 'default.php')
);?>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>