<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

///pr($arResult);?>


<?if (!empty($arResult["QUESTIONS"])):?>

<div class="index-gray-block__right-side">
    <div class="index-gray-block__title h3 upper"><?=$arResult["CHANNEL"]["~TITLE"]?></div>
    <div class="aside-block aside-block--question">
        <?foreach ($arResult["QUESTIONS"] as $arQuestion):?>
        <form class="aside-block__wrapper aside-block__formFocus" action="<?=POST_FORM_ACTION_URI?>" method="post">
            <div class="aside-block__text animateThis" data-anim="fadeInUp"><?=$arQuestion["~QUESTION"]?></div>
            <div class="checkboxes checkboxes--radial animateThis" data-anim="fadeInUp">
                <div class="checkboxes__wrapper">
                        <input type="hidden" name="vote" value="Y">
                        <input type="hidden" name="PUBLIC_VOTE_ID" value="<?=$arResult["VOTE"]["ID"]?>">
                        <input type="hidden" name="VOTE_ID" value="<?=$arResult["VOTE"]["ID"]?>">
                        <?=bitrix_sessid_post()?>

                            <?foreach ($arQuestion["ANSWERS"] as $arAnswer):?>
                                <?
                                switch ($arAnswer["FIELD_TYPE"]):
                                    case 0://radio
                                        $value=(isset($_REQUEST['vote_radio_'.$arAnswer["QUESTION_ID"]]) &&
                                            $_REQUEST['vote_radio_'.$arAnswer["QUESTION_ID"]] == $arAnswer["ID"]) ? 'checked="checked"' : '';
                                    break;
                                endswitch;
                                ?>
                                <?switch ($arAnswer["FIELD_TYPE"]):
                                    case 0://radio?>
                                        <div class="checkbox checkboxes__item">
                                            <input  <?=$value?> class="checkbox__input" id="radio_<?=$arAnswer["ID"]?>" name="vote_radio_<?=$arAnswer["QUESTION_ID"]?>" value="<?=$arAnswer["ID"]?>" type="radio">
                                            <label class="checkbox__label" for="radio_<?=$arAnswer["ID"]?>">
                                                <div class="checkbox__check-wrapper">
                                                    <div class="checkbox__check checkbox__check--radio"></div>
                                                </div>
                                                <div class="checkbox__name"><?=$arAnswer["MESSAGE"]?></div>
                                            </label>
                                        </div>
                                    <?break?>
                                <?endswitch?>
                            <?endforeach?>
                    <button class="red-button red-button--small" type="submit">
                        <div class="red-button__inner">проголосовать</div>
                    </button>
                </div>
            </div>
        </form>
        <?endforeach?>
    </div>
</div>


<?endif?>
