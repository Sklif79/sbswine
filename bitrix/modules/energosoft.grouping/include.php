<?
######################################################
# Name: energosoft.grouping                          #
# File: include.php                                  #
# (c) 2005-2012 Energosoft, Maksimov M.A.            #
# Dual licensed under the MIT and GPL                #
# http://energo-soft.ru/                             #
# mailto:support@energo-soft.ru                      #
######################################################
?>
<?
class ESGroupProperty
{
	public static function SetDefault(&$arParams, $name, $value)
	{
		if(is_int($value))
		{
			if(isset($arParams[$name])) $arParams[$name] = intval($arParams[$name]);
			else $arParams[$name] = intval($value);
		}
		if(is_float($value))
		{
			if(isset($arParams[$name])) $arParams[$name] = floatval($arParams[$name]);
			else $arParams[$name] = floatval($value);
		}
		if(is_string($value))
		{
			if(isset($arParams[$name])) $arParams[$name] = strval($arParams[$name]);
			else $arParams[$name] = strval($value);
		}
		if(is_bool($value))
		{
			if(isset($arParams[$name]))
			{
				if($arParams[$name] == "Y") $arParams[$name] = "true";
				if($arParams[$name] == "N") $arParams[$name] = "false";
				if($arParams[$name] == "") $arParams[$name] = "false";
			}
			else
			{
				if($value) $arParams[$name] = "true";
				else $arParams[$name] = "false";
			}
		}
	}

	public static function CheckIBlockID(&$arParams, $name)
	{
		if(is_array($arParams[$name]))
		{
			foreach($arParams[$name] as $k=>$v)
			{
				$v = intval($v);
				if($v <= 0) unset($arParams[$name][$k]);
				else $arParams[$name][$k] = $v;
			}
			if(!count($arParams[$name])) $arParams[$name] = 0;
		}
		else $arParams[$name] = intval($arParams[$name]);
	}
}
?>