<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;

//pr($arResult["ITEMS"]);
?>
<div class="brands news-page-items brands-page">
    <?foreach($arResult["ITEMS"] as $arItem):
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <a class="animateThis brands-block__slide" href="<?=$arItem["DETAIL_PAGE_URL"]?>" data-anim="fadeInUp" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="brands-block__image">
                <img src="<?=$arItem["RESIZE_IMG"]["src"]?>" alt="<?=$arItem["~NAME"]?>">
            </div>

            <p class="t1"><?=$arItem["~NAME"]?></p>
        </a>
    <?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>
