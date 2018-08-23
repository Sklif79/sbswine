<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):

    ?>
    <div class="tabs">
        <div class="tabs__wrapper">

            <?$i=1;foreach($arResult as $arItem): ?>
                <?if($arItem["SELECTED"]):?>
                    <div class="tabs__item <?if($i==1):?>tabs__item--left <?elseif($i==3):?>tabs__item--right<?endif;?><?=($arItem["SELECTED"]?" tabs__item--active":"")?>">
                        <?=$arItem["TEXT"]?>
                    </div>
                <?else:?>
                    <a href="<?=$arItem["LINK"]?>" class="tabs__item <?if($i==1):?>tabs__item--left <?elseif($i==3):?>tabs__item--right<?endif;?><?=($arItem["SELECTED"]?" tabs__item--active":"")?>">
                        <?=$arItem["TEXT"]?>
                    </a>
             <?endif;?>
            <?$i++;endforeach?>
        </div>
    </div>
<?endif?>

