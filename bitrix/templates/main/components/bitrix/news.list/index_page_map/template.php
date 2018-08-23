<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;
?>

<div class="article">
    <div class="section">
    <div class="index-map">
    <div class="index-map__title h3 upper"><?=GetMessage("INDEX_PAGE_MAP_TITLE")?></div>
        <div class="index-map__wrapper">
            <script>
                    var arrayOfPins = [
                        <?foreach($arResult["ITEMS"] as $arItem):
                            $lanLat = explode(",",$arItem["PROPERTIES"]["LAN_LAT"]["VALUE"]);
                        ?>
                            {
                                'lat': <?=$lanLat["0"]?>,
                                'lng': <?=$lanLat["1"]?>,
                                'name': '<?=$arItem["NAME"]?>',
                                'tell': '<?foreach($arItem["PROPERTIES"]["PHONE"]["VALUE"] as $arPhone):?><?=$arPhone?><br><?endforeach?>',
                                'dates': '<?foreach($arItem["PROPERTIES"]["WORK"]["VALUE"] as $arPhone):?><?=$arPhone?><br><?endforeach?>'
                            },
                        <?endforeach;?>
                    ]
                </script>
            <div class="index-map__map map map-elem-near" data-id="#map" data-lat="53.9" data-lon="27.55" data-icon="/bitrix/templates/main/img/index/point.svg" data-zoom="11"></div>
        </div>
    </div>
    </div>
</div>