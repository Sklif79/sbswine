<?
if(!$USER->IsAdmin()) return;

$module_id = 'webdebug.utilities';
CModule::IncludeModule($module_id);

IncludeModuleLangFile($_SERVER["DOCUMENT_ROOT"].BX_ROOT."/modules/main/options.php"); 
IncludeModuleLangFile(__FILE__);

$arAllOptions = Array(
	array(
		'NAME' => GetMessage('WDU_GENERAL'),
		'ITEMS' => array(
			array('global_main_functions', GetMessage('WDU_GLOBAL_MAIN_FUNCTIONS'), false, array('checkbox')),
			array('js_debug_functions', GetMessage('WDU_JS_DEBUG_FUNCTIONS'), false, array('checkbox')),
			array('set_admin_favicon', GetMessage('WDU_SET_ADMIN_FAVICON'), false, array('checkbox')),
			array('admin_favicon', GetMessage('WDU_ADMIN_FAVICON'), false, array('file')),
			array('pageprops_enabled', GetMessage('WDU_PAGEPROPS_ENABLED'), false, array('checkbox')),
		),
	),
	array(
		'NAME' => GetMessage('WDU_IBLOCK'),
		'ITEMS' => array(
			array('iblock_add_detail_link', GetMessage('WDU_IBLOCK_ADD_DETAIL_LINK'), false, array('checkbox')),
			array('iblock_show_element_id', GetMessage('WDU_IBLOCK_SHOW_ELEMENT_ID'), false, array('checkbox')),
			array('iblock_propsorter_enabled', GetMessage('WDU_IBLOCK_PROPSORTER_ENABLED'), false, array('checkbox')),
			array('iblock_rename_columns', GetMessage('WDU_IBLOCK_RENAME_COLUMNS'), false, array('checkbox')),
		),
	),
	array(
		'NAME' => GetMessage('WDU_FASTSQL'),
		'ITEMS' => array(
			array('fastsql_enabled', GetMessage('WDU_FASTSQL_ENABLED'), false, array('checkbox')),
			array('fastsql_auto_exec', GetMessage('WDU_FASTSQL_AUTO_EXEC'), false, array('select'), array('N'=>GetMessage('WDU_FASTSQL_AUTO_EXEC_N'),'Y'=>GetMessage('WDU_FASTSQL_AUTO_EXEC_Y'),'X'=>GetMessage('WDU_FASTSQL_AUTO_EXEC_X'))),
		),
	),
	array(
		'NAME' => GetMessage('WDU_MISC'),
		'ITEMS' => array(
			#array('', GetMessage(''), false, array('checkbox')),
		),
	),
);

$aTabs = array();
$aTabs[] = array("DIV" => "tab_general", "TAB" => GetMessage("WDU_TAB_GENERAL_NAME"), "TITLE" => GetMessage("WDU_TAB_GENERAL_DESC"));
$aTabs[] = array("DIV" => "tab_rights", "TAB" => GetMessage("WDU_TAB_RIGHTS_NAME"), "TITLE" => GetMessage("WDU_TAB_RIGHTS_DESC"));
$tabControl = new CAdminTabControl("tabControl", $aTabs);
if($REQUEST_METHOD=="POST" && strlen($Update.$Apply.$RestoreDefaults)>0 && check_bitrix_sessid()) {
	if(strlen($RestoreDefaults)>0) {
		$arGroups = array();
		$resGroups = CGroup::GetList($v1="id",$v2="asc", array("ACTIVE" => "Y", "ADMIN" => "N"));
		while($arGroup = $resGroups->GetNext(false,false)) {
			$arGroups[] = $arGroup["ID"];
		}
		$APPLICATION->DelGroupRight($module_id, $arGroups);
		COption::RemoveOption($module_id);
		LocalRedirect($_SERVER["REQUEST_URI"]);
	} else {
		for ($i=0; $i<10; $i++) {
			COption::SetOptionString($module_id, "vote_name_".$i, $_REQUEST["webdebug_votes"][$i], GetMessage("WD_REVIEWS2_VOTE_FIELD_NAME").$i);
		}
		foreach($arAllOptions as $arOptionGroup) {
			foreach($arOptionGroup['ITEMS'] as $arOption) {
				$name=$arOption[0];
				$val=$_REQUEST[$name];
				if($arOption[3][0]=="checkbox" && $val!="Y") $val="N";
				COption::SetOptionString($module_id, $name, $val, $arOption[1]);
			}
		}
	}
}
?>

<?if(CModule::IncludeModule($module_id)):?>
	<?$tabControl->Begin();?>
	<form method="post" action="<?echo $APPLICATION->GetCurPage()?>?mid=<?=urlencode($mid)?>&amp;lang=<?echo LANGUAGE_ID?>" id="webdebug-reviews-table">
		<?$tabControl->BeginNextTab();?>
		<?foreach($arAllOptions as $arOptionGroup):?>
			<?if(!is_array($arOptionGroup['ITEMS']) || empty($arOptionGroup['ITEMS'])){continue;}?>
			<tr class="heading"><td colspan="2"><?=$arOptionGroup['NAME'];?></td></tr>
			<?foreach($arOptionGroup['ITEMS'] as $arOption):?>
				<?
					$val = COption::GetOptionString($module_id, $arOption[0]);
					$OptionValues = $arOption[4];
					$type = $arOption[3];
				?>
				<tr>
					<td width="50%"><?
						if(in_array($type[0],array('checkbox','file','select')))
							echo "<label for=\"".htmlspecialchars($arOption[0])."\">".$arOption[1]."</label>";
						else
							echo $arOption[1];?>:</td>
					<td width="50%">
						<?if($type[0]=="checkbox"):?>
							<input type="checkbox" id="<?echo htmlspecialchars($arOption[0])?>" name="<?echo htmlspecialchars($arOption[0])?>" value="Y"<?if($val=="Y")echo" checked='checked'";?> />
						<?elseif($type[0]=="text"):?>
							<input type="text" size="<?echo $type[1]?>" maxlength="255" value="<?echo htmlspecialchars($val)?>" name="<?echo htmlspecialchars($arOption[0])?>" />
						<?elseif($type[0]=="select"):?>
							<select name="<?echo htmlspecialchars($arOption[0])?>">
								<?foreach ($OptionValues as $OptionValue => $OptionName):?>
									<option value="<?=$OptionValue?>"<?if($OptionValue==$val)echo" selected='selected'";?>><?=$OptionName?></option>
								<?endforeach?>
							</select>
						<?elseif($type[0]=="file"):?>
							<script>
							function WDU_<?=$arOption[0];?>_OnSelectFile(FileName,Path,Site){
								if (Path.length>1) {
									Path = Path + '/';
								}
								document.getElementById('<?=$arOption[0];?>').value = Path + FileName;
							}
							</script>
							<?
								$arDialogParams = array(
									'event' => 'WDU_'.$arOption[0].'_Open',
									'arResultDest' => array('FUNCTION_NAME' => 'WDU_'.$arOption[0].'_OnSelectFile'),
									'arPath' => array(),
									'select' => 'F',
									'operation' => 'O',
									'showUploadTab' => true,
									'showAddToMenuTab' => false,
									'fileFilter' => str_replace(' ','','ico,gif,png'),
									'allowAllFiles' => true,
									'saveConfig' => true,
								);
								CAdminFileDialog::ShowScript($arDialogParams);
							?>
							<input type="text" name="<?echo htmlspecialchars($arOption[0])?>" id="<?=$arOption[0];?>" value="<?=$val;?>" style="width:80%" />
							<input type="button" value="..." onclick="WDU_<?=$arOption[0];?>_Open()" />
						<?endif?>
					</td>
				</tr>
			<?endforeach?>
		<?endforeach?>
		<?$tabControl->BeginNextTab();?>
			<?require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/admin/group_rights.php");?>
		<?$tabControl->Buttons();?>
			<input type="submit" name="Update" value="<?=GetMessage("MAIN_SAVE")?>" class="adm-btn-save" />
			<input type="hidden" name="Update" value="Y" />
			<input type="submit" name="Apply" value="<?=GetMessage("MAIN_APPLY")?>" />
			<input type="submit" name="RestoreDefaults" value="<?=GetMessage("MAIN_RESET")?>" onclick="return confirm('<?=AddSlashes(GetMessage("MAIN_HINT_RESTORE_DEFAULTS_WARNING"))?>');" />
			<?if(strlen($_REQUEST["back_url_settings"])>0):?>
				<input type="hidden" name="back_url_settings" value="<?=htmlspecialchars($_REQUEST["back_url_settings"])?>">
			<?endif?>
			<?=bitrix_sessid_post();?>
		<?$tabControl->End();?>
	</form>
<?else:?>
	<p><?=GetMessage("WD_REVIEWS2_ERROR_MODULE_NOT_INCLUDED")?></p>
<?endif?>

<?
if($REQUEST_METHOD=="POST" && strlen($Update.$Apply.$RestoreDefaults)>0 && check_bitrix_sessid()) {
	if (strlen($Apply)>0) {
		LocalRedirect($_SERVER["REQUEST_URI"]."&".$tabControl->ActiveTabParam());
	} elseif (strlen($Update)>0 && strlen($_REQUEST["back_url_settings"])>0) {
		LocalRedirect($_REQUEST["back_url_settings"]);
	} else {
		LocalRedirect($APPLICATION->GetCurPage()."?mid=".urlencode($mid)."&lang=".urlencode(LANGUAGE_ID)."&back_url_settings=".urlencode($_REQUEST["back_url_settings"])."&".$tabControl->ActiveTabParam());
	}
}
?>