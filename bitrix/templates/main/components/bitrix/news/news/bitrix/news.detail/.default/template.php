<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);
//pr($arResult);
?>
<?$this->SetViewTarget('header_block_title');?>
<div class="h1"><?=($arResult["SECTION_INFO_NAME"]?$arResult["SECTION_INFO_NAME"]:$arResult["IBLOCK"]["NAME"])?></div>
<?$this->EndViewTarget();?>
<div class="aside-date-wrap">
    <div class="t1 t1--gray advanced-page__news-date"><?=ToLower($arResult["DISPLAY_ACTIVE_FROM"])?></div>
    <a class="link-prev" href="<?=$arParams["SEF_FOLDER"]?>">
        <div class="back-button">
            <div class="back-button__wrapper">
                <div class="back-button__image">
                    <svg height="9" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                        <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                    </svg>
                </div>
                <div class="back-button__text">
                    <?=GetMessage("NEWS_PAGE_LINK_PREV")?>
                </div>
            </div>
        </div>
    </a>
</div>

<div class="news-page-inner-item">
    <h1 class="h2"><?=$arResult["~NAME"]?></h1>
    <?if($arResult["RESIZE_IMG"]):?>
        <div class="news-page-inner-item__image">
            <img src="<?=$arResult["RESIZE_IMG"]["src"]?>" alt="<?=$arResult["NAME"]?>">
        </div>
    <?endif;?>
    <?=$arResult["~DETAIL_TEXT"]?>
</div>
