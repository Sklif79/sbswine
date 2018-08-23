<?
######################################################
# Name: energosoft.grouping                          #
# File: index.php                                    #
# (c) 2005-2012 Energosoft, Maksimov M.A.            #
# Dual licensed under the MIT and GPL                #
# http://energo-soft.ru/                             #
# mailto:support@energo-soft.ru                      #
######################################################
?>
<?
IncludeModuleLangFile(__FILE__);

class energosoft_grouping extends CModule
{
	var $MODULE_ID = "energosoft.grouping";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;

	function energosoft_grouping()
	{        		
		$arModuleVersion = array();
		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));
		include($path."/version.php");

		$this->MODULE_VERSION = $arModuleVersion["VERSION"];
		$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		$this->PARTNER_NAME = GetMessage("ES_COMPANY_NAME");
		$this->PARTNER_URI = "http://energo-soft.ru/";
		$this->MODULE_NAME = GetMessage("ES_MODULE_NAME");
		$this->MODULE_DESCRIPTION = GetMessage("ES_MODULE_DESCRIPTION");
		return true;
	}

	function DoInstall()
	{
		CopyDirFiles(
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/".$this->MODULE_ID."/install/components",
			$_SERVER["DOCUMENT_ROOT"]."/bitrix/components/energosoft", true, true);
		RegisterModule($this->MODULE_ID);
	}

	function DoUninstall()
	{
		DeleteDirFilesEx("/bitrix/components/energosoft/energosoft.group_property");
		DeleteDirFilesEx("/bitrix/components/energosoft/energosoft.group_property_manual");
		UnRegisterModule($this->MODULE_ID);
	}
}
?>