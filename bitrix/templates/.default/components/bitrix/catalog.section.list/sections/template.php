<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if (count($arResult["SECTIONS"]) <= 0)
    return;
//print_r($arResult["SECTIONS"]);
?>
    <div class="index-services__wrapper">
    <div class="index-services__cards-block index-services__cards-block--advanced">
        <div class="index-services__cards index-services__cards--advanced slider-adapt" data-adapt="9900" data-slick="{&quot;slidesToShow&quot;:3, &quot;slidesToScroll&quot;:3, &quot;dots&quot;: false, &quot;arrows&quot;: false, &quot;responsive&quot;: [{&quot;breakpoint&quot;: 992, &quot;settings&quot;: {&quot;slidesToShow&quot;: 2, &quot;slidesToScroll&quot;: 2, &quot;arrows&quot;: true}},{&quot;breakpoint&quot;: 768, &quot;settings&quot;: {&quot;slidesToShow&quot;: 2, &quot;slidesToScroll&quot;: 2, &quot;arrows&quot;: true}},{&quot;breakpoint&quot;:600, &quot;settings&quot;: {&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1, &quot;arrows&quot;: true}}]}">

        <?foreach($arResult["SECTIONS"] as $arSection):
                $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
                $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="card animateThis" data-anim="fadeInUp" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
                    <a class="card__href card__href--advanced" href="<?=$arSection['SECTION_PAGE_URL']?>"></a>
                    <div class="card__image" style="background-image: url(<?=$arSection["RESIZE_IMG"]["src"]?>);"></div>
                    <div class="card__visible">
                        <div class="card__title"><?=$arSection['~NAME']?></div>
                    </div>
                </div>
            <?endforeach;?>
        </div>
        </div>
    </div>
<?/*/?><pre><?print_r($arResult);?></pre><?//*/?>