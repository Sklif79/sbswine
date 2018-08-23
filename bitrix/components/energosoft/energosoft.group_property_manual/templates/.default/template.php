<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
if ($arResult["SHOW_CHAR"] != "Y")
    return;
unset($arResult["SHOW_CHAR"]);
?>


<div class="advanced-page-inner-block">
    <h2 class="h3"><?=GetMessage("CATALOG_SHOPS_TITLE_CHAR")?></h2>
    <?foreach($arResult as $arElement):?>
        <?if(count($arElement["PROPERTIES"]) > 0):?>
            <div class="table table--construction">
            <div class="table__title">
                <div class="t1 t1--light"><?=$arElement["NAME"]?></div>
            </div>
            <div class="table__body">
                <?
                //pr($arElement["PROPERTIES"]);
                foreach($arElement["PROPERTIES"] as $arProp):?>
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
    <?endforeach;?>
</div>