<?$APPLICATION->IncludeComponent(
	"bitrix:voting.current", 
	"main_page", 
	array(
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "N",
		"CACHE_TIME" => "3600000",
		"CACHE_TYPE" => "A",
		"CHANNEL_SID" => "3",
		"VOTE_ALL_RESULTS" => "Y",
		"VOTE_ID" => "3",
		"COMPONENT_TEMPLATE" => "main_page"
	),
	false
);?>