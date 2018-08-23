<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

?>
<?$this->SetViewTarget('header_block_title');?>
<h1><?=$arResult["IPROPERTY_VALUES"]["SECTION_PAGE_TITLE"]?></h1>
<?$this->EndViewTarget();?>

<div class="news-page-items">
    <?foreach($arResult["ITEMS"] as $arItem):?>
        <?
        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
        ?>
        <a class="special-item special-item--catalog" href="<?=$arItem["DETAIL_PAGE_URL"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <?if($arItem["PROPERTIES"]["FLG_ACTION"]["VALUE"]):?>
                <div class="special-item__label"><?=$arItem["PROPERTIES"]["FLG_ACTION"]["VALUE"]?></div>
            <?endif;?>
            <div class="special-item__image-wrapper">
                <div class="special-item__image" style="background-image: url(<?=$arItem["RESIZE_IMG"]["src"]?>);"></div>
            </div>
            <div class="special-item__title"><?=$arItem["~NAME"]?></div>
                <?if($arParams["SECTION_PROPERTY_CHAR"]):?>
                    <ul>
                    <?$i=0;foreach ($arItem['PROPERTIES'] as $arProp):
                        if(array_search($arProp["CODE"], $arParams["SECTION_PROPERTY_CHAR"])!==false && $arProp["VALUE"]):?>
                            <li><span><?=$arProp["~VALUE"]?></span></li>
                        <?
                        $i=$i+1;
                        endif;?>

                    <?
                    if($i==3){
                        break;
                    }
                    endforeach;?>
                    </ul>
                <?endif;?>
            <?if($arItem["PROPERTIES"]["PRICE"]["VALUE"]):?>
                <div class="special-item__price"><?=$arItem["PROPERTIES"]["PRICE"]["VALUE"]?></div>
            <?endif;?>
        </a>
    <?endforeach;?>
</div>
<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
	<?=$arResult["NAV_STRING"]?>
<?endif;?>

