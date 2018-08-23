<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;
?>
<div class="line"></div>
<div class="advanced-page__single">
    <div class="advanced-page__content advanced-page__content--single">
        <div class="workers-slider">
            <h3 class="upper"><?=GetMessage("SHOP_PAGE_TITLE_PERSON")?></h3>
            <div class="workers-slider__wrapper">
                <div class="workers-slider__info">
                    <p><?=GetMessage("SHOP_PAGE_TEXT_PERSON")?></p>
                </div>
                <div class="workers-slider__slider long-slider" data-slick="{&quot;slidesToShow&quot;:4, &quot;slidesToScroll&quot;:4, &quot;dots&quot;: false, &quot;arrows&quot;: true, &quot;responsive&quot;: [{&quot;breakpoint&quot;: 800, &quot;settings&quot;: {&quot;slidesToShow&quot;: 3, &quot;slidesToScroll&quot;: 3, &quot;arrows&quot;: true}},{&quot;breakpoint&quot;: 600, &quot;settings&quot;: {&quot;slidesToShow&quot;: 2, &quot;slidesToScroll&quot;: 2, &quot;arrows&quot;: true}},{&quot;breakpoint&quot;: 400, &quot;settings&quot;: {&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1, &quot;arrows&quot;: true}}]}">
                <?foreach($arResult["ITEMS"] as $arItem):
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div class="slide-person" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                        <div class="slide-person__wrapper">
                            <?if($arItem["RESIZE_IMG"]):?>
                                <div class="slide-person__wrapper-image">
                                    <div class="slide-person__image" style="background-image: url(<?=$arItem["RESIZE_IMG"]["src"]?>);"></div>
                                </div>
                            <?endif;?>
                            <div class="t2"><?=$arItem["PROPERTIES"]["POST"]["~VALUE"]?></div>
                            <div class="h3"><?=$arItem["~NAME"]?></div>
                        </div>
                    </div>
                <?endforeach;?>
            </div>
        </div>
    </div>
</div>