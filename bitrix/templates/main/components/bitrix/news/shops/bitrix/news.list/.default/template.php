<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;
?>
<div class="shops-page-items">
    <div class="cards-slider">
        <div class="cards-slider__wrapper long-slider" data-slick="{&quot;slidesToShow&quot;:4, &quot;slidesToScroll&quot;:4, &quot;responsive&quot;: [{&quot;breakpoint&quot;: 1024, &quot;settings&quot;: {&quot;slidesToShow&quot;: 3, &quot;slidesToScroll&quot;: 3, &quot;arrows&quot;: true}},{&quot;breakpoint&quot;: 830, &quot;settings&quot;: {&quot;slidesToShow&quot;: 2, &quot;slidesToScroll&quot;: 2, &quot;arrows&quot;: true}},{&quot;breakpoint&quot;: 600, &quot;settings&quot;: {&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1, &quot;arrows&quot;: true}}]}">
            <?if($arResult["ITEMS"][0]["LAN_LAT"]):?>
                <?$i=0;?>
            <?endif;?>
            <?foreach($arResult["ITEMS"] as $arItem):
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="slide-wrapper" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
                    <div class="card card--adress"><a class="card__href" href="<?=$arItem["DETAIL_PAGE_URL"]?>"></a>
                        <div class="card__image" style="background-image: url(<?=$arItem["RESIZE_IMG"]["src"]?>);"></div>
                        <div class="card__visible">
                            <div class="h3"><?=$arItem["~NAME"]?></div>
                            <div class="card__hidden">
                                <div class="card__hidden-block">
                                    <?if($arItem["PROPERTIES"]["PHONE"]["~VALUE"][0]):?>
                                        <?foreach($arItem["PROPERTIES"]["PHONE"]["~VALUE"] as $arPhone):?>
                                            <div class="card__tel"><?=$arPhone?></div>
                                        <?endforeach;?>
                                    <?endif;?>
                                    <?if($arItem["PROPERTIES"]["PHONE"]["~VALUE"][0]):?>
                                        <?foreach($arItem["PROPERTIES"]["WORK"]["~VALUE"] as $arWork):?>
                                            <div class="card__time"><?=$arWork?></div>
                                        <?endforeach;?>
                                    <?endif;?>
                                </div>
                                <div class="card__hidden-block">
                                    <a class="red-button red-button--fill-white red-button--small" href="<?=$arItem["DETAIL_PAGE_URL"]?>">
                                        <div class="red-button__inner"><?=GetMessage("SHOPS_PAGE_MORE_LINK")?></div>
                                    </a>
                                    <?if($arItem['LAN_LAT']):?>
                                        <p class="underline underline--dotted hrefToMap" data-lat="<?=$arItem['LAN_LAT']["0"]?>" data-lng="<?=$arItem['LAN_LAT']["1"]?>" data-marker="<?=$i?>">
                                            <?=GetMessage("SHOPS_PAGE_MORE_LINK_MAP")?>
                                        </p>
                                    <?endif;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?if($arItem["LAN_LAT"]):?>
                    <?$i=$i+1;?>
                <?endif;?>
            <?endforeach;?>
        </div>
    </div>
    <div class="advanced-map">
        <div class="advanced-map__wrapper">
            <script>
                var arrayOfPins = [
                    <?foreach($arResult["ITEMS"] as $arItem):?>
                    <?if($arItem['LAN_LAT']):?>
                        {
                            'lat': <?=$arItem['LAN_LAT']["0"]?>,
                            'lng': <?=$arItem['LAN_LAT']["1"]?>,
                            'name': '<?=$arItem["NAME"]?>',
                            'tell': '<?foreach($arItem["PROPERTIES"]["PHONE"]["VALUE"] as $arPhone):?><?=$arPhone?><br><?endforeach?>',
                            'dates': '<?foreach($arItem["PROPERTIES"]["WORK"]["VALUE"] as $arWork):?><?=$arWork?><br><?endforeach?>'
                        },
                    <?endif;?>
                    <?endforeach;?>
                ]
            </script>
            <div class="advanced-map__map map map-elem-near" data-id="#map" data-lat="53.9" data-lon="27.55" data-icon="/bitrix/templates/main/img/index/point.svg" data-zoom="10"></div>
        </div>
    </div>
</div>