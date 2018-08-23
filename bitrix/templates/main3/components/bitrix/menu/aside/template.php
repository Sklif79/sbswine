<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if (count($arResult) < 1)
return;
//pr($arResult);
?>

<div class="advanced-page__aside">
    <?


    foreach($arResult as  $arItem):
            if ($arItem["PARAMS"]["FILTER"]):?>
                <div class="advanced-page__href-wrap animateThis" data-anim="fadeInUp">
                    <div class="dropdown-menu">
                        <div class="dropdown-menu__wrapper">
                            <div class="dropdown-menu__main">
                                <a  href="<?=$arItem["LINK"]?>" class="dropdown-menu__item dropdown-menu__item--main">
                                    <?=$arItem["TEXT"]?>
                                </a>
                                <div class="dropdown-menu__image">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                                        <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="dropdown-menu__items-wrapper">
                                <div class="dropdown-menu__inner-items-wrapper">
                                    <?foreach($arItem["PARAMS"]["FILTER"] as  $arFilter):
                                        $dopUrl = "?set_filter=y&".htmlspecialcharsbx("arrFilter_".$arItem["PARAMS"]["ID_FILTER"]."_".abs(crc32($arFilter["ID"])))."=Y";
                                        ?>
                                        <div class="dropdown-menu__inner-items-wrapper-inner ">
                                            <a class="dropdown-menu__item" href="<?=$arItem["LINK"].$dopUrl?>"><?=$arFilter["NAME"]?>
                                                <div class="dropdown-menu__item-count"><?=count($arFilter["ITEMS"])?></div>
                                            </a>
                                        </div>
                                    <?endforeach;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?else:?>
                <div class="advanced-page__href-wrap animateThis" data-anim="fadeInUp">
                    <a class="t1<?=($arItem["SELECTED"]?" active":"")?>" href="<?=$arItem["LINK"]?>">
                        <?=$arItem["TEXT"]?>
                    </a>
                </div>
            <?endif;
        endforeach;?>

</div>
