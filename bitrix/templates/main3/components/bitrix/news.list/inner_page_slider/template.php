<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
return;
?>
<div class="news-page-inner-item__block animateThis" data-anim="fadeInUp">
    <div class="advanced-slider long-slider" data-slick="{&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1, &quot;dots&quot;: true, &quot;arrows&quot;: true}">

<?foreach($arResult["ITEMS"] as $arItem):
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
<div class="advanced-slider__slide slide-image" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
            <div class="advanced-slider__image" style="background-image: url('<?=$arItem["RESIZE_IMG"]["src"]?>');"></div>
        </div>
<?endforeach;?>

    </div>
</div>