<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;
?>
<div class="news-page-callback">
    <?foreach($arResult["ITEMS"] as $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        $trigger = false;
        ?>
        <div class="callback-big animateThis" data-anim="fadeInUp" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="callback-big__wrapper">
                <?if($arItem["RESIZE_IMG"]):?>
                <div class="callback-big__image-wrapper">
                    <div class="callback-big__image" style="background-image: url('<?=$arItem["RESIZE_IMG"]["src"]?>');"></div>
                </div>
                <?endif;?>
                <div class="callback-big__info">
                    <div class="callback-big__info-block">
                        <div class="t2"><?=ToLower($arItem["DISPLAY_ACTIVE_FROM"])?></div>
                        <div class="callback-big__name h3"><?=$arItem["PROPERTIES"]["NAME"]["~VALUE"]?></div>
                    </div>
                    <div class="callback-big__info-block">
                        <div class="h2"><?=$arItem["~NAME"]?></div>
                        <div class="callback-big__stars-wrapper">
                            <div class="callback-big__stars">
                                <?for($i=0; $i<5; $i++): ?>
                                    <svg class="star">
                                        <use xlink:href="#star<?if($i<intval($arItem["PROPERTIES"]["RATING"]["VALUE"])):?>-active<?endif;?>"/>
                                    </svg>
                                <?endfor;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="callback-big__wrapper">
                <div class="callback-big__empty-wrapper"></div>
                <div class="callback-big__info callback-big__info--advanced">
                    <div class="advanced-list">
                        <?if(strlen(strip_tags($arItem["~PREVIEW_TEXT"]))>350 ){
                            $trigger = true;
                        }
                        ?>
                        <div class="<?=($trigger?"advanced-list__list":"")?>">
                            <p><?=strip_tags($arItem["~PREVIEW_TEXT"])?></p>
                        </div>
                        <?if($trigger):?>
                            <div class="underline underline--dotted underline--nomarg advanced-list-trigger" data-text-hide="<?=GetMessage("SHOP_PAGE_BTN_MORE_DESC_CUT_HIDE")?>" data-show-name="<?=GetMessage("SHOP_PAGE_BTN_MORE_DESC_CUT")?>">
                                <?=GetMessage("SHOP_PAGE_BTN_MORE_DESC")?>
                            </div>
                        <?endif;?>
                    </div>
                </div>
            </div>
        </div>
    <?endforeach;?>
</div>