<?
global $DB, $DBType;
IncludeModuleLangFile(__FILE__);
define('WDU_MODULE', 'webdebug.utilities');

CModule::AddAutoloadClasses(
	WDU_MODULE,
	array(
		'CWDU_FastSQL' => 'classes/'.$DBType.'/CWDU_FastSQL.php',
		'CWDU_Options' => 'classes/'.$DBType.'/CWDU_Options.php',
		'CWDU_IBlockPropSorter' => 'classes/'.$DBType.'/CWDU_IBlockPropSorter.php',
		'CWDU_PageProps' => 'classes/'.$DBType.'/CWDU_PageProps.php',
		'CWDU_IBlockTools' => 'classes/'.$DBType.'/CWDU_IBlockTools.php',
		//
		'CWDU_Crontab' => 'classes/general/CWDU_Crontab.php',
		'CWDU_DirSize' => 'classes/'.$DBType.'/CWDU_DirSize.php',
	)
);

class CWD_Util {

	/**
	 *	Fast debug/output function
	 */
	function P($arData) {
		$strResult = '<style type="text/css">pre {background:none repeat scroll 0 0 #FAFAFA; border-color:#AAB4BE #AAB4BE #AAB4BE #B4B4B4; border-style:dotted dotted dotted solid; border-width:1px 1px 1px 20px; font:normal 11px monospace; margin:10px 0; padding:5px 0 5px 10px; position:relative; text-align:left; white-space:pre-wrap;}</style>';
		if (is_array($arData) && empty($arData)) $arData = '--- Array is empty ---';
		if ($arData===false) $arData = '(false)'; elseif ($arData===true) $arData = '(true)';
		if ($arData===null) $arData = '(null)';
		$strResult .= '<pre>'.print_r($arData,true).'</pre>';
		print $strResult;
	}

	/**
	 *	Fast save to log function
	 */
	function L($Message, $FileName=false){
		if (!is_string($FileName)) {
			if (defined('LOG_FILENAME') && strlen(LOG_FILENAME)) {
				$FileName = LOG_FILENAME;
			} else {
				$FileName = $_SERVER['DOCUMENT_ROOT'].'/!log_'.COption::GetOptionString('main','server_uniq_id').'.txt';
			}
		}
		if (is_array($Message)) {
			$Message = print_r($Message,1);
		}
		$handle = fopen($FileName, 'a+');
		@flock ($handle, LOCK_EX);
		fwrite ($handle, '['.date('d.m.Y H:i:s').'] '.$Message."\r\n");
		@flock ($handle, LOCK_UN);
		fclose($handle);
	}
	
	/**
	 *	Convert date to MySQL format
	 */
	function DateFormatToMySQL($Date) {
		$mResult = CDatabase::FormatDate($Date, FORMAT_DATETIME, 'YYYY-MM-DD HH:MI:SS');
		if ($mResult===false) {
			$mResult = '0000-00-00 00:00:00';
		}
		return $mResult;
	}

	/**
	 *	Check current directory
	 */
	function InDir($Dir) {
		global $APPLICATION;
		$CurDir = $APPLICATION->GetCurDir();
		return strpos($CurDir,$Dir)===0;
	}

	/**
	 *	Check current directories
	 */
	function InDirs($arDir) {
		if (is_array($arDir) && !empty($arDir)) {	
			foreach ($arDir as $Dir) {
				if (self::InDir($Dir)) {
					return true;
				}
			}
		}
		return false;
	}
	
	/**
	 *	Check if mainpage
	 */
	function IsMainpage() {
		global $APPLICATION;
		$CurDir = $APPLICATION->GetCurPage(true);
		return ($CurDir == SITE_DIR.'index.php');
	}

	/**
	 *	Check if 404 page
	 */
	function Is404() {
		return (defined('ERROR_404') && ERROR_404 === 'Y');
	}
	
	/**
	 *	Get bitrix site array
	 */
	function GetSitesList($OnlyID=false) {
		$arResult = array();
		$resSites = CSite::GetList($SiteBy='SORT',$SiteOrder='ASC');
		while ($arSite = $resSites->GetNext()) {
			$arResult[] = $OnlyID ? $arSite['ID'] : $arSite;
		}
		return $arResult;
	}
	
	/**
	 *	Check if bitrix works in UTF-8 mode
	 */
	function IsUtf8() {
		return defined('BX_UTF') && BX_UTF===true;
	}
	
	/**
	 *	Sort callback for SORT key
	 */
	function UASort_Sort($a,$b) {
		return $a['SORT']==$b['SORT'] ? 0 : ($a['SORT']<$b['SORT'] ? -1 : 1);
	}
	
	/**
	 *	Show error via CAdminMessage
	 */
	function AdminShowError($Message) {
		if (defined('ADMIN_SECTION')&&ADMIN_SECTION===true) {
			$Message = new CAdminMessage(array(
				'MESSAGE' => $Message,
				'TYPE' => 'ERROR',
			));
			print $Message->Show();
		} else {
			print '<div class="wdr2_error_text" style="color:red;">'.$Message.'</div>';
		}
	}

	/**
	 *	Show hint in admin section
	 */
	function AdminShowHint($Text) {
		$Code = ToLower(RandString(12));
		print '<span id="hint_'.$Code.'"></span><script>BX.hint_replace(BX("hint_'.$Code.'"), "'.str_replace('"','\"',$Text).'");</script>';
	}
	
	/**
	 *	Get word's form depending of value
	 */
	function WordForm($Value, $arWord) {
		$Value = trim($Value);
		$LastSymbol = substr($Value,-1);
		$SubLastSymbol = substr($Value,-2,1);
		if (strlen($Value)>=2 && $SubLastSymbol == '1') {
			return $arWord['5'];
		} else {
			if ($LastSymbol=='1')
				return $arWord['1'];
			elseif ($LastSymbol >= 2 && $LastSymbol <= 4)
				return $arWord['2'];
			else
				return $arWord['5'];
		}
	}
	
	/**
	 *	Analog to json_encode
	 */
	function JsonEncode( $data ) {            
		if( is_array($data) || is_object($data) ) { 
			$islist = is_array($data) && ( empty($data) || array_keys($data) === range(0,count($data)-1) );
			if( $islist ) { 
				$json = '[' . implode(',', array_map('self::JsonEncode', $data) ) . ']'; 
			} else { 
				$items = Array(); 
				foreach( $data as $key => $value ) { 
					$items[] = self::JsonEncode($key) . ':' . self::JsonEncode($value); 
				} 
				$json = '{' . implode(',', $items) . '}'; 
			} 
		} elseif( is_string($data) ) {
			$string = '"' . addcslashes($data, "\\\"\n\r\t/" . chr(8) . chr(12)) . '"'; 
			$json  = ''; 
			$len = strlen($string); 
			for( $i = 0; $i < $len; $i++ ) {
				$char = $string[$i]; 
				$c1 = ord($char); 
				if( $c1 <128 ) { 
					$json .= ($c1 > 31) ? $char : sprintf("\\u%04x", $c1); 
					continue; 
				}
				$c2 = ord($string[++$i]); 
				if ( ($c1 & 32) === 0 ) { 
					$json .= sprintf("\\u%04x", ($c1 - 192) * 64 + $c2 - 128); 
					continue; 
				}
				$c3 = ord($string[++$i]); 
				if( ($c1 & 16) === 0 ) { 
					$json .= sprintf("\\u%04x", (($c1 - 224) <<12) + (($c2 - 128) << 6) + ($c3 - 128)); 
					continue; 
				}
				$c4 = ord($string[++$i]); 
				if( ($c1 & 8 ) === 0 ) { 
					$u = (($c1 & 15) << 2) + (($c2>>4) & 3) - 1; 
					$w1 = (54<<10) + ($u<<6) + (($c2 & 15) << 2) + (($c3>>4) & 3); 
					$w2 = (55<<10) + (($c3 & 15)<<6) + ($c4-128); 
					$json .= sprintf("\\u%04x\\u%04x", $w1, $w2); 
				} 
			} 
		} else { 
			$json = strtolower(var_export( $data, true )); 
		} 
		return $json; 
	}
	
	function AddJsDebugFunctions() {
		global $APPLICATION;
		$FileName = $_SERVER['DOCUMENT_ROOT'].'/bitrix/js/'.WDU_MODULE.'/debug_functions.js';
		if (is_file($FileName)) {
			$JS = file_get_contents($FileName);
			$APPLICATION->AddHeadString('<script>'.$JS.'</script>');
		}
	}
	
}

class CWD_Util_Handler {
	
	function OnPageStart() {
		global $APPLICATION;
		define('WDU_CURPAGE', $APPLICATION->GetCurPage());
		if (WDU_CURPAGE=='/bitrix/admin/settings.php' && $_GET['mid']=='fileman') {
			$PageProps_Enabled = COption::GetOptionString(WDU_MODULE, 'pageprops_enabled')=='Y';
			if ($PageProps_Enabled) {
				CWDU_PageProps::OnPageStart_Handler();
			}
		}
		if (COption::GetOptionString(WDU_MODULE,'js_debug_functions')=='Y') {
			CWD_Util::AddJsDebugFunctions();
		}
	}
	
	function OnEpilog() {
		global $APPLICATION;
		if (WDU_CURPAGE=='/bitrix/admin/iblock_edit.php' && $_GET['ID']>0) {
			$IBlockPropSorter_Enabled = COption::GetOptionString(WDU_MODULE, 'iblock_propsorter_enabled')=='Y';
			if ($IBlockPropSorter_Enabled) {
				CWDU_IBlockPropSorter::OnEpilog_Handler();
			}
		}
		if (defined('ADMIN_SECTION') && ADMIN_SECTION===true) {
			$SetAdminFavIcon = COption::GetOptionString(WDU_MODULE, 'set_admin_favicon')=='Y';
			if ($SetAdminFavIcon) {
				$AdminFavIcon = COption::GetOptionString(WDU_MODULE, 'admin_favicon');
				$APPLICATION->AddHeadString('<link rel="icon" href="'.$AdminFavIcon.'" type="image/x-icon" />');
				$APPLICATION->AddHeadString('<link rel="shortcut icon" href="'.$AdminFavIcon.'" type="image/x-icon" />');
			}
		}
	}
	
	function OnEndBufferContent(&$Content) {
		global $APPLICATION;
		if (in_array(WDU_CURPAGE, array('/bitrix/admin/public_file_property.php','/bitrix/admin/public_folder_edit.php')) || (WDU_CURPAGE=='/bitrix/admin/settings.php' && $_GET['mid']=='fileman')) {
			$PageProps_Enabled = COption::GetOptionString(WDU_MODULE, 'pageprops_enabled')=='Y';
			if ($PageProps_Enabled) {
				CWDU_PageProps::OnEndBufferContent_Handler($Content);
			}
		}
	}
	
	function OnAdminContextMenuShow(&$arMenuItems) {
		if (WDU_CURPAGE=='/bitrix/admin/iblock_element_edit.php' && $_GET['IBLOCK_ID']>0 && $_GET['ID']>0) {
			$AddDetailLink = COption::GetOptionString(WDU_MODULE, 'iblock_add_detail_link')=='Y';
			if ($AddDetailLink) {
				CWDU_IBlockTools::AddContextDetailLink($arMenuItems);
			}
		}
	}
	
	function OnAdminTabControlBegin(&$obTabControl) {
		if (WDU_CURPAGE=='/bitrix/admin/sql.php') {
			$FastSQL_Enabled = COption::GetOptionString(WDU_MODULE, 'fastsql_enabled')=='Y';
			if ($FastSQL_Enabled) {
				CWDU_FastSQL::OnAdminTabControlBegin_Handler($obTabControl);
			}
		}
		if (WDU_CURPAGE=='/bitrix/admin/iblock_element_edit.php' && $_GET['ID']>0) {
			$ShowElementID = COption::GetOptionString(WDU_MODULE, 'iblock_show_element_id')=='Y';
			if ($ShowElementID) {
				CWDU_IBlockTools::DisplayElementIDInTabControlButtons($obTabControl);
			}
		}
	}
	
	function OnAdminListDisplay(&$List) {
		$arURL = array(
			'/bitrix/admin/iblock_list_admin.php',
			'/bitrix/admin/iblock_element_admin.php',
		);
		if(in_array(WDU_CURPAGE,$arURL)) {
			$RenameColumns = COption::GetOptionString(WDU_MODULE, 'iblock_rename_columns')=='Y';
			if ($RenameColumns) {
				CWDU_IBlockTools::RenameColumnsOnAdminListDisplay($List);
			}
		}
	}
	
	function OnAfterIBlockUpdate($arFields) {
		if (WDU_CURPAGE=='/bitrix/admin/iblock_edit.php' && $arFields['ID']>0) {
			$IBlockPropSorter_Enabled = COption::GetOptionString(WDU_MODULE, 'iblock_propsorter_enabled')=='Y';
			if ($IBlockPropSorter_Enabled) {
				CWDU_IBlockPropSorter::OnAfterIBlockUpdate_Handler($arFields);
			}
		}
	}
	
	function OnIBlockDelete($IBlockID) {
		if ($IBlockID>0) {
			CWDU_IBlockTools::DeleteColumnNamesData($IBlockID);
		}
	}
	
	function OnAfterIBlockDelete($IBlockID) {
		if ($IBlockID>0) {
			CWDU_IBlockTools::DeleteColumnNamesData($IBlockID);
		}
	}
	
}

if (COption::GetOptionString(WDU_MODULE,'global_main_functions')=='Y') {
	if (!function_exists('P')) {
		function P($arData){
			CWD_Util::P($arData);
		}
	}
	if (!function_exists('L')) {
		function L($Message, $FileName=false){
			CWD_Util::L($Message, $FileName);
		}
	}
}

?>