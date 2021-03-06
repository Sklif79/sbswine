<?
IncludeModuleLangFile(__FILE__);

class CWDU_Pageprop_TextArea extends CWDU_PagePropsAll {
	CONST CODE = 'TEXTAREA';
	CONST NAME = '��������� �������';
	function GetName() {
		$Name = self::NAME;
		if (CWDU_PageProps::IsUtf8()) {
			$Name = $GLOBALS['APPLICATION']->ConvertCharset($Name, 'CP1251', 'UTF-8');
		}
		return $Name;
	}
	function GetCode() {
		return self::CODE;
	}
	function GetMessage($Item) {
		$arMess = array(
			'OPTION_COLUMN_PARAM' => '��������',
			'OPTION_COLUMN_VALUE' => '��������',
			'OPTION_COLS' => '���-�� ��������',
			'OPTION_ROWS' => '���-�� �����',
			'OPTION_RESIZE_Y' => '������ ������������ � ������',
			'OPTION_RESIZE_X' => '������ ������������ � ������',
			'OPTION_RESIZE_FULL' => '�������������� ������������ �� ��� ������',
		);
		$strResult = $arMess[$Item];
		if (CWDU_PageProps::IsUtf8()) {
			$strResult = $GLOBALS['APPLICATION']->ConvertCharset($strResult, 'CP1251', 'UTF-8');
		}
		return $strResult;
	}
	function ShowSettings($PropertyCode) {
		$arFilter = CWDU_PageProps::GetFilter($PropertyCode, $SiteID);
		$resCurrentProp = CWDU_PageProps::GetList(false,$arFilter);
		if ($arCurrentItem = $resCurrentProp->GetNext()) {
			$arCurrentItem = self::TransformItem($arCurrentItem);
		}
		if (!is_array($arCurrentItem['DATA'])) {
			$arCurrentItem['DATA'] = array();
		}
		$arSites = CWDU_PageProps::GetSites();
		ob_start();
		?>
			<style>
			#wd_pageprops_settings_textarea .adm-list-table-cell {padding-left:12px; padding-right:12px;}
			#wd_pageprops_settings_textarea input[type=text] {width:100%; -moz-box-sizing:border-box; -webkit-box-sizing:border-box; box-sizing:border-box;}
			</style>
			<div id="wd_pageprops_settings_filesite">
				<table class="adm-list-table">
					<tbody>
						<tr class="adm-list-table-header">
							<td class="adm-list-table-cell" style="width:40%;">
								<div class="adm-list-table-cell-inner"><?=self::GetMessage('OPTION_COLUMN_PARAM');?></div>
							</td>
							<td class="adm-list-table-cell">
								<div class="adm-list-table-cell-inner"><?=self::GetMessage('OPTION_COLUMN_VALUE');?></div>
							</td>
						</tr>
						<tr class="adm-list-table-row">
							<td class="adm-list-table-cell align-right adm-detail-valign-middle">
								<label for="wd_propspage_textarea_cols"><?=self::GetMessage('OPTION_COLS');?>:</label>
							</td>
							<td class="adm-list-table-cell align-left">
								<input type="text" name="data[cols]" id="wd_propspage_textarea_cols" value="<?=$arCurrentItem['DATA']['cols'];?>" size="50" />
							</td>
						</tr>
						<tr class="adm-list-table-row">
							<td class="adm-list-table-cell align-right adm-detail-valign-middle">
								<label for="wd_propspage_textarea_rows"><?=self::GetMessage('OPTION_ROWS');?>:</label>
							</td>
							<td class="adm-list-table-cell align-left">
								<input type="text" name="data[rows]" id="wd_propspage_textarea_rows" value="<?=$arCurrentItem['DATA']['rows'];?>" size="50" />
							</td>
						</tr>
						<tr class="adm-list-table-row">
							<td class="adm-list-table-cell align-right adm-detail-valign-middle">
								<label for="wd_propspage_textarea_resize_y"><?=self::GetMessage('OPTION_RESIZE_Y');?>:</label>
							</td>
							<td class="adm-list-table-cell align-left">
								<input type="checkbox" name="data[resize_y]" id="wd_propspage_textarea_resize_y" value="Y"<?if($arCurrentItem['DATA']['resize_y']=='Y'):?> checked="checked"<?endif?> />
							</td>
						</tr>
						<tr class="adm-list-table-row">
							<td class="adm-list-table-cell align-right adm-detail-valign-middle">
								<label for="wd_propspage_textarea_resize_x"><?=self::GetMessage('OPTION_RESIZE_X');?>:</label>
							</td>
							<td class="adm-list-table-cell align-left">
								<input type="checkbox" name="data[resize_x]" id="wd_propspage_textarea_resize_x" value="Y"<?if($arCurrentItem['DATA']['resize_x']=='Y'):?> checked="checked"<?endif?> />
							</td>
						</tr>
						<tr class="adm-list-table-row">
							<td class="adm-list-table-cell align-right adm-detail-valign-middle">
								<label for="wd_propspage_textarea_resize_full"><?=self::GetMessage('OPTION_RESIZE_FULL');?>:</label>
							</td>
							<td class="adm-list-table-cell align-left">
								<input type="checkbox" name="data[resize_full]" id="wd_propspage_textarea_resize_full" value="Y"<?if($arCurrentItem['DATA']['resize_full']=='Y'):?> checked="checked"<?endif?> />
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		<?
		return ob_get_clean();
	}
	function SaveSettings($PropertyCode, $SiteID, $arPost) {
		$arData = $arPost['data'];
		$arFields = array(
			'PROPERTY' => $PropertyCode,
			'SITE' => $SiteID,
			'TYPE' => self::GetCode(),
			'DATA' => serialize($arData),
		);
		$arFilter = CWDU_PageProps::GetFilter($PropertyCode, $SiteID);
		$resCurrentProp = CWDU_PageProps::GetList(false,$arFilter);
		if ($arCurrentItem = $resCurrentProp->GetNext(false,false)) {
			if (CWDU_PageProps::Update($arCurrentItem['ID'], $arFields)) {
				return true;
			}
		} else {
			if (CWDU_PageProps::Add($arFields)) {
				return true;
			}
		}
		return false;
	}
	function TransformItem($arItem) {
		$arItem['DATA'] = @unserialize($arItem['~DATA']);
		if (!is_array($arItem['DATA'])) {
			$arItem['DATA'] = array();
		}
		foreach($arItem['DATA'] as $Key => $arOption) {
			if ($Key=='') {
				unset($arItem['DATA'][$Key]);
			}
		}
		return $arItem;
	}
	function ShowControls($arItem, $PropertyCode, $PropertyID, $PropertyValue, $SiteID) {
		$arItem = self::TransformItem($arItem);
		if ($arItem['DATA']['resize_y']=='Y' && $arItem['DATA']['resize_x']!='Y') {
			$Resize = 'vertical';
		} elseif ($arItem['DATA']['resize_y']!='Y' && $arItem['DATA']['resize_x']=='Y') {
			$Resize = 'horizontal';
		} elseif ($arItem['DATA']['resize_y']=='Y' && $arItem['DATA']['resize_x']=='Y') {
			$Resize = 'both';
		} else {
			$Resize = 'none';
		}
		ob_start();
		?>
			<textarea name="PROPERTY[<?=$PropertyID;?>][VALUE]" cols="<?=$arItem['DATA']['cols'];?>" rows="<?=$arItem['DATA']['rows'];?>" data-resize="<?=$Resize?>" style="overflow:auto; resize:<?=$Resize;?>;<?if($arItem['DATA']['resize_full']=='Y'):?> width:90%;<?endif?>"><?=$PropertyValue;?></textarea>
		<?
		$strResult = ob_get_clean();
		return $strResult;
	}
}

?>