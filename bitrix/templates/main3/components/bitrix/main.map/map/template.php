<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!is_array($arResult["arMap"]) || count($arResult["arMap"]) < 1)
	return;

$arRootNode = Array();
foreach($arResult["arMap"] as $index => $arItem)
{
	if ($arItem["LEVEL"] == 0)
		$arRootNode[] = $index;
}

$allNum = count($arRootNode);
$colNum = ceil($allNum / $arParams["COL_NUM"]);



?>
<div class="sitemap">
    <div class="sitemap__wrapper">

		<?
		$previousLevel = -1;
		$counter = 0;
		$column = 1;
		foreach($arResult["arMap"] as $index => $arItem):
			$arItem["FULL_PATH"] = htmlspecialcharsbx($arItem["FULL_PATH"], ENT_COMPAT, false);
			$arItem["NAME"] = htmlspecialcharsbx($arItem["NAME"], ENT_COMPAT, false);
			$arItem["DESCRIPTION"] = htmlspecialcharsbx($arItem["DESCRIPTION"], ENT_COMPAT, false);
		?>

			<?if ($arItem["LEVEL"] < $previousLevel):?>
				<?=str_repeat("</div>", ($previousLevel - $arItem["LEVEL"]));?>
			<?endif?>


			<?if ($counter >= $colNum && $arItem["LEVEL"] == 0):
					$allNum = $allNum-$counter;
					$colNum = ceil(($allNum) / ($arParams["COL_NUM"] > 1 ? ($arParams["COL_NUM"]-$column) : 1));
					$counter = 0;
					$column++;
			?>
                </div>
			<?endif?>

			<?if (array_key_exists($index+1, $arResult["arMap"]) && $arItem["LEVEL"] < $arResult["arMap"][$index+1]["LEVEL"]):?>
                <div class="sitemap__block">
                    <a class="h2" href="<?=$arItem["FULL_PATH"]?>">
                        <?=$arItem["NAME"]?>
                    </a>
			<?else:?>

                <?if($arItem["LEVEL"] == "0"):?>
                <div class="sitemap__block">
                    <a class="h2" href="<?=$arItem["FULL_PATH"]?>">
                        <?=$arItem["NAME"]?>
                    </a>
                </div>
                <?else:?>
                    <a class="t1 t1--gray" href="<?=$arItem["FULL_PATH"]?>">
                        <?=$arItem["NAME"]?>
                    </a>
			    <?endif?>
			<?endif?>

			<?
				$previousLevel = $arItem["LEVEL"];
				if($arItem["LEVEL"] == 0)
					$counter++;
			?>

		<?endforeach?>

		<?if ($previousLevel > 1)://close last item tags?>
			<?=str_repeat("</div>", ($previousLevel-1) );?>
		<?endif?>

    </div>
</div>