<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if($arResult["DESC"]){
    $tab = true;
}
?>
<?$this->SetViewTarget('aside_block_menu');?>
    <div class="advanced-page__content advanced-page__content--single">
        <div class="shop-header">
            <?if($arResult["RESIZE_IMG"]):?>
                <div class="shop-header__image">
                    <div class="shop-header__big_image" style="background-image:url('<?=$arResult["RESIZE_IMG"]["src"]?>');"></div>
                </div>
            <?endif;?>
            <div class="shop-header__info">
                <?if($tab):?>
                    <div class="h2"><?=GetMessage("CONSULTANTS_PAGE_TITLE_DESC")?></div>
                    <ul>
                        <?foreach($arResult["DESC"] as $num => $arDesc):?>
                            <li>
                                <span>
                                    <div class="underline underline--animation underline--dotted" data-href="#<?=$num?>">
                                        <?=$arDesc["NAME"]?>
                                    </div>
                                </span>
                            </li>
                        <?endforeach;?>
                    </ul>
                <?endif;?>
                <div class="red-button--wrapper">
                    <a class="red-button red-button--small" href="#service-modal">
                        <div class="red-button__inner"><?=GetMessage("BTN_NAME_ORDER")?></div>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?$this->EndViewTarget();?>
<?if($arResult["~DETAIL_TEXT"]):?>
    <div class="t1 t1--gray">
        <?=$arResult["~DETAIL_TEXT"]?>
    </div>
<?endif;?>
<?if($tab):?>
    <?foreach($arResult["DESC"] as $num => $arDesc):?>
    <div class="news-page-inner-item__block" data-id="#<?=$num?>">
        <div class="h3 upper"><?=$arDesc["NAME"]?></div>
        <div class="t1 t1--gray"><?=$arDesc["PREVIEW_TEXT"]?></div>
        <?if($arDesc["SLIDER"]):?>
        <div class="advanced-slider long-slider" data-slick="{&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1, &quot;dots&quot;: true, &quot;arrows&quot;: true}">
            <?foreach($arDesc["SLIDER"] as $num => $arSlide):?>
                <div class="advanced-slider__slide slide-image">
                    <div class="advanced-slider__image" style="background-image: url('<?=$arSlide["src"]?>');"></div>
                </div>
            <?endforeach;?>
        </div>
        <?endif;?>
    </div>
    <?endforeach;?>
<?endif;?>




