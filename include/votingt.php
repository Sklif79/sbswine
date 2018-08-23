<?$APPLICATION->IncludeComponent("bitrix:voting.current", "main_page", Array(
					"AJAX_MODE" => "N",	// Включить режим AJAX
					"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
					"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
					"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
					"AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
					"CACHE_TIME" => "3600000",	// Время кеширования (сек.)
					"CACHE_TYPE" => "A",	// Тип кеширования
					"CHANNEL_SID" => "-",	// Группа опросов
					"VOTE_ALL_RESULTS" => "Y",	// Показывать варианты ответов для полей типа Text и Textarea
					"VOTE_ID" => "2",	// ID опроса
					"COMPONENT_TEMPLATE" => "main_page.green"
				),
					false
				);?>