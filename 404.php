<?include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("ОШИБКА 404");
?>


        <div class="advanced-page__with-aside">
            <div class="advanced-page__aside hide-adapt"></div>
            <div class="advanced-page__content">
                <div class="error-page animateThis" data-anim="fadeInUp">
                    <h2>Страница не найдена</h2>
                    <p>Страницу, которую вы запрашиваете, не существует. Возможно она была удалена, возможно вы набрали неправильный адрес.</p>
                    <p>Вы всегда можете вернуться на <a href="/">главную страницу</a> сайта</p>
                </div>
            </div>
        </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>


