<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
IncludeTemplateLangFile(__FILE__);

$curDir = $APPLICATION->GetCurDir();
$arCurDir = explode("/", $APPLICATION->GetCurDir());
$levelDir = count(explode("/",$curDir));
$isMain = $GLOBALS['APPLICATION']->GetCurPage(true) == SITE_DIR . "index.php";
$isCatalog = array_search('catalog', $arCurDir);
$isNews = array_search('news_events', $arCurDir);
$isAction = array_search('actions', $arCurDir);
$isInner = !$isMain;

CJSCore::Init(array('ajax', 'window'));
?>

<!DOCTYPE html>
<html lang="ru">
<head>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter48453539 = new Ya.Metrika({
                    id:48453539,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/watch.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/48453539" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

    <? $APPLICATION->ShowHead(); ?>
    <title><?$APPLICATION->ShowTitle()?></title>
	<meta name="yandex-verification" content="39fb2c3420fda52a" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="format-detection" content="telephone=no">
    <meta content="True" name="HandheldFriendly">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="theme-color" content="#5e2120">
    <meta name="apple-mobile-web-app-status-bar-style" content="#5e2120">
    <meta name="format-detection" content="telephone=no">
    <meta name="format-detection" content="address=no">
    <link rel="shortcut icon" href="<?=SITE_TEMPLATE_PATH?>/img/fav/48x48.png" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="57x57" href="<?=SITE_TEMPLATE_PATH?>/img/fav/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?=SITE_TEMPLATE_PATH?>/img/fav/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?=SITE_TEMPLATE_PATH?>/img/fav/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?=SITE_TEMPLATE_PATH?>/img/fav/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?=SITE_TEMPLATE_PATH?>/img/fav/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?=SITE_TEMPLATE_PATH?>/img/fav/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?=SITE_TEMPLATE_PATH?>/img/fav/apple-touch-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?=SITE_TEMPLATE_PATH?>/img/fav/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=SITE_TEMPLATE_PATH?>/img/fav/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?=SITE_TEMPLATE_PATH?>/img/fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="194x194" href="<?=SITE_TEMPLATE_PATH?>/img/fav/favicon-194x194.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?=SITE_TEMPLATE_PATH?>/img/fav/android-chrome-192x192.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?=SITE_TEMPLATE_PATH?>/img/fav/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#5e2120">
    <meta name="msapplication-TileImage" content="<?=SITE_TEMPLATE_PATH?>/img/fav/mstile-144x144.png">
    <?if($isMain):?>
        <?$siteUrl = (CMain::IsHTTPS()) ? "https://" : "http://".$_SERVER["SERVER_NAME"]?>
        <meta property="og:image" content="<?=$siteUrl?>/upload/ogWine.jpg">
	<meta property="og:image:width" content="250">
	<meta property="og:image:height" content="250">
    <?endif;?>


    <?
    //*/
    $urlSectionCss = $APPLICATION->GetProperty('sectionCss'); ?>
    <?if(strlen($urlSectionCss)>4):?>
        <?$APPLICATION->IncludeFile($urlSectionCss, Array(),Array("MODE" => "text", "SHOW_BORDER" => false));?>
    <?endif;?>
        <?$APPLICATION->ShowViewContent('header_css');
    //*/
    ?>

    <link rel="preload" media="all" href="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH."/css/screen.min.css")?>" as="style" onload="this.rel='stylesheet'">
    <noscript><link rel="stylesheet" media="all" href="<?=CUtil::GetAdditionalFileURL(SITE_TEMPLATE_PATH."/css/screen.min.css")?>"></noscript>
    <?
    $APPLICATION->IncludeFile(
        '/include/js_head.php',
        Array(),
        Array("MODE" => "text", "SHOW_BORDER" => false, 'TEMPLATE' => 'default.php')
    );
    ?>
</head>
<body data-lang="<?=LANGUAGE_ID?>">
<? if ($USER->IsAuthorized()): ?>
    <div id="panel"><? $APPLICATION->ShowPanel() ?></div>
<? endif; ?>
<?
$APPLICATION->IncludeFile(
    '/include/js_body.php',
    Array(),
    Array("MODE" => "text", "SHOW_BORDER" => false, 'TEMPLATE' => 'default.php')
);
?>
<div class="out">
    <div class="page__outer">
        <div class="page__wrapper">
            <style>
                #header-mainwrap{position: relative !important;}
            </style>
            <?
            $iblock = (LANGUAGE_ID == 'en') ? 17 : 2;
            $APPLICATION->IncludeComponent(
                "bitrix:news.list",
                "list_brands_top",
                array(
                    //"IS_AJAX"	=>	$isPAginAjax?"Y":"",
                    "ACTIVE_DATE_FORMAT" => "",
                    "ADD_SECTIONS_CHAIN" => "N",
                    "CACHE_FILTER" => "Y",
                    "CACHE_GROUPS" => "Y",
                    "SET_TITLE" => "N",
                    "CACHE_TIME" => "360000000",
                    "CACHE_TYPE" => "A",
                    "CHECK_DATES" => "Y",
                    "DISPLAY_BOTTOM_PAGER" => "N",
                    "DISPLAY_TOP_PAGER" => "N",
                    "FIELD_CODE" => array(
                        0 => "PREVIEW_TEXT",
                        1 => "PREVIEW_PICTURE",
                    ),
                    "FILTER_NAME" => "filterMainSlider",
                    "IBLOCK_ID" => $iblock,
                    "IBLOCK_TYPE" => "content",
                    "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                    "INCLUDE_SUBSECTIONS" => "N",
                    "MESSAGE_404" => "",
                    "NEWS_COUNT" => "40",
                    "PARENT_SECTION" => "",
                    "PARENT_SECTION_CODE" => "",
                    "PREVIEW_TRUNCATE_LEN" => "",
                    "PROPERTY_CODE" => array(
                        0 => "LINK",
                    ),
                    "SET_BROWSER_TITLE" => "N",
                    "SET_LAST_MODIFIED" => "N",
                    "SET_META_DESCRIPTION" => "N",

                    "SORT_BY1" => "SORT",
                    "SORT_BY2" => "ID",
                    "SORT_ORDER1" => "",
                    "SORT_ORDER2" => "ASC",
                    "STRICT_SECTION_CHECK" => "N",
                    "COMPONENT_TEMPLATE" => "index_page_slider",

                ),
                false
            );

            ?>
            <header class="page__header--wrap" style="padding-bottom: 5rem;">
                <div class="page__header cd-auto-hide-header">
                    <div id="header-mainwrap">
                        <div class="header-inner animated fadeInDownMenu">
                            <div class="header-inner__fixed-menu">
                                <div class="header-nav-wrapper">
                                    <div class="header-nav-wrapper__left-block">
                                        <?$APPLICATION->IncludeFile(
                                            SITE_DIR . 'include/contacts_header_left.php',
                                            Array(),
                                            Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "contacts_header", 'TEMPLATE' => 'default.php')
                                        );?>
                                    </div>
                                    <div class="header-nav-wrapper__middle-block">
                                        <nav class="header-nav-wrapper__nav">
                                            <? $APPLICATION->IncludeComponent(
                                                "bitrix:menu",
                                                "top",
                                                array(
                                                    "ROOT_MENU_TYPE" => "top",
                                                    "MENU_CACHE_TYPE" => "Y",
                                                    "MENU_CACHE_TIME" => "36000000",
                                                    "MENU_CACHE_USE_GROUPS" => "Y",
                                                    "MENU_CACHE_GET_VARS" => array(),
                                                    "MAX_LEVEL" => "1",
                                                    "CHILD_MENU_TYPE" => "",
                                                    "USE_EXT" => "Y",
                                                    "DELAY" => "N",
                                                    "ALLOW_MULTI_SELECT" => "N",
                                                    "COMPONENT_TEMPLATE" => ""
                                                ),
                                                false
                                            ); ?>
                                            <?if($isMain):?>
                                                <span class="header-nav-wrapper__logo">
                                            <?else:?>
                                                <a class="header-nav-wrapper__logo" href="<?=SITE_DIR?>">
                                            <?endif;?>
                                                <?$APPLICATION->IncludeFile(
                                                    SITE_DIR . 'include/logo.php',
                                                    Array(),
                                                    Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "logo", 'TEMPLATE' => 'default.php')
                                                );?>
                                            <?if($isMain):?>
                                                </span>
                                            <?else:?>
                                                </a>
                                            <?endif;?>
                                        </nav>
                                    </div>
                                    <div class="header-nav-wrapper__right-block">
                                        <?$APPLICATION->IncludeFile(
                                            SITE_DIR . 'include/lang.php',
                                            Array(),
                                            Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "lang", 'TEMPLATE' => 'default.php')
                                        );?>
                                        <?$APPLICATION->IncludeFile(
                                            SITE_DIR . 'include/search.php',
                                            Array(),
                                            Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "search", 'TEMPLATE' => 'default.php')
                                        );?>

                                    </div>
                                </div>
                                <div class="header-nav-wrapper header-nav-wrapper--mobile">
                                    <div class="header-nav-wrapper__inner-mobile">
                                        <div class="header-nav-wrapper__left-block header-nav-wrapper__left-block--mobile">
                                            <?$APPLICATION->IncludeFile(
                                                SITE_DIR . 'include/header_contacts.php',
                                                Array(),
                                                Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "lang", 'TEMPLATE' => 'default.php')
                                            );?>
                                        </div>
                                        <!--<?$APPLICATION->IncludeFile(
                                            SITE_DIR . 'include/index_logo.php',
                                            Array(),
                                            Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "lang", 'TEMPLATE' => 'default.php')
                                        );?>-->
										<div class="header-nav-wrapper__middle-block header-nav-wrapper__middle-block--mobile">
<?if($isMain):?>
                                                <span class="header-nav-wrapper__logo">
                                            <?else:?>
                                                <a class="header-nav-wrapper__logo" href="<?=SITE_DIR?>">
                                            <?endif;?>

                                                <?$APPLICATION->IncludeFile(
                                                    SITE_DIR . 'include/logo.php',
                                                    Array(),
                                                    Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "logo", 'TEMPLATE' => 'default.php')
                                                );?>
                                        <?if($isMain):?>
											</span>
                                            <?else:?>
										</a>
                                            <?endif;?>
										</div>
                                        <div class="header-nav-wrapper__right-block header-nav-wrapper__right-block--mobile">
                                            <div class="header-nav-wrapper__burger">
                                                <div class="header-nav-wrapper__burger-stick"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <? $APPLICATION->IncludeComponent(
                                        "bitrix:menu",
                                        "mobile",
                                        array(
                                            "ROOT_MENU_TYPE" => "top",
                                            "MENU_CACHE_TYPE" => "Y",
                                            "MENU_CACHE_TIME" => "36000000",
                                            "MENU_CACHE_USE_GROUPS" => "Y",
                                            "MENU_CACHE_GET_VARS" => array(),
                                            "MAX_LEVEL" => "2",
                                            "CHILD_MENU_TYPE" => "left",
                                            "USE_EXT" => "Y",
                                            "DELAY" => "N",
                                            "ALLOW_MULTI_SELECT" => "N",
                                            "COMPONENT_TEMPLATE" => ""
                                        ),
                                        false
                                    ); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <main class="page__content">

			<?if($isInner):?>
			<div class="article ">
    <div class="section">
        <div class="advanced-page">
            <div class="advanced-page__title-block animateThis" data-anim="fadeInUp">
                <?$APPLICATION->IncludeComponent("bitrix:breadcrumb", "breadcrumb", array(
                    "START_FROM" => "0",
                    "PATH" => "",
                    "SITE_ID" => "s1"
                ),
                    false,
                    array(
                        "HIDE_ICONS" => "N"
                    )
                );?>
                <?if(!$isCatalog && !$isNews && !$isAction):?>
                    <h1><?$APPLICATION->ShowTitle(false)?></h1>
                <?endif;?>
                <? $APPLICATION->IncludeComponent("bitrix:main.include", "", array(
                    "AREA_FILE_SHOW" => "page",
                    "AREA_FILE_SUFFIX" => "title_text",
                    "EDIT_TEMPLATE" => "default.php"
                ),
                    false,
                    array("HIDE_ICONS" => "N")
                ); ?>
                <?$APPLICATION->ShowViewContent('header_block_title');?>
            </div>

            <div class="<?$APPLICATION->ShowProperty('classAside')?>">
                <?
                $showAsideMenu = $APPLICATION->GetProperty('viewAside');
                if($showAsideMenu != "N"):
                ?>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "aside",
                        array(
                            "ROOT_MENU_TYPE" => "left",
                            "MENU_CACHE_TYPE" => "Y",
                            "MENU_CACHE_TIME" => "36000000",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => array(),
                            "MAX_LEVEL" => "2",
                            "CHILD_MENU_TYPE" => "left",
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "N",
                            "COMPONENT_TEMPLATE" => ""
                        ),
                        false
                    );
                endif;
                ?>
                <?$APPLICATION->ShowViewContent('aside_block_menu');?>
                <div class="<?$APPLICATION->ShowProperty('contentClass')?>">
			<?endif;?>
                    <script>
                        $(function(){
                            $(window).scroll(function(){
                                var top = $(this).scrollTop();
                                if (top > 150) {
                                    $('header.page__header--wrap').addClass('top_nav');
                                } else {
                                    $('header.page__header--wrap').removeClass('top_nav');
                                }
                            });
                        });
                    </script>
                    <style>
                        .top_nav{
                            height: 150px;
                            position: fixed;
                            top: 0;
                            width: 100%;
                            z-index: 3;
                        }
                    </style>