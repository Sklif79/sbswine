<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;
?>


<?foreach($arResult["ITEMS"] as $arItem):
    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
    ?>
    <div class="person animateThis" data-anim="fadeInUp" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
        <div class="person__wrapper">
            <?if($arItem["RESIZE_IMG"]):?>
            <div class="person__image">
                <div class="person__image-block" style="background-image:url(<?=$arItem["RESIZE_IMG"]["src"]?>);"></div>
            </div>
            <?endif;?>
            <div class="person__info">
                <div class="person__info-block person__name-block">
                    <?if($arItem["PROPERTIES"]["POST"]["~VALUE"]):?>
                        <div class="person__sup-text"><?=$arItem["PROPERTIES"]["POST"]["~VALUE"]?></div>
                    <?endif;?>
                    <div class="person__name"><?=$arItem["~NAME"]?></div>
                </div>
                <div class="person__info-inner">
                    <?if($arItem["PROPERTIES"]["WORK"]["~VALUE"]):?>
                        <div class="person__info-block">
                            <div class="person__sup-text"><?=GetMessage("CONSULTANTS_PAGE_PROP_WORK")?></div>
                            <div class="person__age"><?=$arItem["PROPERTIES"]["WORK"]["~VALUE"]?></div>
                        </div>
                    <?endif;?>
                    <?if($arItem["PROPERTIES"]["PHONE"]["~VALUE"]):?>
                        <div class="person__info-block">
                            <div class="person__sup-text"><?=GetMessage("CONSULTANTS_PAGE_PROP_PHONE")?></div>
                            <div class="person__age"><?=$arItem["PROPERTIES"]["PHONE"]["~VALUE"]?></div>
                        </div>
                    <?endif;?>
                    <?if($arItem["PROPERTIES"]["SERT"]["~VALUE"][0]):?>
                        <div class="person__info-block">
                            <div class="person__sup-text"><?=GetMessage("CONSULTANTS_PAGE_PROP_SERT")?></div>
                            <?foreach($arItem["PROPERTIES"]["SERT"]["~VALUE"] as $q => $arEl):?>
                                <?if(1 /*$arItem["PROPERTIES"]["SERT"]["DESCRIPTION"][$q]*/):?>
                                    <a class="underline" href="<?=$arItem["PROPERTIES"]["SERT"]["DESCRIPTION"][$q]?>">
                                        <?=$arEl?>
                                    </a>
                                <?else:?>
                                    <span class="underline">
                                        <?=$arEl?>
                                    </span>
                                <?endif;?>
                            <?endforeach;?>

                        </div>
                    <?endif;?>
                    <?if($arItem["PROPERTIES"]["MAIL"]["~VALUE"]):?>
                        <div class="person__info-block">
                            <div class="person__sup-text"><?=GetMessage("CONSULTANTS_PAGE_PROP_MAIL")?></div>
                            <a class="underline" href="mailto:<?=$arItem["PROPERTIES"]["MAIL"]["VALUE"]?>"><?=$arItem["PROPERTIES"]["MAIL"]["~VALUE"]?>
                            </a>
                        </div>
                    <?endif;?>
                    <?if($arItem["~PREVIEW_TEXT"] && $arParams["DISPLAY_PREVIEW_TEXT"] != "N"):?>
                        <div class="person__info-block person__info-block--full">
                            <div class="person__sup-text">
                                <?=$arItem["~PREVIEW_TEXT"]?>
                            </div>
                        </div>
                    <?endif;?>
                </div>
            </div>
        </div>
    </div>
<?endforeach;?>
