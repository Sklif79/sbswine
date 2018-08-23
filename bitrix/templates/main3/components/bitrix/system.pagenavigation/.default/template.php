<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if(!$arResult["NavShowAlways"])
{
    if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false))
        return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>
<div class="pagination">
    <div class="pagination__divst">
        <?if($arResult["bDescPageNumbering"] === true):
            if ($arResult["NavPageNomer"] < $arResult["NavPageCount"]):?>
                <div class="pagination__item pagination__item--left pagination__item--arrow pagination__item--disabled">
                    <?if($arResult["bSavePage"]):?>
                        <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">
                            <div class="pagination__item pagination__item--right pagination__item--arrow">
                                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                                    <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                                </svg>
                            </div>
                        </a>
                    <?else:?>
                        <?if ($arResult["NavPageCount"] == ($arResult["NavPageNomer"]+1) ):?>
                            <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
                                <div class="pagination__item pagination__item--right pagination__item--arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                                        <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                                    </svg>
                                </div>
                            </a>
                        <?else:?>
                            <a  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">
                                <div class="pagination__item pagination__item--right pagination__item--arrow">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                                        <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                                    </svg>
                                </div>
                            </a>
                        <?endif?>
                    <?endif?>
            </div>
            <?else:?>
                <?/*?>
                <div class="disabled">
                    <span class="ic-pagin-prev"></span>
                </div>
                <?//*/?>
                <div class="pagination__item pagination__item--left pagination__item--arrow pagination__item--disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                        <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                    </svg>
                </div>
            <?endif?>

            <?if ($arResult["nStartPage"] < $arResult["NavPageCount"]):?>
            <?$bFirst = false;?>
            <?if($arResult["bSavePage"]):?>
                <div><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>">1</a></div>
            <?else:?>
                <div><a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a></div>
            <?endif;

            if($arResult["nStartPage"] < ($arResult["NavPageCount"] - 1)):?>
                <div><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=intVal($arResult["nStartPage"] + ($arResult["NavPageCount"] - $arResult["nStartPage"]) / 2)?>">...</a></div>
            <?endif;?>
        <?endif;?>

            <?while($arResult["nStartPage"] >= $arResult["nEndPage"]):?>
            <div>
                <?$NavRecordGroupPrint = $arResult["NavPageCount"] - $arResult["nStartPage"] + 1;?>

                <?if ($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
                    <span><?=$NavRecordGroupPrint?></span>
                <?elseif($arResult["nStartPage"] == $arResult["NavPageCount"] && $arResult["bSavePage"] == false):?>
                    <a href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$NavRecordGroupPrint?></a>
                <?else:?>
                    <a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$NavRecordGroupPrint?></a>
                <?endif?>

                <?$arResult["nStartPage"]--?>
            </div>
        <?endwhile?>

            <?if ($arResult["NavPageNomer"] > 1):
            if ($arResult["nEndPage"] > 1):
                if ($arResult["nEndPage"] > 2):?>
                    <a class="pagination__item" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] / 2)?>">...</a>
                <?endif;?>
                <a class="pagination__item" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1"><?=$arResult["NavPageCount"]?></a>
            <?endif;?>
            <a class="pagination__item" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>"></a>
        <?else:?>
            <div class="pagination__item pagination__item--left pagination__item--arrow  pagination__item--disabled">
                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                    <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                </svg>
            </div>
        <?endif;?>

        <?else:
            if ($arResult["NavPageNomer"] > 1):?>

                    <?if($arResult["bSavePage"]):?>
                        <a class="pagination__item pagination__item--left pagination__item--arrow "  href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">
                            <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                                <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                            </svg>
                        </a>
                    <?else:?>
                        <?if ($arResult["NavPageNomer"] > 2):?>
                            <a class="pagination__item pagination__item--left pagination__item--arrow " href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]-1)?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                                    <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                                </svg>
                            </a>
                        <?else:?>
                            <a class="pagination__item pagination__item--left pagination__item--arrow " href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                                    <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                                </svg>
                            </a>
                        <?endif?>
                    <?endif?>

            <?else:?>
                <div class="pagination__item pagination__item--left pagination__item--arrow pagination__item--disabled">
                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                        <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                    </svg>
                </div>
            <?endif?>

            <?if ($arResult["nStartPage"] > 1):?>
            <?$bFirst = false;?>
            <?if($arResult["bSavePage"]):?>
                <a class="pagination__item" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a>
            <?else:?>
                <a class="pagination__item" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>">1</a>
            <?endif;

            if($arResult["nStartPage"] > 2):?>
                <div><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nStartPage"] / 2)?>">...</a></div>
            <?endif;?>
        <?endif;?>

            <?while($arResult["nStartPage"] <= $arResult["nEndPage"]):?>
            <?if($arResult["nStartPage"] == $arResult["NavPageNomer"]):?>
                <div class="pagination__item active">
				    <?=$arResult["nStartPage"]?>
                </div>
            <?elseif($arResult["nStartPage"] == 1 && $arResult["bSavePage"] == false):?>
                 <a class="pagination__item" href="<?=$arResult["sUrlPath"]?><?=$strNavQueryStringFull?>"><?=$arResult["nStartPage"]?></a>
            <?else:?>
                <a class="pagination__item" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["nStartPage"]?>"><?=$arResult["nStartPage"]?></a>
            <?endif?>
            <?$arResult["nStartPage"]++?>
        <?endwhile?>
            <?if($arResult["NavPageNomer"] < $arResult["NavPageCount"]):
                if ($arResult["nEndPage"] < $arResult["NavPageCount"]):
                    if ($arResult["nEndPage"] < ($arResult["NavPageCount"] - 1)):?>
                        <a class="pagination__item" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=round($arResult["nEndPage"] + ($arResult["NavPageCount"] - $arResult["nEndPage"]) / 2)?>">...</a>
                    <?endif;?>
                    <a class="pagination__item" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a>
                <?endif;?>
            <a class="pagination__item pagination__item--right pagination__item--arrow" href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=($arResult["NavPageNomer"]+1)?>">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8.1 13.4">
                    <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"></path>
                </svg>
            </a>
        <?else:?>
            <div class="pagination__item pagination__item--right pagination__item--arrow pagination__item--disabled">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8.1 13.4">
                    <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"></path>
                </svg>
            </div>

        <?endif;?>

        <?endif?>

</div>
</div>
