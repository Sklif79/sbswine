<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
	die();

if(method_exists($this, 'setFrameMode'))
	$this->setFrameMode(true);

$FORM_ID           = trim($arParams['FORM_ID']);
$FORM_AUTOCOMPLETE = $arParams['FORM_AUTOCOMPLETE'] ? 'on' : 'off';
$FORM_ACTION_URI   = "";
$WITH_FORM = strlen($arParams['WIDTH_FORM']) > 0 ? 'style="max-width:'.$arParams['WIDTH_FORM'].'"' : '';
?>

<div class="slam-easyform" <?=$WITH_FORM?> >
    <form id="<?=$FORM_ID?>"
          class="uk-form <?=$FIELD_NAME_POSITION?>"
          name="api_feedbackex_form"
          enctype="multipart/form-data"
          method="POST"
          action="<?=$FORM_ACTION_URI;?>"
          autocomplete="<?=$FORM_AUTOCOMPLETE?>"
          novalidate="novalidate"
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

        <div class="row">
            <?
            if(count($arParams['FORM_FIELDS']) > 0)
            {
                foreach($arParams['FORM_FIELDS'] as $fieldCode => $arField)
                {
                    $placeholder = $arField['PLACEHOLDER'] ? 'placeholder="'.$arField['PLACEHOLDER'].'"':'';

                    //добавление к названию двоеточия и звездочки
                    if(!$arParams['HIDE_ASTERISK'] && !$arParams['HIDE_FIELD_NAME']){
                        $asteriks = ':';
                        if($arField['REQUAIRED']) {
                            $asteriks = '<span class="asterisk">*</span>:';
                        }
                        $arField['TITLE'] = $arField['TITLE'].$asteriks;
                    }

                    if($arField['TYPE'] == 'textarea')
                    {
                        ?>
                        <div class="col-xs-12">
                            <div class="form-group has-feedback">
                                <? if(!$arParams['HIDE_FIELD_NAME']): ?>
                                    <label class="control-label" for="<?=$arField['ID']?>"><?=$arField['TITLE']?></label>
                                <? endif; ?>
                                <div>
                                    <textarea name="<?=$arField['NAME']?>" <?=$placeholder;?>
                                                 id="<?=$arField['ID']?>"
                                                 rows="5"
                                                 class="form-control"
                                        ><?=$arField['VALUE'];?></textarea>
                                </div>
                            </div>
                        </div>
                    <?}elseif($arField['TYPE'] == 'select'){?>
                        <div class="col-xs-12 switch-select">
                            <div class="form-group has-feedback switch-parent">
                                <? if(!$arParams['HIDE_FIELD_NAME']): ?>
                                    <label for="<?=$arField['ID']?>" class="control-label"><?=$arField['TITLE']?></label>
                                <? endif; ?>
                                <select id="<?=$arField['ID']?>" name="<?=$arField['NAME']?>" class="form-control">
                                    <option value="">&#8212;</option>
                                    <?if(is_array($arField['VALUE'])):?>
                                        <?foreach($arField['VALUE'] as $arVal):?>
                                            <?if(!empty($arVal)):?>
                                                <option value="<?=$arVal?>"><?=$arVal?></option>
                                            <?endif;?>
                                        <?endforeach;?>
                                        <?if($arField['SET_ADDITION_SELECT_VAL']):?>
                                            <option value="" data-switch="other"><?=$arField['ADDITION_SELECT_VAL']?></option>
                                        <?endif;?>
                                    <?endif;?>
                                </select>
                                <small class="help-block-pseudo"></small>
                            </div>
                            <?if($arField['SET_ADDITION_SELECT_VAL']):?>
                                <div class="form-group has-feedback switch-child hidden">
                                    <? if(!$arParams['HIDE_FIELD_NAME']): ?>
                                        <label for="<?=$arField['SET_ADDITION_SELECT_ID']?>" class="control-label"><?=$arField['TITLE']?></label>
                                    <? endif; ?>
                                    <div class="row">
                                        <div class="col-xs-9">
                                            <input type="text" id="<?=$arField['SET_ADDITION_SELECT_ID']?>" name="<?=$arField['ADDITION_SELECT_NAME']?>" class="form-control" value="" maxlength="30">
                                        </div>
                                        <div class="col-xs-3">
                                            <a href="" class="btn-switch-back" onclick="return false;">← К списку</a>
                                        </div>
                                    </div>
                                </div>
                            <?endif;?>
                        </div>
                    <?}else{?>
                        <div class="col-xs-12">
                            <div class="form-group has-feedback">
                                <? if(!$arParams['HIDE_FIELD_NAME']): ?>
                                    <label class="control-label" for="<?=$arField['ID']?>"><?=$arField['TITLE']?></label>
                                <? endif; ?>
                                <input type="<?=$arField['TYPE'];?>" id="<?=$arField['ID']?>" name="<?=$arField['NAME']?>" value="<?=$arField['VALUE'];?>" <?=$placeholder;?> class="form-control">
                            </div>
                        </div>
                        <?
                    }
                }
            }
            ?>
            <?if($arParams["USE_CAPTCHA"]):?>
                <div class="col-xs-12">
                    <div class="form-group has-feedback">
                        <label for="<?=$FORM_ID?>-captchaValidator" class="control-label">Проверка "Я не робот"</label>
                        <input id="<?=$FORM_ID?>-captchaValidator" class="form-control" type="text" name="captchaValidator" style="border: none; height: 0; padding: 0; visibility: hidden;">
                        <div id="<?=$FORM_ID?>-captchaContainer"></div>
                    </div>
                </div>
            <?endif;?>

            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary pull-right submit-button" data-load="Загрузка..." data-default="<?=$arParams['FORM_SUBMIT_VALUE']?>"><?=$arParams['FORM_SUBMIT_VALUE']?></button>
            </div>

        </div>
    </form>
</div>

<?//*?>
<script>
    //примеры валидации:   http://formvalidation.io/examples/contact-form/

    $(window).on('load', function() {
        initFormValidations({
            form: '#<?=$FORM_ID?>',
            url: 'action_2.php',
            messageModal: false,
            <?if($arParams["USE_CAPTCHA"]):?>
            captcha: {containerId: '<?=$FORM_ID?>-captchaContainer',sitekey: '<?=$arParams["CAPTCHA_KEY"]?>',inputName: 'captchaValidator'},
            <?else:?>
            captcha: false,
            <?endif;?>
            <?if($arParams['REQUIRED_FIELDS'] || $arParams["USE_CAPTCHA"]):?>
                fields: {
                    <?if($arParams["USE_CAPTCHA"]):?>
                    captchaValidator: {
                        validators: {
                            notEmpty: {
                                message: 'Вы не прошли проверку "Я не робот"'
                            }
                        }
                    }
                    <?endif;?>
                    <?foreach($arParams['REQUIRED_FIELDS'] as $key => $Val):
                    $type = $arParams['FORM_FIELDS'][$Val]['TYPE'];
                    ?>
                        <?if($key != 0 || $arParams["USE_CAPTCHA"]):?>,<?endif;?>
                        'FIELDS[<?=$Val?>]': {
                            validators: {
                                notEmpty: {
                                    message: 'Обязательное поле'
                                }
                                <?if($type == 'email'):?>
                                    ,emailAddress: {
                                        message: 'Введите корректный e-mail'
                                    }
                                <?endif;?>
                                <?if(strlen(trim($arParams[ 'CATEGORY_' . $Val . "_TYPE_VALIDATION" ])) > 0):?>
                                    ,<?=$arParams[ 'CATEGORY_' . $Val . "_TYPE_VALIDATION" ]?>
                                <?endif;?>
                            }
                        }
                        <?if(strlen(trim($arParams[ 'CATEGORY_' . $Val . "_ADD_VAL" ])) > 0):?>
                            ,'FIELDS[<?=$Val?>_ADD]': {
                                validators: {
                                    notEmpty: {
                                        message: 'Обязательное поле'
                                    }
                                }
                            }
                        <?endif;?>
                    <?endforeach;?>
                }
            <?endif;?>
        });
    });
</script>


