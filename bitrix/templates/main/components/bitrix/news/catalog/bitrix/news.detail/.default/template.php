<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

?>

<?$this->SetViewTarget('header_block_title');?>
    <div class="h1"><?=$arResult["SECTION_NAME"]?></div>
<?$this->EndViewTarget();?>

<?//$this->SetViewTarget('aside_block_menu');?>

    <div class="catalog-page-inner-header">
        <?if($arResult['IMAGES']):?>
        <div class="catalog-page-inner-header__gallery">
            <div class="catalog-inner-slider double-slider">
                <div class="catalog-inner-slider__first animateThis" data-anim="fadeInUp">
                    <div class="catalog-inner-slider__slider first-slider" id="catalog-inner-main-slider__first" data-slick="{&quot;dots&quot;:false}">
                        <?foreach($arResult['IMAGES'] as $arImg):?>
                        <div class="catalog-inner-slider__slide catalog-inner-slider__slide--big">
                            <div class="catalog-inner-slider__image catalog-inner-slider__image--big" style="background-image: url('<?=$arImg["IMG"]["src"]?>');"></div>
                        </div>
                        <?endforeach;?>
                    </div>
                </div>
                <?if(count($arResult['IMAGES'])>1):?>
                    <div class="catalog-inner-slider__second animateThis" data-anim="fadeInUp">
                        <div class="catalog-inner-slider__slider second-slider" id="catalog-inner-main-slider__second" data-slick="{&quot;slidesToShow&quot;: 5, &quot;slidesToScroll&quot;: 1, &quot;focusOnSelect&quot;: true, &quot;centerMode&quot;: true}">
                            <?foreach($arResult['IMAGES'] as $arImg):?>
                            <div class="catalog-inner-slider__slide">
                                <div class="catalog-inner-slider__image" style="background-image: url('<?=$arImg["SMALL_IMG"]["src"]?>');"></div>
                            </div>
                            <?endforeach;?>
                        </div>
                    </div>
                <?endif;?>
            </div>
        </div>
        <?endif;?>
        <div class="catalog-page-inner-header__info">
            <div class="catalog-page-inner-header__title animateThis" data-anim="fadeInUp">
                <div class="catalog-page-inner-header__title-inner">
                    <h1 class="h2"><?=$arResult["~NAME"]?></h1>
                    <?if($arResult["PROPERTIES"]["FLG_ACTION"]["VALUE"]):?>
                        <div class="label"><?=$arResult["PROPERTIES"]["FLG_ACTION"]["VALUE"]?></div>
                    <?endif;?>
                </div>
                <div class="catalog-page-inner-header__price">
                    <?if($arResult["PROPERTIES"]["PRICE"]["VALUE"]):?>
                    <div class="price"><?=$arResult["PROPERTIES"]["PRICE"]["VALUE"]?></div>
                    <?endif;?>
                    <?if($arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"]):?>
                        <div class="price-special"><?=$arResult["PROPERTIES"]["OLD_PRICE"]["VALUE"]?></div>
                    <?endif;?>
                </div>
            </div>
            <?if($arResult["MAIN_PROPERTIES"]):?>
            <div class="table table--construction animateThis" data-anim="fadeInUp">
                <div class="table__title">
                    <div class="t1 t1--light"><?=GetMessage("CATALOG_MAIN_CHAR")?></div>
                </div>
                <div class="table__body">
                    <? foreach($arResult["MAIN_PROPERTIES"] as $arProp):?>
                        <?if($arProp["VALUE"]):?>
                            <div class="table__row">
                                <div class="table__cell">
                                    <div class="t2"><?=$arProp["NAME"]?></div>
                                </div>
                                <div class="table__cell">
                                    <?if($arProp["VALUE_XML_ID"] == "Y"):?>
                                        <div class="check check--yes"></div>
                                    <?elseif($arProp["VALUE_XML_ID"] == "N"):?>
                                        <div class="check check--no">—</div>
                                    <?else:?>
                                        <div class="t1 t1--light">
											<?=($arProp["VALUE_ENUM"]?$arProp["VALUE_ENUM"]:$arProp["VALUE"])?>
                                        </div>
                                    <?endif;?>
                                </div>
                            </div>
                        <?endif;?>
                    <?endforeach;?>
                </div>
            </div>
            <?endif;?>
            <div class="catalog-page-inner-header__buttons animateThis" data-anim="fadeInUp">
                <div class="red-button--wrapper">
                    <a class="red-button" href="#catalog-modal-form">
                        <div class="red-button__inner"><?=GetMessage("CATALOG_BTN_ORDER")?></div>
                    </a>
                </div>
                <?if(count($arResult["PROPERTIES"]["SHOPS"]["VALUE"])>0 && $arResult["PROPERTIES"]["SHOPS"]["VALUE"][0]):?>
                    <p class="underline underline--dotted underline--animation underline--red" data-href="#map"><?=GetMessage("CATALOG_BTN_SHOPS")?></p>
                <?endif;?>
            </div>
        </div>
    </div>

<?

//$this->EndViewTarget();
//*/


