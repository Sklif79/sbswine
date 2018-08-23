<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;
?>
<div class="index-main-slider double-slider">
    <div class="index-main-slider__first animateThis" data-anim="fadeInUp">
        <div class="index-main-slider__slider first-slider" id="index-main-slider__first" data-slick="{&quot;arrows&quot;: true}">
            <?foreach($arResult["ITEMS"] as $arItem):
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="index-main-slider__slide">
                    <div class="index-main-slider__slide-inner" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <?if($arItem["PREVIEW_TEXT"]):?>
                            <div class="t2"><?=$arItem["~PREVIEW_TEXT"]?></div>
                        <?endif;?>
                            <div class="h1"><?=$arItem["~NAME"]?></div>
                        <?if($arItem["PROPERTIES"]["LINK"]["VALUE"]):?>
                            <div class="red-button--wrapper">
                                <a class="red-button" href="<?=$arItem["PROPERTIES"]["LINK"]["VALUE"]?>">
                                    <div class="red-button__inner"><?=GetMessage("INDEX_PAGE_SLIDER_MORE_BTN")?></div>
                                </a>
                            </div>
                        <?endif;?>
                    </div>
                </div>
            <?endforeach;?>
        </div>
    </div>
    <div class="index-main-slider__second animateThis" data-anim="fadeInUp">
        <div class="index-main-slider__slider second-slider" id="index-main-slider__second">
            <?foreach($arResult["ITEMS"] as $arItem):?>
                <div class="index-main-slider__slide">
                    <div class="index-main-slider__big-image" style="background-image: url('<?=$arItem["RESIZE_IMG"]["src"]?>');">
                        <img src="<?=$arItem["RESIZE_IMG"]["src"]?>" class="index-main-slider__img">
                    </div>
                </div>
            <?endforeach;?>
        </div>
    </div>
</div>