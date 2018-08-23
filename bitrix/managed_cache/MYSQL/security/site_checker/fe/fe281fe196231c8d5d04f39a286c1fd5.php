<?
if($INCLUDE_FROM_CACHE!='Y')return false;
$datecreate = '001534773359';
$dateexpire = '001537365359';
$ser_content = 'a:2:{s:7:"CONTENT";s:0:"";s:4:"VARS";a:2:{s:7:"results";a:12:{i:0;a:5:{s:5:"title";s:102:"Пароль к БД не содержит спецсимволов(знаков препинания)";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:138:"Пароль слишком прост, что повышает риск взлома учетной записи в базе данных";s:14:"recommendation";s:57:"Добавить спецсимволов в пароль";s:15:"additional_info";s:0:"";}i:1;a:5:{s:5:"title";s:105:"Ограничен список потенциально опасных расширений файлов";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:377:"Текущий список расширений файлов, которые считаются потенциально опасными, не содержит всех рекомендованных значений. Список расширений исполняемых файлов всегда должен находится в актуальном состоянии";s:14:"recommendation";s:264:"Вы всегда можете изменить список расширений исполняемых файлов в настройках сайта: <a href="/bitrix/admin/settings.php?mid=fileman" target="_blank">Управление структурой</a>";s:15:"additional_info";s:344:"Текущие: php,php3,php4,php5,php6,phtml,pl,asp,aspx,cgi,exe,ico,shtm,shtml<br>
Рекомендованные (без учета настроек вашего сервера): php,php3,php4,php5,php6,phtml,pl,asp,aspx,cgi,dll,exe,ico,shtm,shtml,fcg,fcgi,fpl,asmx,pht,py,psp<br>
Отсутствующие: dll,fcg,fcgi,fpl,asmx,pht,py,psp";}i:2;a:5:{s:5:"title";s:77:"Используются устаревшие модули платформы";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:55:"Доступны новые версии модулей";s:14:"recommendation";s:275:"Рекомендуется своевременно обновлять модули платформы, установить рекомендуемые обновления: <a href="/bitrix/admin/update_system.php" target="_blank">Обновление платформы</a>";s:15:"additional_info";s:84:"Модули для которых доступны обновления:<br>landing";}i:3;a:5:{s:5:"title";s:142:"Директория хранения файлов сессий доступна для всех системных пользователей";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:180:"Это может позволить читать/изменять сессионные данные, через скрипты других виртуальных серверов";s:14:"recommendation";s:265:"Корректно настроить файловые права или сменить директорию хранения либо включить хранение сессий в БД: <a href="/bitrix/admin/security_session.php">Защита сессий</a>";s:15:"additional_info";s:98:"Директория хранения сессий: /var/spool/sessions<br>
Права: drwxrwxrwt";}i:4;a:5:{s:5:"title";s:148:"Предположительно в директории хранения сессий находятся сессии других проектов";s:8:"critical";s:5:"HIGHT";s:6:"detail";s:180:"Это может позволить читать/изменять сессионные данные, через скрипты других виртуальных серверов";s:14:"recommendation";s:192:"Сменить директорию хранения либо включить хранение сессий в БД: <a href="/bitrix/admin/security_session.php">Защита сессий</a>";s:15:"additional_info";s:287:"Причина: владелец файла отличается от текущего пользователя<br>
Файл: /var/spool/sessions/sess_e737a3231aa8b81ea2f0df4f8ba7c9dc<br>
UID владельца файла: 2788<br>
UID текущего пользователя: 2903<br>";}i:5;a:5:{s:5:"title";s:119:"Временные файлы хранятся в пределах корневой директории проекта";s:8:"critical";s:6:"MIDDLE";s:6:"detail";s:271:"Хранение временных файлов, создаваемых при использовании CTempFile, в пределах корневой директории проекта не рекомендовано и несет с собой ряд рисков.";s:14:"recommendation";s:883:"Необходимо определить константу "BX_TEMPORARY_FILES_DIRECTORY" в "bitrix/php_interface/dbconn.php" с указанием необходимого пути.<br>
Выполните следующие шаги:<br>
1. Выберите директорию вне корня проекта. Например, это может быть "/home/bitrix/tmp/www"<br>
2. Создайте ее. Для этого выполните следующую комманду:
<pre>
mkdir -p -m 700 /полный/путь/к/директории
</pre>
3. В файле "bitrix/php_interface/dbconn.php" определите соответствующую константу, чтобы система начала использовать эту директорию:
<pre>
define("BX_TEMPORARY_FILES_DIRECTORY", "/полный/путь/к/директории");
</pre>";s:15:"additional_info";s:80:"Текущая директория: /home/user2046712/www/sbswine.by/upload/tmp";}i:6;a:5:{s:5:"title";s:68:"Разрешено чтение файлов по URL (URL wrappers)";s:8:"critical";s:6:"MIDDLE";s:6:"detail";s:256:"Если эта, сомнительная, возможность PHP не требуется - рекомендуется отключить, т.к. она может стать отправной точкой для различного типа атак";s:14:"recommendation";s:89:"Необходимо в настройках php указать:<br>allow_url_fopen = Off";s:15:"additional_info";s:0:"";}i:7;a:5:{s:5:"title";s:113:"Разрешено отображение сайта во фрейме с произвольного домена";s:8:"critical";s:6:"MIDDLE";s:6:"detail";s:307:"Запрет отображения фреймов сайта со сторонних доменов способен предотвратить целый класс атак, таких как <a href="https://www.owasp.org/index.php/Clickjacking" target="_blank">Clickjacking</a>, Framesniffing и т.д.";s:14:"recommendation";s:1875:"Скорее всего, вам будет достаточно разрешения на просмотр сайта в фреймах только на страницах текущего сайта.
Сделать это достаточно просто, достаточно добавить заголовок ответа "X-Frame-Options: SAMEORIGIN" в конфигурации вашего frontend-сервера.
</p><p>В случае использования nginx:<br>
1. Найти секцию server, отвечающую за обработку запросов нужного сайта. Зачастую это файлы в /etc/nginx/site-enabled/*.conf<br>
2. Добавить строку:
<pre>
add_header X-Frame-Options SAMEORIGIN;
</pre>
3. Перезапустить nginx<br>
Подробнее об этой директиве можно прочесть в документации к nginx: <a href="http://nginx.org/ru/docs/http/ngx_http_headers_module.html" target="_blank">Модуль ngx_http_headers_module</a>
</p><p>В случае использования Apache:<br>
1. Найти конфигурационный файл для вашего сайта, зачастую это файлы /etc/apache2/httpd.conf, /etc/apache2/vhost.d/*.conf<br>
2. Добавить строки:
<pre>
&lt;IfModule headers_module&gt;
	Header set X-Frame-Options SAMEORIGIN
&lt;/IfModule&gt;
</pre>
3. Перезапустить Apache<br>
4. Убедиться, что он корректно обрабатывается Apache и этот заголовок никто не переопределяет<br>
Подробнее об этой директиве можно прочесть в документации к Apache: <a href="http://httpd.apache.org/docs/2.2/mod/mod_headers.html" target="_blank">Apache Module mod_headers</a>
</p>";s:15:"additional_info";s:2187:"Адрес: <a href="https://sbswine.by/" target="_blank">https://sbswine.by/</a><br>Запрос/Ответ: <pre>GET / HTTP/1.1
host: sbswine.by
accept: */*
user-agent: BitrixCloud BitrixSecurityScanner/Robin-Scooter

HTTP/1.1 200 OK
Server: nginx/1.10.2
Date: Fri, 20 Jul 2018 13:35:22 GMT
Content-Type: text/html; charset=UTF-8
Transfer-Encoding: chunked
Connection: keep-alive
Keep-Alive: timeout=60
X-Powered-By: PHP/7.0.17
P3P: policyref=&quot;/bitrix/p3p.xml&quot;, CP=&quot;NON DSP COR CUR ADM DEV PSA PSD OUR UNR BUS UNI COM NAV INT DEM STA&quot;
X-Powered-CMS: Bitrix Site Manager (06d545b8b90fb7304d5c511e21fad5ea)
Set-Cookie: PHPSESSID=9eae5ea4b3a4c6632d9b89c31949ea8c; path=/; domain=sbswine.by; HttpOnly
Expires: Thu, 19 Nov 1981 08:52:00 GMT
Cache-Control: no-store, no-cache, must-revalidate
Pragma: no-cache


&lt;!DOCTYPE html&gt;
&lt;html lang=&quot;ru&quot;&gt;
&lt;head&gt;
&lt;link rel=&quot;canonical&quot; href=&quot;https://sbswine.by/&quot;/&gt;
&lt;!-- Yandex.Metrika counter --&gt;
&lt;noscript&gt;&lt;div&gt;&lt;img src=&quot;https://mc.yandex.ru/watch/48453539&quot; style=&quot;position:absolute; left:-9999px;&quot; alt=&quot;&quot; /&gt;&lt;/div&gt;&lt;/noscript&gt;
&lt;!-- /Yandex.Metrika counter --&gt;
&lt;!-- Yandex.Metrika counter --&gt;
&lt;noscript&gt;&lt;div&gt;&lt;img src=&quot;https://mc.yandex.ru/watch/48453539&quot; style=&quot;position:absolute; left:-9999px;&quot; alt=&quot;&quot; /&gt;&lt;/div&gt;&lt;/noscript&gt;
&lt;!-- /Yandex.Metrika counter --&gt;
&lt;!-- Global Site Tag (gtag.js) - Google Analytics --&gt;
&lt;!-- Global site tag (gtag.js) - Google Analytics --&gt;

    &lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=UTF-8&quot; /&gt;
&lt;meta name=&quot;keywords&quot; content=&quot;купить вино в минске&quot; /&gt;
&lt;meta name=&quot;description&quot; content=&quot;Сеть винных магазинов ВИНО от импортера в формате &amp;quot;У дома&amp;quot;, представляющая широкий выбор алкогольных напитков от крупнейших произво
----------Only 1Kb of body shown----------<pre>";}i:8;a:5:{s:5:"title";s:110:"Установлен не корректный порядок формирования массива _REQUEST";s:8:"critical";s:6:"MIDDLE";s:6:"detail";s:392:"Зачастую в массив _REQUEST нет необходимости добавлять любые переменные, кроме массивов _GET и _POST. В противном случае это может привести к раскрытию информации о пользователе/сайте и иным не предсказуемым последствиям.";s:14:"recommendation";s:88:"Необходимо в настройках php указать:<br>request_order = "GP"";s:15:"additional_info";s:75:"Текущее значение: ""<br>Рекомендованное: "GP"";}i:9;a:5:{s:5:"title";s:44:"Включен Automatic MIME Type Detection";s:8:"critical";s:3:"LOW";s:6:"detail";s:248:"По умолчанию в Internet Explorer/FlashPlayer включен автоматический mime-сниффинг, что может служить источником XSS нападения или раскрытия информации.";s:14:"recommendation";s:1752:"Скорее всего, вам не нужна эта функция, поэтому её можно безболезненно отключить, добавив заголовок ответа "X-Content-Type-Options: nosniff" в конфигурации вашего веб-сервера.
</p><p>В случае использования nginx:<br>
1. Найти секцию server, отвечающую за обработку запросов нужного сайта. Зачастую это файлы в /etc/nginx/site-enabled/*.conf<br>
2. Добавить строку:
<pre>
add_header X-Content-Type-Options nosniff;
</pre>
3. Перезапустить nginx<br>
Подробнее об этой директиве можно прочесть в документации к nginx: <a href="http://nginx.org/ru/docs/http/ngx_http_headers_module.html" target="_blank">Модуль ngx_http_headers_module</a>
</p><p>В случае использования Apache:<br>
1. Найти конфигурационный файл для вашего сайта, зачастую это файлы /etc/apache2/httpd.conf, /etc/apache2/vhost.d/*.conf<br>
2. Добавить строки:
<pre>
&lt;IfModule headers_module&gt;
	Header set X-Content-Type-Options nosniff
&lt;/IfModule&gt;
</pre>
3. Перезапустить Apache<br>
4. Убедиться, что он корректно обрабатывается Apache и этот заголовок никто не переопределяет<br>
Подробнее об этой директиве можно прочесть в документации к Apache: <a href="http://httpd.apache.org/docs/2.2/mod/mod_headers.html" target="_blank">Apache Module mod_headers</a>
</p>";s:15:"additional_info";s:1774:"Адрес: <a href="https://sbswine.by/bitrix/js/main/core/core.js?rnd=0.378440251455" target="_blank">https://sbswine.by/bitrix/js/main/core/core.js?rnd=0.378440251455</a><br>Запрос/Ответ: <pre>GET /bitrix/js/main/core/core.js?rnd=0.378440251455 HTTP/1.1
host: sbswine.by
accept: */*
user-agent: BitrixCloud BitrixSecurityScanner/Robin-Scooter

HTTP/1.1 200 OK
Server: nginx/1.10.2
Date: Fri, 20 Jul 2018 13:35:16 GMT
Content-Type: application/javascript
Content-Length: 125972
Connection: keep-alive
Keep-Alive: timeout=60
Accept-Ranges: bytes
Last-Modified: Fri, 20 Jul 2018 13:33:11 GMT
ETag: &quot;5b51e497-1ec14&quot;

if (typeof WeakMap === &quot;undefined&quot;)
{
	(function() {

		var counter = Date.now() % 1e9;

		var WeakMap = function(iterable)
		{
			this.name = &quot;__bx&quot; + (Math.random() * 1e9 &gt;&gt;&gt; 0) + counter++;
		};

		WeakMap.prototype =
		{
			set: function(key, value)
			{
				if (!this.isValid(key))
				{
					throw new TypeError(&quot;Invalid value used as weak map key&quot;);
				}

				var entry = key[this.name];
				if (entry &amp;&amp; entry[0] === key)
				{
					entry[1] = value;
				}
				else
				{
					Object.defineProperty(key, this.name, { value: [key, value], writable: true });
				}

				return this;
			},

			get: function(key)
			{
				if (!this.isValid(key))
				{
					return undefined;
				}

				var entry = key[this.name];

				return entry &amp;&amp; entry[0] === key ? entry[1] : undefined;
			},

			&quot;delete&quot;: function(key)
			{
				if (!this.isValid(key))
				{
					return false;
				}

				var entry = key[this.name];
				if (!entry)
				{
					return false;
				}
				var hasValue = entry[0] === key;
				entry[0] = entry[1] = u
----------Only 1Kb of body shown----------<pre>";}i:10;a:5:{s:5:"title";s:77:"Почтовые сообщения содержат UID PHP процесса";s:8:"critical";s:3:"LOW";s:6:"detail";s:356:"В каждом отправляемом письме добавляется заголовок X-PHP-Originating-Script, который содержит UID и имя скрипта отправляющего письмо. Это позволяет злоумышленнику узнать от какого пользователя работает PHP.";s:14:"recommendation";s:91:"Необходимо в настройках php указать:<br>mail.add_x_header = Off";s:15:"additional_info";s:0:"";}i:11;a:5:{s:5:"title";s:38:"Включен вывод ошибок";s:8:"critical";s:3:"LOW";s:6:"detail";s:202:"Вывод ошибок предназначен для разработки и тестовых стендов, он не должен использоваться на конечном ресурсе.";s:14:"recommendation";s:88:"Необходимо в настройках php указать:<br>display_errors = Off";s:15:"additional_info";s:0:"";}}s:9:"test_date";s:10:"20.07.2018";}}';
return true;
?>