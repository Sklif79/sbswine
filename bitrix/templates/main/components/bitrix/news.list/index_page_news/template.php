<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;
?>
<div class="index-gray-block__left-side">
    <div class="index-gray-block__title h3 upper animateThis" data-anim="fadeInUp"><?=GetMessage("INDEX_PAGE_NEWS_TITLE")?></div>
    <div class="index-gray-block__slider long-slider animateThis" data-anim="fadeInUp" data-slick="{&quot;responsive&quot;: [{&quot;breakpoint&quot;: 1160, &quot;settings&quot;: {&quot;slidesToShow&quot;: 2, &quot;slidesToScroll&quot;: 2}},{&quot;breakpoint&quot;: 840, &quot;settings&quot;: {&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1}}]}">
        <?foreach($arResult["ITEMS"] as $arItem):
            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
            <div class="index-gray-block__slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                <a class="special-item" href="<?=$arItem['DETAIL_PAGE_URL']?>">
                    <?if($arResult['FLG_EVENT'] == $arItem["IBLOCK_SECTION_ID"]):?>
                        <div class="special-item__label"><?=GetMessage("FLG_NEWS_PAGE_EVENT")?></div>
                    <?endif;?>
                    <div class="special-item__image-wrapper">
                        <div class="special-item__image" style="background-image: url(<?=$arItem['RESIZE_IMG']["src"]?>"></div>
                    </div>
                    <?if($arItem["ACTIVE_FROM"]):?>
                        <div class="special-item__date">
                            <?$arr = ParseDateTime($arItem["ACTIVE_FROM"]);?>
                            <?=($arr["YYYY"]==date("Y")?str_replace('.'.$arr["YYYY"],"",$arItem["DISPLAY_ACTIVE_FROM"]):$arItem["DISPLAY_ACTIVE_FROM"])?>
                        </div>
                    <?endif;?>
                    <div class="special-item__text"><?=$arItem['~NAME']?></div>
                </a>
            </div>
        <?endforeach;?>
    </div>
</div>