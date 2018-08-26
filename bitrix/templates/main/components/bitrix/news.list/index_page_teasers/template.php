<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;
?>
<div class="article">
    <div class="section">
        <div class="index-numbers">
            <div class="index-numbers__wrapper">
                <div class="index-numbers__text-block slider-adapt" data-adapt="9900" data-slick="{&quot;slidesToShow&quot;:3, &quot;slidesToScroll&quot;:3, &quot;dots&quot;: false, &quot;arrows&quot;: false, &quot;responsive&quot;: [{&quot;breakpoint&quot;: 640, &quot;settings&quot;: {&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1, &quot;dots&quot;: true}}]}">
                        <?foreach($arResult["ITEMS"] as $arItem):
                            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                        ?>
                        <div class="index-numbers__count-item animateThis" data-anim="fadeInUp" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                            <div class="index-numbers__count-inner">
                                <div class="count"><?=$arItem["~NAME"]?></div>
                                <div class="t2"><?=$arItem["~PREVIEW_TEXT"]?></div>
                            </div>
                        </div>
                    <?endforeach;?>
                </div>
            </div>
        </div>
    </div>
</div>

