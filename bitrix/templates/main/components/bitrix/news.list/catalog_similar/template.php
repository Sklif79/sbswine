<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;
?>
<div class="article">
    <div class="section">
        <div class="index-gray-block index-gray-block--advanced">
            <div class="index-gray-block__wrapper">
                <div class="index-gray-block__left-side index-gray-block__left-side--advanced">
                    <div class="index-gray-block__title h3 upper animateThis" data-anim="fadeInUp"><?=GetMessage("CATALOG_SIMILAR_TITLE")?></div>
                    <div class="index-gray-block__slider long-slider animateThis" data-anim="fadeInUp" data-slick="{&quot;slidesToShow&quot;: 4, &quot;slidesToScroll&quot;: 4, &quot;responsive&quot;: [{&quot;breakpoint&quot;: 992, &quot;settings&quot;: {&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1}}]}">
                    <?foreach($arResult["ITEMS"] as $arItem):
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                        ?>
                        <div class="index-gray-block__slide" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                            <a class="special-item" href="<?=$arItem["DETAIL_PAGE_URL"]?>" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                                <?if($arItem["PROPERTIES"]["FLG_ACTION"]["VALUE"]):?>
                                    <div class="special-item__label"><?=$arItem["PROPERTIES"]["FLG_ACTION"]["VALUE"]?></div>
                                <?endif;?>
                                <div class="special-item__image-wrapper">
                                    <div class="special-item__image" style="background-image: url(<?=$arItem["RESIZE_IMG"]["src"]?>);"></div>
                                </div>
                                <div class="special-item__title"><?=$arItem["~NAME"]?></div>
                                <?//=$arItem["~PREVIEW_TEXT"]?>
                                <?if(count($arParams["SECTION_PROPERTY_CHAR"])>0):?>
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
                        </div>
                    <?endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

