<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);

if (count($arResult) < 1)
return;

?>

<div class="advanced-page__aside">
    <?

    $previousLevel = 0;
    foreach($arResult as  $arItem):

    if ($previousLevel && $arItem["DEPTH_LEVEL"] < $previousLevel):
        echo str_repeat("</div></div></div></div></div>", ($previousLevel - $arItem["DEPTH_LEVEL"]));
    endif;
            if ($arItem["IS_PARENT"]):?>

                <div class="advanced-page__href-wrap animateThis" data-anim="fadeInUp">
                    <div class="dropdown-menu">
                        <div class="dropdown-menu__wrapper">
                            <div class="dropdown-menu__main">
                                <div class="dropdown-menu__item dropdown-menu__item--main"><?=$arItem["TEXT"]?></div>
                                <div class="dropdown-menu__image">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                                        <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="dropdown-menu__items-wrapper">
                                <div class="dropdown-menu__inner-items-wrapper">
            <?else:?>
                <?if($arItem["DEPTH_LEVEL"]=="1"):?>
                    <div class="advanced-page__href-wrap animateThis" data-anim="fadeInUp">
                        <a class="t1<?=($arItem["SELECTED"]?" active":"")?>" href="<?=$arItem["LINK"]?>">
                            <?=$arItem["TEXT"]?>
                        </a>
                    </div>
                <?else:?>
                    <div class="dropdown-menu__inner-items-wrapper-inner ">
                        <a class="dropdown-menu__item" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?>
                            <?/*?>
                            <div class="dropdown-menu__item-count">75</div>
                            <?//*/?>
                        </a>
                    </div>
            <?endif;?>
        <?endif;

        $previousLevel = $arItem["DEPTH_LEVEL"];
        endforeach;

        if ($previousLevel > 1):
            echo str_repeat("</div></div></div></div></div>", ($previousLevel-1) );
        endif;
?>


</div>
