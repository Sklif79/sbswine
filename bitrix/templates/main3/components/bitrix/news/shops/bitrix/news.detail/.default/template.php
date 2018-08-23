<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);

?>
<div class="shop-header">
    <?if($arResult["RESIZE_IMG"]):?>
    <div class="shop-header__image">
        <div class="shop-header__big_image" style="background-image:url('<?=$arResult["RESIZE_IMG"]["src"]?>');"></div>
    </div>
    <?endif;?>
    <div class="person">
        <div class="person__wrapper">
            <div class="person__info">
                <div class="person__sup-text"><?=GetMessage("SHOP_PAGE_ADDRESS")?></div>
                <h2><?=$arResult["~NAME"]?></h2>
                <?if($arResult["PROPERTIES"]["LAN_LAT"]["VALUE"]):?>
                    <p class="underline underline--dotted underline--animation" data-href="#map"><?=GetMessage("SHOPS_PAGE_MORE_LINK_MAP")?></p>
                <?endif;?>
                <div class="person__contact-block">
                    <?if($arResult["PROPERTIES"]["PHONE"]["~VALUE"][0]):?>
                        <div class="person__contact-block-inner">
                            <div class="person__sup-text"><?=GetMessage("SHOP_PAGE_TITLE_PHONE")?></div>
                            <?foreach($arResult["PROPERTIES"]["PHONE"]["~VALUE"] as $arPhone):?>
                                <div class="person__age"><?=$arPhone?></div>
                            <?endforeach;?>
                        </div>
                    <?endif;?>
                    <?if($arResult["PROPERTIES"]["WORK"]["~VALUE"][0]):?>
                        <div class="person__contact-block-inner">
                            <div class="person__sup-text"><?=GetMessage("SHOP_PAGE_TITLE_WORK")?></div>
                            <?foreach($arResult["PROPERTIES"]["WORK"]["~VALUE"] as $arWork):?>
                            <div class="person__text"><?=$arWork?></div>
                            <?endforeach;?>

                        </div>
                    <?endif;?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="advanced-page__small-single">
    <a href="<?=$arParams["SEF_FOLDER"]?>">
        <div class="back-button">
            <div class="back-button__wrapper">
                <div class="back-button__image">
                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                        <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                    </svg>
                </div>
                <div class="back-button__text"><?=GetMessage("SHOP_PAGE_ALL_SHOP_BTN")?></div>
            </div>
        </div>
    </a>
    <div class="advanced-page__content advanced-page__content--single">
        <div class="news-page-inner-item">
            <?if(($arResult["PROPERTIES"]["LIST_DESC"]["~VALUE"][0])):
                if(count($arResult["PROPERTIES"]["LIST_DESC"]["~VALUE"])>2){
                    $more=true;
                }
            ?>
                <div class="h3 upper"><?=GetMessage("SHOP_PAGE_SHOW_MAP")?></div>
                <div class="advanced-list">
                    <div class="<?=($more?"advanced-list__list":"")?>">
                        <ul>
                            <?foreach($arResult["PROPERTIES"]["LIST_DESC"]["~VALUE"] as $arDesc):?>
                            <li>
                                <span><?=$arDesc?></span>
                            </li>
                            <?endforeach;?>
                        </ul>
                    </div>
                    <?if($more):?>
                        <div class="underline underline--dotted advanced-list-trigger" data-text-hide="<?=GetMessage("SHOP_PAGE_BTN_MORE_DESC_CUT_HIDE")?>" data-show-name="<?=GetMessage("SHOP_PAGE_BTN_MORE_DESC_CUT")?>">
                            <?=GetMessage("SHOP_PAGE_BTN_MORE_DESC")?>
                        </div>
                    <?endif;?>
                </div>
            <?endif;?>
            <?= $arResult["~PREVIEW_TEXT"] ?>
            <?if($arResult['IMAGES']):?>
            <div class="advanced-slider long-slider" data-slick="{&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1, &quot;dots&quot;: true, &quot;arrows&quot;: true}">
                <?foreach($arResult['IMAGES'] as $arImg):?>
                    <div class="advanced-slider__slide slide-image">
                        <div class="advanced-slider__image" style="background-image: url('<?=$arImg["src"]?>');"></div>
                    </div>
                <?endforeach;?>
            </div>
            <?endif;?>
            <?= $arResult["~DETAIL_TEXT"] ?>
            <?if($arResult["PROPERTIES"]["LAN_LAT"]["VALUE"]):
                $lanLat = explode(",",$arResult["PROPERTIES"]["LAN_LAT"]["VALUE"]);
            ?>
            <div class="advanced-map">
                <h3 class="advanced-map__title upper"><?=GetMessage("SHOP_PAGE_SHOW_MAP_TITLE")?></h3>
                <div class="advanced-map__wrapper">
                    <script>
                        var arrayOfPins = [
                            {
                                'lat': <?=$lanLat[0]?>,
                                'lng': <?=$lanLat[1]?>,
                                'name': '<?=$arResult["NAME"]?>',
                                'tell': '<?foreach($arResult["PROPERTIES"]["PHONE"]["VALUE"] as $arPhone):?><?=$arPhone?><br><?endforeach?>',
                                'dates': '<?foreach($arResult["PROPERTIES"]["WORK"]["VALUE"] as $arWork):?><?=$arWork?><br><?endforeach?>'
                            }]
                    </script>
                    <div class="advanced-map__map map map-elem-near" data-id="#map" data-lat="<?=$lanLat[0]?>" data-lon="<?=$lanLat[1]?>" data-icon="/bitrix/templates/main/img/index/point.svg" data-zoom="12"></div>
                </div>
            </div>
            <?endif;?>
        </div>
    </div>
</div>
