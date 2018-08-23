<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(method_exists($this, 'setFrameMode'))
	$this->setFrameMode(true);

$FORM_ID           = trim($arParams['FORM_ID']);
$FORM_AUTOCOMPLETE = $arParams['FORM_AUTOCOMPLETE'] ? 'on' : 'off';
$FORM_ACTION_URI   = "";
$WITH_FORM = strlen($arParams['WIDTH_FORM']) > 0 ? 'style="max-width:'.$arParams['WIDTH_FORM'].'"' : '';
?>


<div class="modals">
    <div class="remodal" id="<?=$FORM_ID?>-answer" data-remodal-id="<?=$FORM_ID?>-answer">
        <button class="remodal-close" data-remodal-action="close"></button>
        <div class="h3 upper"><?=$arParams["OK_TEXT_TITLE"]?></div>
        <p><?=$arParams["OK_TEXT"]?></p>
    </div>
</div>

<div class="modals">


<div class="remodal" id="<?=$FORM_ID?>" data-remodal-id="<?=$FORM_ID?>">
    <button class="remodal-close" data-remodal-action="close"></button>
    <div class="form">
        <div class="form__wrapper">
            <div class="form__title"><?=$arParams["OK_TEXT_AFTER"]?></div>
        <form id="<?=$FORM_ID?>-form"
              class="form__formFocus <?=$FIELD_NAME_POSITION?>"
              name="api_feedbackex_form"
              enctype="multipart/form-data"
              method="POST"
              action="<?=$FORM_ACTION_URI;?>"
              autocomplete="<?=$FORM_AUTOCOMPLETE?>"
              novalidate="novalidate"
              data-success="#callbackSuccess"
              >

            <!-- Сообщение, отображаемое в случае успешной отправки данных -->
            <div class="alert alert-success <?if($arResult['STATUS'] != 'ok'):?>hidden<?endif;?>" role="alert">
                <?=$arParams['OK_TEXT']?>
            </div>
            <!-- Сообщение, отображаемое в случае неудачной отправки данных -->
            <div class="alert alert-danger <?if($arResult['STATUS'] != 'error'):?>hidden<?endif;?>" role="alert">
                <?=$arParams['ERROR_TEXT']?>
                <?if(!empty($arResult['ERROR_MSG'])):?>
                    </br>
                    <?=implode('</br>', $arResult['ERROR_MSG'])?>
                <?endif;?>
            </div>

            <input type="hidden" name="FORM_ID" value="<?=$FORM_ID?>">
            <input type="text" name="ANTIBOT[NAME]" value="<?=$arResult['ANTIBOT']['NAME'];?>" class="hidden">

                <?
                if(count($arParams['FORM_FIELDS']) > 0)
                {
                    foreach($arParams['FORM_FIELDS'] as $fieldCode => $arField)
                    {
                        $placeholder = $arField['PLACEHOLDER'] ? 'placeholder="'.$arField['PLACEHOLDER'].'"':'';

                        //добавление к названию двоеточия и звездочки
                        if(!$arParams['HIDE_ASTERISK'] && !$arParams['HIDE_FIELD_NAME']){
                            $asteriks = '';
                            if($arField['REQUAIRED']) {
                                $asteriks = '*';
                            }
                            $arField['TITLE'] = $arField['TITLE'];
                        }

                        if($arField['TYPE'] == 'textarea'):?>
                            <textarea class="form__input form__input--textarea" name="<?=$arField['NAME']?>" placeholder="<?=$arField['TITLE'].' '.$asteriks?>"></textarea>
                        <?elseif($arField['TYPE'] == 'file'):?>
                            <div class="form__label form__label--file" id="files-input">
                                <input value="" class="form__input" data-name="<?=$arField['NAME']?>" name="<?=$arField['NAME']?>[]" type="hidden" >

                                <div class="t2"><?=$arField['TITLE']?></div>
                                <div class="form__file-button" id="file-input-button"><?=GetMessage("FORM_FILE_ITEM")?></div>
                            </div>
                        <?elseif($arField['TYPE'] == 'rating'):?>
                            <div class="form__stars">
                                <div class="form__stars-placeholder">
                                    <div class="t2"><?=$arField['TITLE'].' '.$asteriks?>:</div>
                                </div>
                                <div class="form__stars-items">
                                    <label class="input-rating input-wrapper js-stars">
                                        <div class="star-wrapper">
                                            <?for($i=1; $i<6; $i++): ?>
                                                <div class="star-item" id="rev-star-<?=$i?>" data-num="<?=$i?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 40.3 38.3">
                                                        <path d="M20.1 0l6.3 12.6 13.9 2-10.1 9.8 2.4 13.9-12.5-6.5-12.4 6.5 2.4-13.9L0 14.6l13.9-2z"/>
                                                    </svg>
                                                </div>
                                            <?endfor;?>
                                            <input class="rev-hidden"  name="<?=$arField['NAME']?>" type="number" style="width: 1px;height: 1px;opacity:0;" data-validation="required" data-validation-error-msg="Оценка обязательна" >
                                        </div>
                                    </label>
                                </div>
                            </div>
                        <?else:?>
                            <?
                            $valid = '';
                            if($arField['TYPE'] == 'tel'){
                                $valid = 'number ';
                            }elseif($arField['TYPE'] == 'email'){
                                $valid = 'email ';
                            }
                            ?>
                            <label <?=($arField['TYPE'] == 'hidden_text'?'class="hide"':"")?>>
                                <input<?if($arField['REQUAIRED']):?> data-validation="<?=$valid?>required"<?endif;?>  value="<?=$arField['VALUE'];?>" class="form__input" name="<?=$arField['NAME']?>" type="text" placeholder="<?=$arField['TITLE'].' '.$asteriks?>" >
                                <?/*?>
                                <input value="<?=$arField['VALUE'];?>" class="form__input" name="<?=$arField['NAME']?>" type="text" placeholder="<?=$arField['TITLE'].' '.$asteriks?>" data-validation="
                                <?=$arField['TYPE']?>">
                                <?//*/?>
                            </label>
                        <?endif;?>
                    <?}
                }
                ?>
            <div class="form__caption"><span>*</span> <?=GetMessage("FORM_MANDATORY_ITEM")?></div>
            <button class="red-button" type="submit">
                <div class="red-button__inner"><?=GetMessage("FORM_SEND")?></div>
            </button>
        </form>
        </div>
    </div>
    </div>
</div>
