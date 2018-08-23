<?
$ModuleID = 'webdebug.utilities';
require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_before.php");
require_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/'.$ModuleID.'/prolog.php');
if (!CModule::IncludeModule($ModuleID)) {
	die('Module is not found!');
}
IncludeModuleLangFile(__FILE__);

$ModuleRights = $APPLICATION->GetGroupRight($ModuleID);
if($ModuleRights=="D") {
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
}

// Save data
if (isset($_POST["save"]) && trim($_POST["save"])!="" || isset($_POST["apply"]) && trim($_POST["apply"])!="") {
	if (is_array($_POST['data']) && !empty($_POST['data'])) {
		foreach($_POST['data'] as $IBlockID => $arData) {
			CWDU_IBlockTools::SaveColumnNamesData($IBlockID, $arData);
		}
		LocalRedirect($APPLICATION->GetCurPageParam('IBLOCK_ID='.IntVal($_POST['IBLOCK_ID']),array('IBLOCK_ID')));
	}
}

$ModuleRights = $APPLICATION->GetGroupRight("webdebug.columnrenamer");
if($ModuleRights=="D") {
	$APPLICATION->AuthForm(GetMessage("ACCESS_DENIED"));
}

$APPLICATION->SetTitle(GetMessage('WD_COLUMNRENAMER_PAGE_TITLE'));
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_admin_after.php");

$arTabs[] = array("DIV"=>"general", "TAB"=>GetMessage("WD_COLUMNRENAMER_TAB_GENERAL_NAME"), "TITLE"=>GetMessage("WD_COLUMNRENAMER_TAB_GENERAL_DESC"));
CJSCore::Init(array('jquery'));

$intCurrentIBlockID = IntVal($_GET['IBLOCK_ID']);
$arIBlockList = CWDU_IBlockTools::GetIBlockList();

// Load data
$arSavedData = CWDU_IBlockTools::LoadColumnNamesData();
foreach($arIBlockList as $IBlockTypeKey => $arIBlockType) {
	foreach($arIBlockType['ITEMS'] as $Key => $arIBlock) {
		$arIBlockList[$IBlockTypeKey]['ITEMS'][$Key]['DATA'] = $arSavedData[$arIBlock['ID']];
	}
}

?>

<form method="post" action="<?=$_SERVER['REQUEST_URI']?>" name="post_form" id="wd_columnrenamer_form">
	<?$TabControl = new CAdminTabControl("WDColumnRenamer", $arTabs);?>
	<?$TabControl->Begin();?>
	<?$TabControl->BeginNextTab();?>
	<tr>
		<td>
			<div id="wd_iblock_list">
				<select>
					<option value=""><?=GetMessage('WD_COLUMNRENAMER_SELECT_NO');?></option>
					<?foreach($arIBlockList as $IBlockTypeKey => $arIBlockType):?>
						<optgroup label="<?=$arIBlockType['NAME'];?>">
							<?foreach($arIBlockType['ITEMS'] as $arIBlock):?>
								<option value="<?=$arIBlock['ID'];?>"<?if($intCurrentIBlockID==$arIBlock['ID']):?> selected="selected"<?endif?>>[<?=$arIBlock['ID'];?>] <?=$arIBlock['NAME'];?></option>
							<?endforeach?>
						</optgroup>
					<?endforeach?>
				</select>
			</div>
			<script>
			$('#wd_iblock_list select').change(function(){
				var Value = $(this).val();
				if (Value=='') {
					$('#wd_iblock_data_no').show();
					$('.wd_iblock_data').hide();
				} else if (Value>0) {
					$('.wd_iblock_data').hide();
					$('#wd_iblock_data_no').hide();
					$('#wd_iblock'+Value+'_data').show();
				}
				$('#wd_columnrenamer_iblock_id').val(Value);
			}).change();
			</script>
			<div id="wd_iblock_data_wrapper">
				<br/>
				<?if(!$intCurrentIBlockID>0):?><div id="wd_iblock_data_no"></div><?endif?>
				<?foreach($arIBlockList as $IBlockTypeKey => $arIBlockType):?>
					<?foreach($arIBlockType['ITEMS'] as $arIBlock):?>
						<?$arColumns = CWDU_IBlockTools::GetIBlockFields($arIBlock['ID']);?>
						<div class="wd_iblock_data" id="wd_iblock<?=$arIBlock['ID'];?>_data"<?if($intCurrentIBlockID!=$arIBlock['ID']):?> style="display:none"<?endif?>>
							<?foreach($arColumns as $strGroupCode => $arGroup):?>
								<h3><?=GetMessage('WD_COLUMNRENAMER_GROUP_'.$strGroupCode);?></h3>
								<table cellpadding="3" cellspacing="1" border="0" width="100%" class="internal">
									<thead>
										<tr class="heading">
											<td class="column" style="width:30%;"><?=GetMessage('WD_COLUMNRENAMER_TABLE_COLUMN');?></td>
											<td class="name"><?=GetMessage('WD_COLUMNRENAMER_TABLE_NAME');?></td>
										</tr>
									</thead>
									<tbody>
										<?foreach($arGroup as $strCode => $strName):?>
											<tr>
												<td class="column" style="text-align:right;"><?=$strName;?>:</td>
												<td class="name"><input type="text" name="data[<?=$arIBlock['ID'];?>][<?=$strGroupCode;?>][<?=$strCode;?>]" value="<?=$arIBlock['DATA'][$strGroupCode][$strCode];?>" /></td>
											</tr>
										<?endforeach?>
									</tbody>
								</table>
								<div><br/></div>
							<?endforeach?>
						</div><!-- .wd_iblock_data -->
					<?endforeach?>
				<?endforeach?>
			</div>
		</td>
	</tr>
	<?$TabControl->Buttons(array("disabled"=>false,"back_url"=>"webdebug_column_rename.php?lang=".LANG,"btnCancel"=>false,"btnApply"=>false));?>
	<?$TabControl->End();?>
	<input type="hidden" id="wd_columnrenamer_iblock_id" name="IBLOCK_ID" value="<?=$intCurrentIBlockID;?>" />
</form>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_admin.php");?>