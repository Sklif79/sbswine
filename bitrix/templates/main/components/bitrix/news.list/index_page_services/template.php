<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);
if (count($arResult["ITEMS"]) <= 0)
    return;
?>
<div class="article">
    <div class="section">
        <div class="index-services">
            <div class="index-services__wrapper">
                <div class="index-services__image">
                    <img src="<?=strlen($arParams["DEFAULT_BG_IMG"])>0?$arParams["DEFAULT_BG_IMG"]:"/bitrix/templates/main/img/index/block_bg.jpg"?>" alt="bg_services">
                </div>
                <?/*$APPLICATION->IncludeFile(
                    SITE_DIR . 'include/index/text_services.php',
                    Array(),
                    Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "text_services", 'TEMPLATE' => 'default.php')
                );*/?>
                <div class="index-services__cards-block small-block animateThis" data-anim="fadeInUp" style="margin-top: 1.625rem;">
                    <div class="index-services__title h1"><?=GetMessage("INDEX_PAGE_SERVICES_TITLE")?></div>
                    <div class="index-services__cards slider-adapt" data-adapt="9900" data-slick="{&quot;slidesToShow&quot;:3, &quot;slidesToScroll&quot;:3, &quot;dots&quot;: false, &quot;arrows&quot;: false, &quot;responsive&quot;: [{&quot;breakpoint&quot;: 992, &quot;settings&quot;: {&quot;slidesToShow&quot;: 2, &quot;slidesToScroll&quot;: 2, &quot;arrows&quot;: true}},{&quot;breakpoint&quot;: 600, &quot;settings&quot;: {&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1, &quot;arrows&quot;: true}}]}">
                        <? foreach ($arResult["ITEMS"] as $arItem):
                            $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                            $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                            ?>
                            <div class="card card--catalog" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                                <a class="card__href" href="<?=$arItem['DETAIL_PAGE_URL']?>"></a>
                                <div class="card__image" style="background-image: url(<?= $arItem["RESIZE_IMG"]["src"] ?>);"></div>
                                <div class="card__visible">
                                    <div class="card__title"><?= $arItem["~NAME"] ?></div>
                                </div>
                            </div>
                        <?endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>