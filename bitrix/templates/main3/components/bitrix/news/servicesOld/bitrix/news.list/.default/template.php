<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;
?>

    <div class="index-services index-services--advanced">
        <div class="index-services__wrapper">
            <div class="index-services__cards-block index-services__cards-block--advanced">
                <div class="index-services__cards index-services__cards--advanced slider-adapt" data-adapt="9900" data-slick="{&quot;slidesToShow&quot;:3, &quot;slidesToScroll&quot;:3, &quot;dots&quot;: false, &quot;arrows&quot;: false, &quot;responsive&quot;: [{&quot;breakpoint&quot;: 992, &quot;settings&quot;: {&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1, &quot;arrows&quot;: true}}]}">
                <?foreach($arResult["ITEMS"] as $arItem):
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                        ?>
                        <div class="card animateThis" data-anim="fadeInUp" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                            <a class="card__href card__href--advanced" href="<?=$arItem["DETAIL_PAGE_URL"]?>"></a>
                            <div class="card__image" style="background-image: url(<?=$arItem["RESIZE_IMG"]["src"]?>);"></div>
                            <div class="card__visible">
                                <div class="card__title"><?=$arItem["~NAME"]?></div>
                            </div>
                        </div>
                    <?endforeach;?>
                </div>
            </div>
    </div>
</div>

<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
    <?=$arResult["NAV_STRING"]?>
<?endif;?>
