<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

if (empty($arResult["VOTE"]) || empty($arResult["QUESTIONS"])):
    return true;
endif;


?>
<div class="index-gray-block__right-side">
    <div class="index-gray-block__title h3 upper"><?=$arResult["CHANNEL"]["~TITLE"]?></div>
    <div class="aside-block aside-block--question">
        <? foreach ($arResult["QUESTIONS"] as $arQuestion): ?>
        <div class="aside-block__wrapper aside-block__formFocus">
            <div class="aside-block__text animateThis" data-anim="fadeInUp">
                <?=$arQuestion["~QUESTION"]?>
            </div>
            <div class="checkboxes checkboxes--radial animateThis" data-anim="fadeInUp">
                <div class="vote-items-list vote-answers-list">
                    <div class="vote-items-list vote-answers-list">
                        <?foreach ($arQuestion["ANSWERS"] as $arAnswer): ?>
                            <div class="vote-items-list vote-answers-list">
                                <span class="vote-item-name"><?= $arAnswer["MESSAGE"] ?></span>
                                - <span class="vote-item-count"><?= $arAnswer["COUNTER"] ?></span>
                                (<span class="vote-item-result"><?= $arAnswer["PERCENT"] ?>%</span>)
                            </div>
                        <?endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
        <? endforeach; ?>
    </div>
</div>