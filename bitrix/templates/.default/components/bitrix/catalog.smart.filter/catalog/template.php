<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$this->setFrameMode(true);
?>

    <form name="<? echo $arResult["FILTER_NAME"] . "_form" ?>" id="smartFilter" action="<? echo $arResult["FORM_ACTION"] ?>" method="get">
        <? foreach ($arResult["HIDDEN"] as $arItem): ?>
            <input type="hidden" name="<? echo $arItem["CONTROL_NAME"] ?>" id="<? echo $arItem["CONTROL_ID"] ?>" value="<? echo $arItem["CONTROL_NAME"]  == 'PAGEN_1' ? 1 :$arItem["HTML_VALUE"] ?>"/>
        <? endforeach; ?>

        <?
        foreach ($arResult["ITEMS"] as $key => $arItem) {
            if (
                empty($arItem["VALUES"])
                || isset($arItem["PRICE"])
            )
                continue;

            if (
                $arItem["DISPLAY_TYPE"] == "A"
                && (
                    $arItem["VALUES"]["MAX"]["VALUE"] - $arItem["VALUES"]["MIN"]["VALUE"] <= 0
                )
            )
                continue;
            ?>

            <? $this->SetViewTarget('header_block_title'); ?>
            <? if ($arItem['CODE'] == 'FLG_ACTION'): ?>
                <div class="tabs" id="filterAction">
                    <div class="tabs__wrapper">
                        <?
                        $allChecked = true;
                        foreach ($arItem["VALUES"] as $val => $ar)
                            if ($ar["CHECKED"]) $allChecked = false;
                        ?>
                        <div id="0_old" data-id="0" data-class="filter-<?= $arItem['CODE'] ?>" class="tabs__item tabs__item--left<?= $allChecked ? ' tabs__item--active"' : '' ?>">все</div>
                        <?
                        $i = 0;
                        $sizeof = sizeof($arItem["VALUES"]);
                        foreach ($arItem["VALUES"] as $val => $ar): $i++; ?>
                            <div id="<? echo $ar["CONTROL_ID"] ?>_old" data-id="<? echo $ar["CONTROL_ID"] ?>" data-class="filter-<?= $arItem['CODE'] ?>" class="tabs__item<?= $sizeof == $i ? ' tabs__item--right' : '' ?><? echo $ar["CHECKED"] ? ' tabs__item--active"' : '' ?>"><?= $ar["VALUE"]; ?></div>
                        <? endforeach; ?>
                    </div>
                </div>

            <? endif; ?>
            <? $this->EndViewTarget(); ?>

            <div <?= $arItem['CODE'] == 'FLG_ACTION' ? ' style="display: none!important" ' : '' ?> class="checkboxes<? if ($arItem["DISPLAY_EXPANDED"] != "Y"): ?> deactive<? endif ?>" data-role="bx_filter_block" id="filter-<?= $arItem["CODE"] ?>">
                <span class="bx-filter-container-modef"></span>
                <div class="checkboxes__title">
                    <?= $arItem["NAME"] ?>
                    <? if ($arItem["FILTER_HINT"] <> ""): ?>
                        <i id="item_title_hint_<? echo $arItem["ID"] ?>" class="fa fa-question-circle"></i>
                        <script type="text/javascript">
                            new top.BX.CHint({
                                parent: top.BX("item_title_hint_<?echo $arItem["ID"]?>"),
                                show_timeout: 10,
                                hide_timeout: 200,
                                dx: 2,
                                preventHide: true,
                                min_width: 250,
                                hint: '<?= CUtil::JSEscape($arItem["FILTER_HINT"])?>'
                            });
                        </script>
                    <? endif ?>
                </div>
                <div class="checkboxes__wrapper">
                    <?
                    $arCur = current($arItem["VALUES"]);
                    switch ($arItem["DISPLAY_TYPE"]) {
                        case "A"://NUMBERS_WITH_SLIDER
                            break;
                        case "B"://NUMBERS
                            break;
                        case "G"://CHECKBOXES_WITH_PICTURES
                            break;
                        case "H"://CHECKBOXES_WITH_PICTURES_AND_LABELS
                            break;
                        case "P"://DROPDOWN
                            break;
                        case "R"://DROPDOWN_WITH_PICTURES_AND_LABELS
                            break;
                        case "K"://RADIO_BUTTONS
                            break;
                        case "U"://CALENDAR
                            break;
                        default://CHECKBOXES
                            ?>

                            <? foreach ($arItem["VALUES"] as $val => $ar): ?>
                            <div class="checkbox checkboxes__item">
                                <input class="checkbox__input"
                                       type="checkbox"
                                       value="<? echo $ar["HTML_VALUE"] ?>"
                                       name="<? echo $ar["CONTROL_NAME"] ?>"
                                       id="<? echo $ar["CONTROL_ID"] ?>"
                                    <? echo $ar["CHECKED"] ? 'checked="checked"' : '' ?>
                                       onclick="smartFilter.click(this)"/>
                                <label class="checkbox__label<? echo $ar["DISABLED"] ? ' disabled' : '' ?>" for="<? echo $ar["CONTROL_ID"] ?>">
                                    <div class="checkbox__check-wrapper">
                                        <div class="checkbox__check"></div>
                                    </div>
                                    <div class="checkbox__name"><?= $ar["VALUE"]; ?></div>
                                    <?
                                    if ($arParams["DISPLAY_ELEMENT_COUNT"] !== "N" && isset($ar["ELEMENT_COUNT"])):
                                        ?>
                                        <div class="checkbox__number" data-role="count_<?= $ar["CONTROL_ID"] ?>"><? echo $ar["ELEMENT_COUNT"]; ?></div><?
                                    endif; ?>
                                </label>
                            </div>
                        <? endforeach; ?>

                            <?
                    }
                    ?>
                </div>
            </div>

            <?
        }
        ?>
        
        <div class="cleanup-filter">
            <div class="t1 t1--gray"><?= GetMessage('CT_BCSF_DEL_FILTER')?></div>
        </div>

    </form>



<?
$arResult["JS_FILTER_PARAMS"]['FILTER_CONTENER'] = $arParams['FILTER_CONTENER'] ?: 'ajax_filter';
?>

<script type="text/javascript">
    var smartFilter = new JCSmartFilter('<?echo CUtil::JSEscape($arResult["FORM_ACTION"])?>', '<?=CUtil::JSEscape($arParams["FILTER_VIEW_MODE"])?>', <?=CUtil::PhpToJSObject($arResult["JS_FILTER_PARAMS"])?>);
    BX.ready(function () {


        BX.bindDelegate(
            document.body, 'click', {className: 'cleanup-filter'},
            function (e) {
                if (!e)
                    e = window.event;
                
                if(!!BX('smartFilter')) {
                    var id = false,
                    fields = BX.findChild(BX('smartFilter'), {tag: 'input'}, true, true);

                    fields.forEach(function (element) {
                        id = element;
                        element.removeAttribute('checked');
                        element.checked = false;
                    });

                    if(!!BX('filter-FLG_ACTION'))
                    smartFilter.clearAction(BX('filter-FLG_ACTION'));

                    if (id)
                        smartFilter.reload(id);
                }

                return BX.PreventDefault(e);
            }
        );


        BX.bindDelegate(
            document.body, 'click', {className: 'tabs__item'},
            function (e) {
                if (!e)
                    e = window.event;

                var data_id = this.getAttribute('data-id'),
                    data_class = this.getAttribute('data-class'),
                    id = false;

                if (data_id != 0 && !!BX(data_id)) {
                    var element = BX(data_id);
                    id = element;
                    if (element.checked) {
                        element.removeAttribute('checked');
                        element.checked = false;
                    } else {
                        element.setAttribute('checked', 'checked');
                        element.checked = true;
                    }

                } else if (!!BX(data_class)) {
                    var fields = BX.findChild(BX(data_class), {tag: 'input'}, true, true);
                    fields.forEach(function (element) {
                        id = element;
                        element.removeAttribute('checked');
                        element.checked = false;
                    });
                }

                if (!!BX(data_class))
                    smartFilter.clearAction(data_class);

                if (id)
                    smartFilter.reload(id);


                return BX.PreventDefault(e);
            }
        );


    });
</script>

