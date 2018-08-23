<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
    <div class="header-nav-wrapper__menu">
        <div class="header-nav-wrapper__menu-block">
            <?$i=1;foreach($arResult as $arItem): ?>
                <?if($i!=1 && $i!=4):?><div class="header-nav-wrapper__seporator"></div><?endif;?><a class="header-nav-wrapper__menu-item" href="<?=$arItem["LINK"]?>">
                    <?=$arItem["TEXT"]?>
                </a>
            <?if($i==3):?>
             </div>
            <div class="header-nav-wrapper__menu-block">
            <?endif;?>
            <?$i++;endforeach?>
        </div>
    </div>
<?endif?>


<?$this->SetViewTarget('footer_menu');?>
<div class="footer__block-up">
    <div class="footer__block-inner">
        <div class="footer__href-wrapper">
            <a class="footer__href" href="<?=SITE_DIR?>"><?=GetMessage("FOOTER_MENU_LINK_MAIN")?></a>
        </div>
        <?$i=1;foreach($arResult as $arItem):?>
        <div class="footer__href-wrapper"><a class="footer__href" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></div>
        <?if($i==3):?>
            </div>
            <div class="footer__block-inner">
        <?endif;?>
        <?$i++;endforeach?>
    </div>
</div>
<?$this->EndViewTarget();?>
