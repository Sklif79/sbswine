<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
$APPLICATION->IncludeComponent("slam:subscribe.form", "subscribe", array(
    "AJAX_MODE" => "N",
    "AJAX_OPTION_JUMP" => "N",
    "AJAX_OPTION_STYLE" => "N",
    "IBLOCK_ID" => "13",
    "FORM_ID" => "1"
    ),
    false,
    array(
        "ACTIVE_COMPONENT" => "Y"
    )
);
?>
<div class="modals">
    <div class="remodal" id="subscribe-answer" data-remodal-id="subscribe-answer">
        <button class="remodal-close" data-remodal-action="close"></button>
        <div class="h3 upper">Спасибо за подписку!</div>
        <p>Теперь мы сможем оповещать вас о новинках одним из первых.</p>
    </div>
</div>

