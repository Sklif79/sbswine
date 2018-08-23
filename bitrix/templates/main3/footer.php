<?
use Bitrix\Main\Page\Asset, Bitrix\Main\Page\AssetLocation;
?>
				<?if($isInner):?>
									</div>
                                    <?$APPLICATION->ShowViewContent('catalog_detail_view_text');?>
								</div>
                                <?$APPLICATION->ShowViewContent('catalog_view_text');?>
							</div>
						</div>
                    </div>
                    <?$APPLICATION->ShowViewContent('footer_view_text');?>
				<?endif;?>
            </main>
            <footer class="page__footer">
                <div class="wrapper" id="footer">
                    <div class="footer">
                        <div class="footer__wrapper">
                            <div class="footer__block footer__block--right animateThis" data-anim="fadeInUp">
                                <?$APPLICATION->IncludeFile(
                                    SITE_DIR . 'include/social_link.php',
                                    Array(),
                                    Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "social_link", 'TEMPLATE' => 'default.php')
                                );?>
                                <?$APPLICATION->IncludeFile(
                                    SITE_DIR . 'include/copyright.php',
                                    Array(),
                                    Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "copyright", 'TEMPLATE' => 'default.php')
                                );?>
                            </div>
                            <div class="footer__block footer__block--right animateThis" data-anim="fadeInUp">
                                <?
                                // template menu "top" !!!
                                $APPLICATION->ShowViewContent('footer_menu');?>
                                <div class="footer__block-down">
                                    <?$APPLICATION->IncludeFile(
                                        SITE_DIR . 'include/footer_mail.php',
                                        Array(),
                                        Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "footer_mail", 'TEMPLATE' => 'default.php')
                                    );?>
                                </div>
                            </div>
                            <div class="footer__block footer__block--empty animateThis" data-anim="fadeInUp"></div>
                            <div class="footer__block footer__block--left animateThis" data-anim="fadeInUp">
                                <div class="search">
                                    <?$APPLICATION->IncludeFile(
                                        SITE_DIR . 'include/footer_search.php',
                                        Array(),
                                        Array("MODE" => "text", "SHOW_BORDER" => true, "NAME" => "footer_search", 'TEMPLATE' => 'default.php')
                                    );?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="to-up">
                    <div class="to-up__image">
                        <svg xmlns="http://www.w3.org/2000/svg" viewbox="0 0 8.1 13.4">
                            <path d="M1.4 13.4L0 12l5.3-5.3L0 1.4 1.4 0l6.7 6.7z"/>
                        </svg>
                    </div>
                </div>
            </footer>
        </div>
    </div>
</div>

<!--END out-->
<?
$APPLICATION->IncludeFile(
    SITE_DIR . 'include/main_form.php',
    Array(),
    Array("MODE" => "text", "SHOW_BORDER" => false, 'TEMPLATE' => 'default.php')
);

?>

<script>Dropzone.autoDiscover = false;</script>
<?

Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/lib.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/lib/marker.js");
Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/js/common.js", true);
Asset::getInstance()->addString('<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>',false, AssetLocation::AFTER_JS);
Asset::getInstance()->addString('<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.js"></script>', false, AssetLocation::AFTER_JS);
Asset::getInstance()->addString('<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcFkgUmSnM7fy40cDnRn8BB_xu1cp7Ros&amp;callback=&language='.LANGUAGE_ID.'"></script>', false, AssetLocation::BEFORE_CSS);

?>

<?/*
    <script src="<?=SITE_TEMPLATE_PATH?>/js/lib.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDcFkgUmSnM7fy40cDnRn8BB_xu1cp7Ros&amp;callback="></script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/lib/marker.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.1.1/min/dropzone.min.js"></script>
    <script>Dropzone.autoDiscover = false;</script>
    <script src="<?=SITE_TEMPLATE_PATH?>/js/common.min.js"></script>
*/?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript" >
    (function (d, w, c) {
        (w[c] = w[c] || []).push(function() {
            try {
                w.yaCounter47529289 = new Ya.Metrika2({
                    id:47529289,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,
                    webvisor:true
                });
            } catch(e) { }
        });

        var n = d.getElementsByTagName("script")[0],
            s = d.createElement("script"),
            f = function () { n.parentNode.insertBefore(s, n); };
        s.type = "text/javascript";
        s.async = true;
        s.src = "https://mc.yandex.ru/metrika/tag.js";

        if (w.opera == "[object Opera]") {
            d.addEventListener("DOMContentLoaded", f, false);
        } else { f(); }
    })(document, window, "yandex_metrika_callbacks2");
</script>
<noscript><div><img src="https://mc.yandex.ru/watch/47529289" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-114077052-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-114077052-1');
</script>

</body>
</html>