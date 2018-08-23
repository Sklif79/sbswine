<?
IncludeModuleLangFile(__FILE__);

class CWDU_IBlockTools {
	const TableIBlockColumns = 'b_wdu_iblock_columns';
	
	function AddContextDetailLink(&$arMenuItems) {
		if (is_array($arMenuItems)) {
			foreach($arMenuItems as $Key => $arMenuItem) {
				if (is_array($arMenuItem['MENU']) && $arMenuItem['ICON']=='btn_new') {
					$resItem = CIBlockElement::GetList(array(),array('IBLOCK_ID'=>$_GET['IBLOCK_ID'],'ID'=>$_GET['ID']),false,false,array('DETAIL_PAGE_URL'));
					if ($arItem = $resItem->GetNext(false,false)) {
						if (strlen($arItem['DETAIL_PAGE_URL'])) {
							$arMenuItems[$Key]['MENU'][] = array(
								'TEXT' => GetMessage('WDU_SHOW_ON_SITE'),
								'ACTION' => 'window.open("'.$arItem['DETAIL_PAGE_URL'].'");',
								'ICON' => 'view',
							);
						}
					}
					break;
				}
			}
		}
	}
	function DisplayElementIDInTabControlButtons(&$obTabControl) {
		if(defined('BX_PUBLIC_MODE')) {
			?>
			<script>
			BX.ready(function(){
				setTimeout(function(){
					if(document.getElementsByClassName) {
						var Div = document.getElementsByClassName('bx-core-adm-dialog-buttons');
					} else {
						var Div = document.querySelectorAll('.bx-core-adm-dialog-buttons');
					}
					if (Div.length==1) {
						var TmpDiv = document.createElement('div');
						TmpDiv.innerHTML = '<b>ID</b>: <?=$_GET['ID'];?>';
						while(TmpDiv.firstChild) {
								Div[0].appendChild(TmpDiv.firstChild);
						}
					}
				},250);
			});
			</script>
			<?
		} elseif (preg_match('#form_element_(\d+)#',$obTabControl->name)) {
			$obTabControl->sButtonsContent .= '<b>ID</b>: '.$_GET['ID'];
		}
	}
	function GetIBlockList() {
		$arResult = array();
		if (CModule::IncludeModule("iblock")) {
			// Get IBlock types
			$resIBlockTypes = CIBlockType::GetList(array(),array());
			while ($arIBlockType = $resIBlockTypes->GetNext(false,false)) {
				$arIBlockTypeLang = CIBlockType::GetByIDLang($arIBlockType["ID"], LANGUAGE_ID, false);
				$arResult[$arIBlockType["ID"]] = array(
					"NAME" => $arIBlockTypeLang["NAME"],
					"ITEMS" => array(),
				);
			}
			// Get IBlocks
			$arFilter = array();
			$arFilter["ACTIVE"] = "Y";
			$resIBlock = CIBlock::GetList(array("SORT"=>"ASC"),$arFilter);
			while ($arIBlock = $resIBlock->GetNext(false,false)) {
				$arResult[$arIBlock["IBLOCK_TYPE_ID"]]["ITEMS"][] = $arIBlock;
			}
		}
		return $arResult;
	}
	/**
	 *	Get array of fields, properties, catalog data, prices
	 *	@param mixed $IBlockID IBlock ID
	 */
	function GetIBlockFields($IBlockID=false) {
		$arResult = array();
		// Get fields
		$arResult['FIELDS'] = array();
		if (CModule::IncludeModule("iblock")) {
			$arFields = array(
				'NAME',
				'ACTIVE',
				'SORT',
				'CODE',
				'EXTERNAL_ID',
				'TIMESTAMP_X',
				'USER_NAME',
				'DATE_CREATE',
				'CREATED_USER_NAME',
				'ID',
				'ELEMENT_CNT',
				'SECTION_CNT',
				'DATE_ACTIVE_FROM',
				'DATE_ACTIVE_TO',
				'SHOW_COUNTER',
				'SHOW_COUNTER_START',
				'PREVIEW_PICTURE',
				'PREVIEW_TEXT',
				'DETAIL_PICTURE',
				'DETAIL_TEXT',
				'TAGS',
			);
			foreach($arFields as $strField) {
				$arResult['FIELDS'][$strField] = GetMessage('WEBDEBUG_COLUMNRENAMER_FIELD_'.$strField);
			}
		}
		// Get properties
		$arResult['PROPERTIES'] = array();
		if($IBlockID>0) {
			$resProps = CIBlockProperty::GetList(array('SORT'=>'ASC','ID'=>'ASC'),array('IBLOCK_ID'=>$IBlockID,'ACTIVE'=>'Y'));
			while ($arProp = $resProps->GetNext(false,false)) {
				$arResult['PROPERTIES']['PROPERTY_'.$arProp['ID']] = $arProp['NAME'];
			}
		}
		// ToDo: catalog data
		// ToDo: price data
		return $arResult;
	}
	/**
	 *	Handler for OnAdminListDisplay
	 */
	function RenameColumnsOnAdminListDisplay(&$List) {
		$IBlockID = IntVal($_GET['IBLOCK_ID']);
		if (is_object($List) && $IBlockID>0) {
			$arData = CWDU_IBlockTools::LoadColumnNamesData($IBlockID, true);
			if (!is_array($arData)) $arData = array();
			if (!empty($arData)) {
				foreach($arData as $strGroupCode => $arGroup) {
					if (is_array($arGroup)) {
						foreach($arGroup as $strCode => $strName) {
							if ($strName!='') {
								if (is_array($List->aHeaders[$strCode])) {
									$List->aHeaders[$strCode]['content'] = $strName;
								}
								if (is_array($List->aVisibleHeaders[$strCode])) {
									$List->aVisibleHeaders[$strCode]['content'] = $strName;
								}
							}
						}
					}
				}
			}
		}
		$List->context->additional_items[] = array(
			'TEXT' => GetMessage('WDU_CONTEXT_RENAME_COLUMNS'),
			'TITLE' => GetMessage('WDU_CONTEXT_RENAME_COLUMNS_DESC'),
			'ONCLICK' => 'window.open("/bitrix/admin/wdu_iblock_columns.php?IBLOCK_ID='.$IBlockID.'&lang='.LANGUAGE_ID.'");',
			'GLOBAL_ICON' => 'adm-menu-rename'
		);
	}
	function SaveColumnNamesData($IBlockID, $arData) {
		global $DB;
		$IBlockID = IntVal($IBlockID);
		if ($IBlockID<=0) {
			return false;
		}
		$strData = serialize($arData);
		$strData = $DB->ForSQL($strData);
		$TableName = self::TableIBlockColumns;
		$SQL = "SELECT * FROM `{$TableName}` WHERE `IBLOCK_ID`='{$IBlockID}';";
		$resItem = $DB->Query($SQL);
		if ($arItem = $resItem->GetNext(false,false)) {
			$SQL = "UPDATE `{$TableName}` SET `DATA`='{$strData}' WHERE `IBLOCK_ID`='{$IBlockID}';";
		} else {
			$SQL = "INSERT INTO `{$TableName}` (`IBLOCK_ID`,`DATA`) VALUES ('{$IBlockID}','{$strData}');";
		}
		$resUpdate = $DB->Query($SQL);
		return $resUpdate->result===true;
	}
	function LoadColumnNamesData($IBlockID=false, $SelectedOnly=false) {
		global $DB;
		if (!is_array($GLOBALS['WDU_IBLOCK_COLUMN_NAMES'])) {
			$arResult = array();
			$TableName = self::TableIBlockColumns;
			$arIBlocksID = array();
			$arIBlocksAll = self::GetIBlockList();
			foreach($arIBlocksAll as $IBlockType) {
				if (is_array($IBlockType['ITEMS'])) {
					foreach($IBlockType['ITEMS'] as $arIBlock) {
						$arIBlocksID[] = $arIBlock['ID'];
					}
				}
			}
			$Where = '';
			if ($SelectedOnly) {
				$Where = " WHERE `IBLOCK_ID`='{$IBlockID}'";
			}
			$SQL = "SELECT * FROM `{$TableName}`{$Where} ORDER BY `IBLOCK_ID`;";
			$resItem = $DB->Query($SQL);
			while ($arItem = $resItem->GetNext()) {
				if (!in_array($arItem['IBLOCK_ID'],$arIBlocksID)) {
					continue;
				}
				$arData = unserialize($arItem['~DATA']);
				if (is_array($arData)) {
					$arResult[$arItem['IBLOCK_ID']] = $arData;
				}
			}
			$GLOBALS['WDU_IBLOCK_COLUMN_NAMES'] = $arResult;
		}
		if (is_array($GLOBALS['WDU_IBLOCK_COLUMN_NAMES'])) {
			if ($IBlockID>0) {
				$arData = $GLOBALS['WDU_IBLOCK_COLUMN_NAMES'][$IBlockID];
				if (!is_array($arData)) {
					$arData = false;
				}
				return $arData;
			} else {
				return $GLOBALS['WDU_IBLOCK_COLUMN_NAMES'];
			}
		}
		return false;
	}
	function DeleteColumnNamesData($IBlockID) {
		if ($IBlockID>0) {
			global $DB;
			$TableName = self::TableIBlockColumns;
			$SQL = "DELETE FROM `{$TableName}` WHERE `IBLOCK_ID`='{$IBlockID}';";
			$DB->Query($SQL, true);
		}
	}
}

?>