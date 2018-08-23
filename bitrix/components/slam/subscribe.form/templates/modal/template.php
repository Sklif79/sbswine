<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @global $APPLICATION CMain
 * @var $arParams array
 * @var $arResult array
 */
$this->setFrameMode(true);
$FORM_ID = 'formSubscribe'.trim($arParams['FORM_ID']);
?>
<div class="subscribe">
	<div class="inner-wrap clearfix">
		<div class="title"><?=GetMessage('SUBSCRIBE_TITLE')?></div>

		<form id="<?= $FORM_ID; ?>" class="form-subscribe" method="post"
		      action="<?= $arParams["AJAX_MODE"] != "Y" ? $APPLICATION->GetCurPageParam("subscribe=Y", $arParams["KILLPARAMS"]) : "#" ?>">
            <?=bitrix_sessid_post()?>

            <? if (empty($arResult['SUCCESS'])): ?>
				<div class="text"><?=GetMessage('SUBSCRIBE_DESC')?></div>


				<div class="form-group input-wrap<?= isset($arResult['MESSAGE']) ? ' has-error' : '' ?>">
					<div class="input-group">
						<div class="icon"></div>
						<input type="text" name="EMAIL" value="<?= $arResult['EMAIL'] ?>"
						       placeholder="<?=GetMessage('SUBSCRIBE_INPUT_PLACEHOLDER')?>" autocomplete="off" class="input"/>
					</div>
					<div class="errorformSubscribe">
						<div class="help-block"></div>
					</div>
				</div>

				<div class="btn-wrap">
					<input type="hidden" value="Y" name="subscribe"/>
					<button type="submit" class="btn btn-subscribe"><?=GetMessage('SUBSCRIBE_BUTTON')?></button>
				</div>

            <? elseif (isset($arResult['MESSAGE'])): ?>
				<div class="help-block"><?= $arResult['MESSAGE'] ?></div>
            <? endif ?>

		</form>

		<div class="help-block success"></div>



	</div>
</div>



<script type="text/javascript">
    $(window).on('load', function() {
        initSubscribeFormValidations({
            form: '#<?=$FORM_ID?>',
            messageModal: false,
            container: '#errorformSubscribe<?= $FORM_ID; ?>',
            fields: {
                'EMAIL': {
                    validators: {
                        notEmpty: {
                            message: '<?=GetMessage('SUBSCRIBE_ERROR_EMAIL')?>'
                        },
                        regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: '<?=GetMessage('SUBSCRIBE_ERROR_EMAIL')?>'
                        }
                    }
                }
            }
        })
    });
</script>
