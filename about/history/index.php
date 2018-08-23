<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "купить вино в минске");
$APPLICATION->SetPageProperty("description", "Сеть магазинов ВИНО от импортера");
$APPLICATION->SetPageProperty("title", "История компании");
$APPLICATION->SetTitle("История сети магазинов \"ВИНО\"");
?><div class="news-page-inner-item">
	<h2>Каждый день мы занимаемся вином!</h2>
	<p>
		 ООО «Сервисбытснаб» - современная компания с устойчивыми принципами ведения бизнеса. Основанная в 1995 году, она стала одной из первых на рынке импорта алкогольной продукции в Республике Беларусь и по сей день занимает лидирующие позиции. На протяжении трех десятков лет мы занимаемся тщательным отбором алкогольных напитков, чтобы удовлетворить предпочтения наших клиентов. За время работы нам удалось наладить надежную партнерскую сеть среди корпоративных клиентов и торговых флагманов. Наша собственная торговая сеть насчитывает 11 магазинов-бутиков алкогольной продукции в городе Минске, первый из которых открылся в 1998 году.<br>
	</p>
 <br>
	<h2>Наши цели:</h2>
	<p>
	</p>
	<ul>
		<li>
		<p>
			 сохранение лидирующих позиций на рынке алкогольной продукции;
		</p>
 </li>
		<li>
		<p>
			 развитие ассортимента путем подбора уникального портфеля брендов;
		</p>
 </li>
		<li>
		<p>
			 развитие собственной фирменной сети магазинов «Вино».
		</p>
 </li>
	</ul>
	<p>
	</p>
	<p>
 <br>
	</p>
	<p>
		 Команда наших сотрудников, каждый из которых обладает самой высокой степенью компетенции в своей области – наша самая большая гордость. Компания стремится к профессиональному развитию каждого члена коллектива и готова вкладывать ресурсы в свое уверенное будущее.
	</p>
 <br>
	<p>
		 Благодаря наличию собственной растущей розничной сети, мы обладаем уникальной возможностью получать мгновенную обратную связь от конечных покупателей. Мы стараемся делать покупки в наших магазинах интересными и захватывающими, а наш ассортимент позволяет удовлетворить любые вкусы.
	</p>
	 <?$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"inner_page_slider",
	Array(
		"ACTIVE_DATE_FORMAT" => "",
		"ADD_SECTIONS_CHAIN" => "N",
		"CACHE_FILTER" => "Y",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "360000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "index_page_slider",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"PREVIEW_TEXT",1=>"PREVIEW_PICTURE",),
		"FILTER_NAME" => "filterMainSlider",
		"IBLOCK_ID" => "1",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "N",
		"MESSAGE_404" => "",
		"NEWS_COUNT" => "15",
		"PARENT_SECTION" => "8",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"LINK",),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_TITLE" => "N",
		"SORT_BY1" => "SORT",
		"SORT_BY2" => "ID",
		"SORT_ORDER1" => "",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	)
);?>
	<div class="news-page-inner-item__block animateThis" data-anim="fadeInUp">
		<h3 class="upper">миссия наших магазинов:</h3>
		<p>
			 Сеть магазинов «ВИНО» - развитая и самостоятельная сеть магазинов «у дома» с уникальным ассортиментом вин и крепкого алкоголя. Каждый напиток подобран с любовью и имеет свою историю. Здесь вам помогут выбрать подходящее под ваш вкус и повод вино, портвейн, херес, кальвадос, коньяк, бренди, виски – и многие другие напитки.&nbsp;В сети магазинов «ВИНО» работают только профессиональные консультанты, способные подобрать напиток на любой, даже самый изысканный вкус.<br>
		</p>
	</div>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>