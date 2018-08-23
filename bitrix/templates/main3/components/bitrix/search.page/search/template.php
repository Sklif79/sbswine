<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

?>
<div class="search-page">
    <div class="search-main animateThis" data-anim="fadeInUp">
        <form  class="search-main__form" name="frm-search"  method="get" action="<?=$APPLICATION->GetCurPage()?>" onsubmit="var str=document.getElementById('searchinp-long'); if (!str.value || str.value == str.title) return false;" >
            <input class="search-main__input" id="searchinp-long" type="text" value="<?=$arResult["REQUEST"]["QUERY"]?>" placeholder="<?=GetMessage("SEARCH_PAGE__TITLE_INPUT");?>" name="q" maxlength="150" />
            <button class="search-main__label" for="search_page" type="submit"></button>
        </form>
    </div>

<div class="search-result">
    <?if(count($arResult["SEARCH"])>0):
     if($arResult['NAV_INFO'] == 1){
        $num=1;
     }else{
         $num =  ($arResult['NAV_INFO']-1)*$arParams["PAGE_RESULT_COUNT"]+1;
     }
    ?>
    <div class="search-page__wrapper">
            <?$i=$num;foreach($arResult["SEARCH"] as $arItem):?>
                <a class="search-page__item animateThis" href="<?echo $arItem["URL"]?>" data-anim="fadeInUp">
                    <div class="search-page__item-title">
                        <div class="h3"><?=$i?>.</div>
                        <div class="h3 underline"><?=strip_tags(htmlspecialchars_decode($arItem["TITLE_FORMATED"]))?></div>
                    </div>
                    <div class="search-page__item-text">
                        <p> <?=htmlspecialcharsBack($arItem["BODY_FORMATED"])?></p>
                    </div>
                </a>
            <?$i++;endforeach;?>
        </div>
        <?if($arParams["DISPLAY_BOTTOM_PAGER"] != "N"):?><div class="page-count"><?=$arResult["NAV_STRING"]?></div><?endif;?>
        <?if($arParams["SHOW_ORDER_BY"] != "N"):?>
            <div class="search-sorting"><label><?=GetMessage("CT_BSP_ORDER")?>:</label>&nbsp;
                <?if($arResult["REQUEST"]["HOW"]=="d"):?>
                    <a href="<?=$arResult["URL"]?>&amp;how=r"><?=GetMessage("CT_BSP_ORDER_BY_RANK")?></a>&nbsp;<b><?=GetMessage("CT_BSP_ORDER_BY_DATE")?></b>
                <?else:?>
                    <b><?=GetMessage("CT_BSP_ORDER_BY_RANK")?></b>&nbsp;<a href="<?=$arResult["URL"]?>&amp;how=d"><?=GetMessage("CT_BSP_ORDER_BY_DATE")?></a>
                <?endif;?>
            </div>
        <?endif;?>
    <?else:?>
        <?ShowNote(GetMessage("CT_BSP_NOTHING_TO_FOUND"));?>
    <?endif;?>

</div>
</div>
<?/*/?><pre><?print_r($arResult)?></pre><?//*/?>