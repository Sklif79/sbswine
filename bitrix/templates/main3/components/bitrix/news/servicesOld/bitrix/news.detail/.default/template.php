<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$this->setFrameMode(true);
if($arResult["DESC"]){
    $tab = true;
}
?>


        <div class="shop-header">
            <?if($arResult["RESIZE_IMG"]):?>
                <div class="shop-header__image">
                    <div class="shop-header__big_image" style="background-image:url('<?=$arResult["RESIZE_IMG"]["src"]?>');"></div>
                </div>
            <?endif;?>
            <div class="shop-header__info">
                <?if($tab):?>
                    <div class="h2"><?=GetMessage("CONSULTANTS_PAGE_TITLE_DESC")?></div>
                    <ul>
                        <?foreach($arResult["DESC"] as $num => $arDesc):?>
                            <li>
                                <span>
                                    <div class="underline underline--animation underline--dotted" data-href="#<?=$num?>">
                                        <?=$arDesc["NAME"]?>
                                    </div>
                                </span>
                            </li>
                        <?endforeach;?>
                    </ul>
                <?endif;?>
                <div class="red-button--wrapper">
                    <a class="red-button red-button--small" href="#service-modal">
                        <div class="red-button__inner"><?=GetMessage("BTN_NAME_ORDER")?></div>
                    </a>
                </div>
            </div>
        </div>

<?$this->SetViewTarget('catalog_view_text');?>
    <div class="advanced-page__small-single">
        <div class="back-button">
            <div class="back-button__wrapper">
                <div class="back-button__image">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 8.1 13.4">
                        <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"></path>
                    </svg>
                </div>
                <div class="back-button__text">Все магазины</div>
            </div>
        </div>
        <div class="advanced-page__content advanced-page__content--single">
            <div class="news-page-inner-item">
                <div class="news-page-inner-item__block" data-id="#first">
                    <div class="h3 upper">Напитки и расчёт алкоголя на мероприятия</div>
                    <div class="t1 t1--gray">Для магазина на Богдановича мы выбрали самое удобное в районе расположение: в бизнес-центре «Норд Сити». Светлый интерьер, просторные стеллажи, широкие проходы — помещение магазина наполнено воздухом и легкостью. И если обычный поход за покупками может утомить покупателя, то визит в магазин станет для вас развлечением, отдыхом, приключением — одним словом.</div>
                    <div class="advanced-slider long-slider slick-initialized slick-slider slick-dotted" data-slick="{&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1, &quot;dots&quot;: true, &quot;arrows&quot;: true}"><button class="slick-prev slick-arrow" aria-label="Previous" type="button" style="">Previous</button>
                        <div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 3500px; transform: translate3d(-700px, 0px, 0px);"><div class="advanced-slider__slide slide-image slick-slide slick-cloned" data-slick-index="-1" aria-hidden="true" style="width: 700px;">
                                    <div class="advanced-slider__image" style="background-image: url('img/index/shop-header.jpg');"></div>
                                </div><div class="advanced-slider__slide slide-image slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" style="width: 700px;">
                                    <div class="advanced-slider__image" style="background-image: url('img/index/shop-header.jpg');"></div>
                                </div><div class="advanced-slider__slide slide-image slick-slide" data-slick-index="1" aria-hidden="true" style="width: 700px;">
                                    <div class="advanced-slider__image" style="background-image: url('img/index/shop-header.jpg');"></div>
                                </div><div class="advanced-slider__slide slide-image slick-slide" data-slick-index="2" aria-hidden="true" style="width: 700px;">
                                    <div class="advanced-slider__image" style="background-image: url('img/index/shop-header.jpg');"></div>
                                </div><div class="advanced-slider__slide slide-image slick-slide slick-cloned" data-slick-index="3" aria-hidden="true" style="width: 700px;">
                                    <div class="advanced-slider__image" style="background-image: url('img/index/shop-header.jpg');"></div>
                                </div></div></div>


                        <button class="slick-next slick-arrow" aria-label="Next" type="button" style="">Next</button><ul class="slick-dots" style=""><li class="slick-active"><button type="button" aria-pressed="true">1</button></li><li><button type="button" aria-pressed="false">2</button></li><li><button type="button" aria-pressed="false">3</button></li></ul><div class="advanced-slider__count-slides">3</div></div>
                </div>
                <div class="news-page-inner-item__block" data-id="#second">
                    <div class="h3 upper">Корпоративные подарки</div>
                    <div class="t1 t1--gray">Для магазина на Богдановича мы выбрали самое удобное в районе расположение: в бизнес-центре «Норд Сити». Светлый интерьер, просторные стеллажи, широкие проходы — помещение магазина наполнено воздухом и легкостью. И если обычный поход за покупками может утомить покупателя, то визит в магазин станет для вас развлечением, отдыхом, приключением — одним словом.</div>
                    <div class="advanced-slider long-slider slick-initialized slick-slider slick-dotted" data-slick="{&quot;slidesToShow&quot;: 1, &quot;slidesToScroll&quot;: 1, &quot;dots&quot;: true, &quot;arrows&quot;: true}"><button class="slick-prev slick-arrow" aria-label="Previous" type="button" style="">Previous</button>
                        <div class="slick-list draggable"><div class="slick-track" style="opacity: 1; width: 3500px; transform: translate3d(-700px, 0px, 0px);"><div class="advanced-slider__slide slide-image slick-slide slick-cloned" data-slick-index="-1" aria-hidden="true" style="width: 700px;">
                                    <div class="advanced-slider__image" style="background-image: url('img/index/shop-header.jpg');"></div>
                                </div><div class="advanced-slider__slide slide-image slick-slide slick-current slick-active" data-slick-index="0" aria-hidden="false" style="width: 700px;">
                                    <div class="advanced-slider__image" style="background-image: url('img/index/shop-header.jpg');"></div>
                                </div><div class="advanced-slider__slide slide-image slick-slide" data-slick-index="1" aria-hidden="true" style="width: 700px;">
                                    <div class="advanced-slider__image" style="background-image: url('img/index/shop-header.jpg');"></div>
                                </div><div class="advanced-slider__slide slide-image slick-slide" data-slick-index="2" aria-hidden="true" style="width: 700px;">
                                    <div class="advanced-slider__image" style="background-image: url('img/index/shop-header.jpg');"></div>
                                </div><div class="advanced-slider__slide slide-image slick-slide slick-cloned" data-slick-index="3" aria-hidden="true" style="width: 700px;">
                                    <div class="advanced-slider__image" style="background-image: url('img/index/shop-header.jpg');"></div>
                                </div></div></div>


                        <button class="slick-next slick-arrow" aria-label="Next" type="button" style="">Next</button><ul class="slick-dots" style=""><li class="slick-active"><button type="button" aria-pressed="true">1</button></li><li><button type="button" aria-pressed="false">2</button></li><li><button type="button" aria-pressed="false">3</button></li></ul><div class="advanced-slider__count-slides">3</div></div>
                </div>
                <div class="news-page-inner-item__block" data-id="#third">
                    <div class="h3 upper">Персональный винный погреб</div>
                    <div class="t1 t1--gray">Подбор вина в Enomatic® осуществляется таким образом, чтобы вы могли сравнить вина, объединённые неким схожим признаком.</div>
                </div>
                <div class="news-page-inner-item__block" data-id="#fourth">
                    <div class="h3 upper">Ответственный специалист</div>
                    <div class="person animateThis" data-anim="fadeInUp">
                        <div class="person__wrapper">
                            <div class="person__image">
                                <div class="person__image-block" style="background-image:url(img/index/person.jpg);"></div>
                            </div>
                            <div class="person__info">
                                <div class="person__info-block person__name-block">
                                    <div class="person__sup-text">Консультант</div>
                                    <div class="person__name">Анна Дубровская</div>
                                </div>
                                <div class="person__info-inner">
                                    <div class="person__info-block">
                                        <div class="person__sup-text">Опыт работы</div>
                                        <div class="person__age">8 лет</div>
                                    </div>
                                    <div class="person__info-block">
                                        <div class="person__sup-text">Телефон</div>
                                        <div class="person__age">+375 (29) 6800149</div>
                                    </div>
                                    <div class="person__info-block">
                                        <div class="person__sup-text">Достижения и награды</div><a class="underline" href="#">Обучение на курсах WSET®</a><a class="underline" href="#">Школах сомелье</a>
                                    </div>
                                    <div class="person__info-block">
                                        <div class="person__sup-text">E-mail</div><a class="underline" href="#">winecorp@sm.by</a>
                                    </div>
                                    <div class="person__info-block person__info-block--full">
                                        <div class="person__sup-text">Валентина является одним из самых опытных сотрудников, яркий пример лояльного сотрудника, так как работает в компании уже более 10 лет и на протяжении всего этого времени активно участвует в развитии</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?$this->EndViewTarget();?>
