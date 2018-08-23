<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);
$FORM_ID = 'formSubscribe' . trim($arParams['FORM_ID']);
?>
<div class="advanced-page__aside hide-adapt">
    <div class="aside-block aside-block--question animateThis" data-anim="fadeInUp">
        <div class="aside-block__wrapper">
            <div class="form">
                <div class="form__wrapper">
                    <div class="form__title"><?=GetMessage("FORM_SUBSCRIBE_TITLE")?></div>
                    <div class="form__caption"><?=GetMessage("FORM_SUBSCRIBE_TEXT")?></div>
                    <form id="<?= $FORM_ID; ?>" class="form__subscribe form__formFocus" method="post" action="<?=SITE_DIR?>include/ajax/subscribe_form.php">
                        <?= bitrix_sessid_post() ?>
                        <input  type="hidden" name="subscribe" value="Y"/>
                        <? if (empty($arResult['SUCCESS'])): ?>
                            <label>
                                <input class="form__input" type="text" name="EMAIL" value="<?= $arResult['EMAIL'] ?>"  placeholder="E-mail *" data-validation="email required"  autocomplete="off" />
                            </label>
                            <button class="red-button red-button--small" type="submit1">
                                <div class="red-button__inner"><?=GetMessage("FORM_SEND")?></div>
                            </button>
                        <? elseif (isset($arResult['MESSAGE'])): ?>
                            <div class="help-block"style="
                                font-size: 19px;
                                color: #3c7b0e;
                            "><?= $arResult['MESSAGE'] ?></div>
                        <? endif ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>