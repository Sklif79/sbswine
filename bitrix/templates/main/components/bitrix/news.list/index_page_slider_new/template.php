<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;
?>
<div class="index-guests-section__slider-block">
    <div class="index-guest-slider double-slider">
        <div class="index-guest-slider__first animateThis" data-anim="fadeInUp">
            <div class="index-guest-slider__slider first-slider" id="index-guest-slider__first" data-slick="{&quot;dots&quot;: false}">
                <?foreach($arResult["ITEMS"] as $arItem):
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div class="index-guest-slider__slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="index-guest-slider__big-image" style="background-image: url('<?=$arItem["RESIZE_IMG"]["src"]?>');"></div>
                    </div>
                <?endforeach;?>
            </div>
        </div>
        <div class="index-guest-slider__second animateThis" data-anim="fadeInUp">
            <div class="index-guest-slider__slider red-slider second-slider" id="index-guest-slider__second" data-slick="{&quot;arrows&quot;: true, &quot;adaptiveHeight&quot;: true}">

                <?foreach($arResult["ITEMS"] as $arItem):?>
                    <div style="display: none;" class="index-guest-slider__slide index-guest-slider__slide--red">
                        <div class="index-guest-slider__slide-inner">
                            <div class="h3 upper"><?//=$arItem["~NAME"]?></div>
                        </div>
                    </div>
                <?endforeach;?>
            </div>
        </div>
    </div>
</div>
<style>
    #index-guest-slider__second .slick-list{display: none !important;}
</style>