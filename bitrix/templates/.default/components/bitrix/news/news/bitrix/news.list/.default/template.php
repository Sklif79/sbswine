<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;
?>
<div class="news-page-items">
    <?foreach($arResult["ITEMS"] as $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <a class="animateThis special-item" href="<?=$arItem["DETAIL_PAGE_URL"]?>" data-anim="fadeInUp" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <?if($arResult['FLG_EVENT'] == $arItem["IBLOCK_SECTION_ID"]):?>
                <div class="special-item__label"><?=GetMessage("FLG_NEWS_PAGE_EVENT")?></div>
            <?endif;?>
            <div class="special-item__image-wrapper">
                <div class="special-item__image" style="background-image: url(<?=$arItem["RESIZE_IMG"]["src"]?>);"></div>
            </div>
            <?if($arItem["ACTIVE_FROM"]):?>
                <div class="special-item__date">
                    <?$arr = ParseDateTime($arItem["ACTIVE_FROM"]);?>
                    <?=($arr["YYYY"]==date("Y")?str_replace('.'.$arr["YYYY"],"",$arItem["DISPLAY_ACTIVE_FROM"]):$arItem["DISPLAY_ACTIVE_FROM"])?>
                </div>
            <?endif;?>
            <div class="special-item__text"><?=$arItem["~NAME"]?></div>
        </a>
    <?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>
