<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if (count($arResult) < 1)
    return;
?>

<div class="sitemap">
    <div class="sitemap__wrapper">
        <div class="sitemap__block">
            <?$i = 0;
            foreach($arResult as  $arItem):?>

            <?if($arItem["DEPTH_LEVEL"] == "1"):?>
            <?if($i==2 || $i == 4):?>
        </div>
        <div class="sitemap__block">
            <?endif;?>
            <a class="h2" href="<?=$arItem["LINK"]?>">
                <?=$arItem["TEXT"]?>
            </a>
            <?$i=$i+1;?>
            <?else:?>
                <a class="t1 t1--gray" href="<?=$arItem["LINK"]?>">
                    <?=$arItem["TEXT"]?>
                </a>
            <?endif?>
            <?endforeach;?>
        </div>
        <div class="sitemap__block sitemap__block--empty"></div>
        <div class="sitemap__block">
        <?$APPLICATION->IncludeFile(
            SITE_DIR . 'include/map/contacts_info.php',
            Array(),
            Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "contacts_info", 'TEMPLATE' => 'default.php')
        );?>
        </div>
    </div>
</div>
