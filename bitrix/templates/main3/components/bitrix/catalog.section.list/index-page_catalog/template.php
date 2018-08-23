<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
?>
<div class="article">
    <div class="section">
        <div class="index-services index-services--catalog">
            <div class="index-services__wrapper">
                <div class="index-services__cards-block index-services__cards-block--left-side small-block">
                    <div class="index-services__title h1 animateThis" data-anim="fadeInUp"><?=GetMessage("INDEX_PAGE_CATALOG_TITLE")?></div>
                    <div class="index-services__cards index-services__cards--left-side slider-adapt" data-adapt="9900" data-slick="{&quot;slidesToShow&quot;:3, &quot;slidesToScroll&quot;:3, &quot;dots&quot;: false, &quot;arrows&quot;: false, &quot;responsive&quot;: [{&quot;breakpoint&quot;: 992, &quot;settings&quot;: {&quot;slidesToShow&quot;: 2, &quot;slidesToScroll&quot;: 2, &quot;arrows&quot;: true}},{&quot;breakpoint&quot;: 600, &quot;settings&quot;: {&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1, &quot;arrows&quot;: true}}]}">
                        <?foreach ($arResult['SECTIONS'] as $arSection):
                            $this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], $strSectionEdit);
                            $this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], $strSectionDelete, $arSectionDeleteParams);
                        ?>
                        <div id="<?=$this->GetEditAreaId($arSection['ID']); ?>" class="card card--catalog animateThis" data-anim="fadeInUp"><a class="card__href" href="<?=$arSection["SECTION_PAGE_URL"]?>"></a>
                            <div class="card__image" style="background-image: url(<?=$arSection["RESIZE_IMG"]["src"]?>);"></div>
                            <div class="card__visible">
                                <div class="card__title"><?=$arSection["~NAME"]?></div>
                            </div>
                        </div>
                        <?endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
