<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$this->setFrameMode(true);

?>
<div class="advanced-page__aside">
    <?if($arResult["RESIZE_IMG"]):?>
        <img src="<?=$arResult["RESIZE_IMG"]["src"]?>" alt="<?=$arResult["NAME"]?>">
    <?endif;?>
</div>
<a class="link-prev" href="<?=$arParams["SEF_FOLDER"]?>">
    <div class="back-button">
        <div class="back-button__wrapper">
            <div class="back-button__image">
                <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                    <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                </svg>
            </div>
            <div class="back-button__text">
                 <?=GetMessage("NEWS_PAGE_LINK_PREV")?>
            </div>
        </div>
    </div>
</a>
<div class="advanced-page__content">
    <h2><?=$arResult["~NAME"]?></h2>
    <?=$arResult["~DETAIL_TEXT"]?>
</div>
