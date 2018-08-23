<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;
?>
<div class="advanced-map">
    <div class="advanced-map__title h3 upper"><?=GetMessage("CATALOG_SHOPS_TITLE")?></div>
    <div class="advanced-map__wrapper">
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
        <div class="advanced-map__map map map-elem-near" data-zoom="12" data-id="#map" data-lat="<?=$lanLat["0"]?>" data-lon="<?=$lanLat["1"]?>" data-icon="<?=SITE_TEMPLATE_PATH?>/img/index/point.svg"></div>
    </div>
</div>