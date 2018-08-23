<?php
namespace Bitrix\Landing\Components\LandingEdit;

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use \Bitrix\Landing\Manager;
use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Localization\Loc;

Loc::loadMessages(__FILE__);

$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();

$APPLICATION->setTitle(Loc::getMessage('LANDING_TPL_TITLE'));

if ($arResult['ERRORS'])
{
	?><div class="landing-message-label error"><?
	foreach ($arResult['ERRORS'] as $error)
	{
		echo $error . '<br/>';
	}
	?></div><?
}

if ($arResult['FATAL'])
{
	return;
}

// vars
$domainId = 0;
$domainName = '';
$domainProtocol = '';
$row = $arResult['LANDING'];
$meta = $arResult['META'];
$hooks = $arResult['HOOKS'];
$domains = $arResult['DOMAINS'];
$tplRefs = $arResult['TEMPLATES_REF'];
$sites = $arResult['SITES'];
if (!$row['SITE_ID']['CURRENT'])
{
	$row['SITE_ID']['CURRENT'] = $arParams['SITE_ID'];
}
if (isset($sites[$row['SITE_ID']['CURRENT']]))
{
	$domainId = $sites[$row['SITE_ID']['CURRENT']]['DOMAIN_ID'];
}
if (isset($domains[$domainId]))
{
	$domainName = $domains[$domainId]['DOMAIN'];
	$domainProtocol = $domains[$domainId]['PROTOCOL'];
}

// title
if ($arParams['LANDING_ID'])
{
	$APPLICATION->setTitle(Loc::getMessage('LANDING_TPL_TITLE_EDIT'));
}
else
{
	$APPLICATION->setTitle(Loc::getMessage('LANDING_TPL_TITLE_ADD'));
}

// assets
\CJSCore::init(array('color_picker', 'landing_master'));
Asset::getInstance()->addCSS('/bitrix/components/bitrix/landing.site_edit/templates/.default/landing-forms.css');
Asset::getInstance()->addCSS('/bitrix/components/bitrix/landing.site_edit/templates/.default/style.css');
Asset::getInstance()->addJS('/bitrix/components/bitrix/landing.site_edit/templates/.default/landing-forms.js');
Asset::getInstance()->addJS('/bitrix/components/bitrix/landing.site_edit/templates/.default/script.js');

$this->getComponent()->initAPIKeys();

// view-functions
include \Bitrix\Landing\Manager::getDocRoot() . '/bitrix/components/bitrix/landing.site_edit/templates/.default/template_class.php';
$template = new Template($arResult);

// some url
$uriSave = new \Bitrix\Main\Web\Uri(POST_FORM_ACTION_URI);
$uriSave->addParams(array(
	'action' => 'save'
));
?>

<form action="<?= $uriSave->getUri();?>" method="post" class="ui-form ui-form-gray-padding landing-form-collapsed landing-form-settings landing-page-set-form" id="landing-page-set-form">
	<input type="hidden" name="fields[SAVE_FORM]" value="Y" />
	<input type="hidden" name="fields[SITE_ID]" value="<?= \htmlspecialcharsbx($row['SITE_ID']['CURRENT'])?>">
	<?= bitrix_sessid_post()?>

	<div class="ui-form-title-block">
		<span class="ui-editable-field" id="ui-editable-title">
			<label id="METAOG_TITLE_TEXT" class="ui-editable-field-label ui-editable-field-label-js"><?= $row['TITLE']['CURRENT']?></label>
			<input type="text" id="METAOG_TITLE" name="fields[TITLE]" class="ui-input ui-editable-field-input ui-editable-field-input-js" value="<?= $row['TITLE']['CURRENT']?>" placeholder="<?= $row['TITLE']['TITLE']?>" />
			<span class="ui-title-input-btn ui-title-input-btn-js ui-editing-pen"></span>
		</span>
	</div>

	<div class="landing-form-inner-js landing-form-inner">
		<div class="landing-form-table-wrap landing-form-table-wrap-js ui-form-inner">
			<table class="ui-form-table landing-form-table">
				<tr class="landing-form-site-name-fieldset">
					<td class="ui-form-label ui-form-label-align-top"><?= Loc::getMessage('LANDING_TPL_FIELD_CODE');?></td>
					<td class="ui-form-right-cell">
						<div class="landing-form-site-name-block">
							<span class="landing-form-site-name-label">
								<?= $domainName?>
								<?if (\Bitrix\Main\Loader::includeModule('bitrix24')):?>
								/
								<?else:?>
								/pub/site/
								<?endif;?>
							</span>
							<input type="text" name="fields[CODE]" value="<?= \htmlspecialcharsbx($row['CODE']['CURRENT'])?>" class="ui-input" />
							<span class="landing-form-site-name-label">/</span>
						</div>
					</td>
				</tr>
				<?if (isset($hooks['METAOG'])):
					$pageFields = $hooks['METAOG']->getPageFields();
					?>
				<tr>
					<td class="ui-form-label ui-form-label-align-top"><?= $hooks['METAOG']->getTitle();?></td>
					<td class="ui-form-right-cell">
						<div class="landing-form-social-view">
							<?
							if (isset($pageFields['METAOG_IMAGE']))
							{
								$imgPath = '';
								if (!empty($meta['og:image']))
								{
									$imgPath = array_shift($meta['og:image']);
									if (isset($imgPath['src']))
									{
										$imgPath = $imgPath['src'];
									}
								}
								$template->showPictureJS(
									$pageFields['METAOG_IMAGE'],
									\Bitrix\Main\Loader::includeModule('bitrix24')
									? 'https://' . $domainName . '/preview.jpg'
									: $imgPath,
									array(
										'imgId' => 'landing-form-social-img',
										'imgEditId' => 'landing-form-social-img-edit',
										'width' => 1200,
										'height' => 1200,
										'uploadParams' =>
											$row['ID']['CURRENT']
												? array(
												'action' => 'Landing::uploadFile',
												'lid' => $row['ID']['CURRENT']
											)
												: array(
												//
											)
									)
								);
								?>
								<div class="landing-form-social-img-block" id="landing-form-social-img"></div>
								<div class="landing-form-social-img-edit" id="landing-form-social-img-edit"></div>
								<?
							}
							?>
							<div class="landing-form-social-text-block">
							<?if (isset($pageFields['METAOG_TITLE'])):
								if (!$pageFields['METAOG_TITLE']->getValue())
								{
									$pageFields['METAOG_TITLE']->setValue($meta['og:title']);
								}
								?>
								<script type="text/javascript">
									BX.ready(function()
									{
										new BX.Landing.EditTitleForm(BX('ui-editable-page-title'));
									});
								</script>
								<div class="landing-form-social-text-title">
									<span class="ui-editable-field" id="ui-editable-page-title">
										<label id="metaog-title-text" class="ui-editable-field-label ui-editable-field-label-js">
											<?= \htmlspecialcharsbx($pageFields['METAOG_TITLE']->getValue());?>
										</label>
										<?
										$pageFields['METAOG_TITLE']->viewForm(array(
											'class' => 'ui-input ui-editable-field-input ui-editable-field-input-js',
											'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]',
											'id' => 'metaog-title-field'
										));
										?>
										<span class="ui-title-input-btn ui-title-input-btn-js ui-editing-pen"></span>
									</span>
								</div>
							<?endif;?>
							<?if (isset($pageFields['METAOG_DESCRIPTION'])):
								if (!$pageFields['METAOG_DESCRIPTION']->getValue())
								{
									$pageFields['METAOG_DESCRIPTION']->setValue($meta['og:description']);
								}
								?>
								<script type="text/javascript">
									BX.ready(function()
									{
										new BX.Landing.EditTitleForm(BX('ui-editable-page-text'));
									});
								</script>
								<div class="landing-form-social-text">
									<span class="ui-editable-field ui-editable-field-textar-wrap" id="ui-editable-page-text">
										<label class="ui-editable-field-label ui-editable-field-label-js">
											<?= htmlspecialcharsbx($pageFields['METAOG_DESCRIPTION']->getValue());?>
										</label>
										<?
										$pageFields['METAOG_DESCRIPTION']->viewForm(array(
											'class' => 'ui-textarea ui-editable-field-textarea ui-editable-field-input-js',
											'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
										));
										?>
										<span class="ui-title-input-btn ui-title-input-btn-js ui-editing-pen"></span>
									</span>
								</div>
							<?endif;?>
								<div class="landing-form-social-site-name"><?= $domainName?></div>
							</div>
						</div>
					</td>
				</tr>
				<?endif;?>
				<tr>
					<td class="ui-form-right-cell ui-form-collapse" colspan="2">
						<div class="ui-form-collapse-block landing-form-collapse-block-js">
							<span class="ui-form-collapse-label"><?= Loc::getMessage('LANDING_TPL_ADDITIONAL');?></span>
							<span class="landing-additional-alt-promo-wrap">
								<span class="landing-additional-alt-promo-text"><?= Loc::getMessage('LANDING_TPL_ADDITIONAL_TAGS');?></span>
								<span class="landing-additional-alt-promo-text"><?= Loc::getMessage('LANDING_TPL_ADDITIONAL_BG');?></span>
								<span class="landing-additional-alt-promo-text"><?= Loc::getMessage('LANDING_TPL_ADDITIONAL_VIEW');?></span>
								<span class="landing-additional-alt-promo-text"><?= Loc::getMessage('LANDING_TPL_ADDITIONAL_LAYOUT');?></span>
								<span class="landing-additional-alt-promo-text"><?= Loc::getMessage('LANDING_TPL_ADDITIONAL_METRIKA');?></span>
								<span class="landing-additional-alt-promo-text"><?= Loc::getMessage('LANDING_TPL_ADDITIONAL_INDEX');?></span>
								<span class="landing-additional-alt-promo-text"><?= Loc::getMessage('LANDING_TPL_ADDITIONAL_HTMLCSS');?></span>
								<span class="landing-additional-alt-promo-text"><?= Loc::getMessage('LANDING_TPL_ADDITIONAL_SITEMAP');?></span>
							</span>
						</div>
					</td>
				</tr>
				<?if (isset($hooks['METAMAIN'])):
					$pageFields = $hooks['METAMAIN']->getPageFields();
					?>
				<tr class="landing-form-hidden-row">
					<td class="ui-form-label ui-form-label-align-top"><?= $hooks['METAMAIN']->getTitle();?></td>
					<td class="ui-form-right-cell">
						<div class="ui-checkbox-hidden-input landing-form-meta-block">
							<?
							if (isset($pageFields['METAMAIN_USE']))
							{
								$pageFields['METAMAIN_USE']->viewForm(array(
									'class' => 'ui-checkbox',
									'id' => 'checkbox-metamain-use',
									'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
								));
							}
							?>
							<div class="ui-checkbox-hidden-input-inner">
								<?if (isset($pageFields['METAMAIN_USE'])):?>
								<label class="ui-checkbox-label" for="checkbox-metamain-use">
									<?= $pageFields['METAMAIN_USE']->getLabel();?>
								</label>
								<?endif;?>
								<div class="landing-form-wrapper">
									<div class="ui-form-field-description">
										<?= $hooks['METAMAIN']->getDescription();?>
									</div>
								<?if (
									isset($pageFields['METAMAIN_TITLE']) &&
									isset($pageFields['METAMAIN_DESCRIPTION'])
								):
									if (!$pageFields['METAMAIN_TITLE']->getValue())
									{
										$pageFields['METAMAIN_TITLE']->setValue($meta['title']);
									}
									if (!$pageFields['METAMAIN_DESCRIPTION']->getValue())
									{
										$pageFields['METAMAIN_DESCRIPTION']->setValue($meta['description']);
									}
									?>
									<script type="text/javascript">
										BX.ready(function()
										{
											BX.Landing.CustomFields([
												{field:BX('landing-meta-title-field'), node:BX('landing-meta-title-text'), length: 75},
												{field:BX('landing-meta-text-field'), node:BX('landing-meta-text'), length: 200}
											]);
										});
									</script>
									<div class="landing-form-meta">
										<div class="landing-form-meta-title" id="landing-meta-title-text">
											<?= \htmlspecialcharsbx($pageFields['METAMAIN_TITLE']->getValue());?>
										</div>
										<div class="landing-form-meta-link"><?= $domainProtocol?>://<?= $domainName?>/</div>
										<div class="landing-form-meta-text"  id="landing-meta-text">
											<?= \htmlspecialcharsbx($pageFields['METAMAIN_DESCRIPTION']->getValue());?>
										</div>
									</div>
									<div class="ui-control-wrap">
										<div class="ui-form-control-label"><?= $pageFields['METAMAIN_TITLE']->getLabel();?></div>
										<?
										$pageFields['METAMAIN_TITLE']->viewForm(array(
											'class' => 'ui-input',
											'id' => 'landing-meta-title-field',
											'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
										));
										?>
									</div>
									<div class="ui-control-wrap">
										<div class="ui-form-control-label"><?= $pageFields['METAMAIN_DESCRIPTION']->getLabel();?></div>
										<?
										$pageFields['METAMAIN_DESCRIPTION']->viewForm(array(
											'class' => 'ui-textarea',
											'id' => 'landing-meta-text-field',
											'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
										));
										?>
									</div>
									<?if (isset($pageFields['METAMAIN_KEYWORDS'])):?>
									<div class="ui-control-wrap">
										<div class="ui-form-control-label"><?= $pageFields['METAMAIN_KEYWORDS']->getLabel();?></div>
										<?
										$pageFields['METAMAIN_KEYWORDS']->viewForm(array(
											'class' => 'ui-input',
											'id' => 'landing-meta-text-field',
											'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
										));
										?>
									</div>
									<?endif;?>
								<?endif;?>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<?endif;?>
				<?if (isset($hooks['BACKGROUND'])):
					$pageFields = $hooks['BACKGROUND']->getPageFields();
					?>
				<tr class="landing-form-hidden-row">
					<td class="ui-form-label ui-form-label-align-top"><?= $hooks['BACKGROUND']->getTitle();?></td>
					<td class="ui-form-right-cell">
						<div class="ui-checkbox-hidden-input landing-form-page-background">
							<?
							if (isset($pageFields['BACKGROUND_USE']))
							{
								$pageFields['BACKGROUND_USE']->viewForm(array(
									'class' => 'ui-checkbox',
									'id' => 'checkbox-background-use',
									'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
								));
							}
							?>
							<div class="ui-checkbox-hidden-input-inner">
								<?if (isset($pageFields['BACKGROUND_USE'])):?>
								<label class="ui-checkbox-label" for="checkbox-background-use">
									<?= $pageFields['BACKGROUND_USE']->getLabel();?>
								</label>
								<?endif;?>
								<div class="ui-form-field-description">
									<?= $hooks['BACKGROUND']->getDescription();?>
								</div>
								<div class="landing-form-wrapper">
									<?
									if (isset($pageFields['BACKGROUND_PICTURE']))
									{
										$template->showPictureJS(
											$pageFields['BACKGROUND_PICTURE'],
											'',
											array(
												'imgId' => 'landing-form-background-field',
												'width' => 2000,
												'height' => 2000,
												'uploadParams' =>
													$row['ID']['CURRENT']
														? array(
														'action' => 'Landing::uploadFile',
														'lid' => $row['ID']['CURRENT']
													)
														: array(
														//
													)
											)
										);
										?>
										<div class="ui-control-wrap">
											<div class="ui-form-control-label"><?= $pageFields['BACKGROUND_PICTURE']->getLabel();?></div>
											<div id="landing-form-background-field" class="landing-background-field"></div>
										</div>
										<?
									}
									?>
									<?if (isset($pageFields['BACKGROUND_POSITION'])):?>
									<div class="ui-control-wrap">
										<div class="ui-form-control-label"><?= $pageFields['BACKGROUND_POSITION']->getLabel();?></div>
										<?
										$pageFields['BACKGROUND_POSITION']->viewForm(array(
											'class' => 'ui-select',
											'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
										));
										?>
									</div>
									<?endif;?>
									<?if (isset($pageFields['BACKGROUND_COLOR'])):
										$value = \htmlspecialcharsbx(trim($pageFields['BACKGROUND_COLOR']->getValue()));
										?>
									<script type="text/javascript">
										BX.ready(function() {
											new BX.Landing.ColorPicker(BX('landing-form-colorpicker'));
										});
									</script>
									<div class="ui-control-wrap">
										<div class="ui-form-control-label"><?= $pageFields['BACKGROUND_COLOR']->getLabel();?></div>
										<div class="ui-colorpicker<?if ($value){?> ui-colorpicker-selected<?}?>" id="landing-form-colorpicker" >
											<span class="ui-colorpicker-color ui-colorpicker-color-js"<?if ($value){?> style="background-color: <?= $value?>;"<?}?>></span>
											<?
											$pageFields['BACKGROUND_COLOR']->viewForm(array(
												'additional' => 'readonly',
												'class' => 'ui-input ui-input-color landing-colorpicker-inp-js',
												'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
											));
											?>
											<span class="ui-colorpicker-clear ui-colorpicker-clear"></span>
										</div>
									</div>
									<?endif;?>
								</div>
							</div>
						</div>
					</td>
				</tr>
				<?endif;?>
				<?if (isset($hooks['VIEW'])):
					$pageFields = $hooks['VIEW']->getPageFields();
					?>
					<tr class="landing-form-hidden-row">
						<td class="ui-form-label ui-form-label-align-top"><?= $hooks['VIEW']->getTitle();?></td>
						<td class="ui-form-right-cell">
							<div class="ui-checkbox-hidden-input landing-form-type-page-block">
								<?
								if (isset($pageFields['VIEW_USE']))
								{
									$pageFields['VIEW_USE']->viewForm(array(
										'class' => 'ui-checkbox',
										'id' => 'checkbox-view-use',
										'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
									));
								}
								?>
								<div class="ui-checkbox-hidden-input-inner">
									<?if (isset($pageFields['VIEW_USE'])):?>
										<label class="ui-checkbox-label" for="checkbox-view-use">
											<?= $pageFields['VIEW_USE']->getLabel();?>
										</label>
									<?endif;?>
									<?if (isset($pageFields['VIEW_TYPE'])):
										$value = $pageFields['VIEW_TYPE']->getValue();
										$items = $hooks['VIEW']->getItems();
										if (!$value)
										{
											$value = array_shift(array_keys($items));
										}
										?>
										<div class="landing-form-type-page-wrap">
											<?foreach ($items as $key => $title):?>
												<span class="landing-form-type-page landing-form-type-<?= $key?>">
										<input type="radio" <?
										?>name="fields[ADDITIONAL_FIELDS][VIEW_TYPE]" <?
											   ?>class="ui-radio" <?
											   ?>id="view-type-<?= $key?>" <?
										?><?if ($value == $key){?> checked="checked"<?}?> <?
											   ?>value="<?= $key;?>" />
										<label for="view-type-<?= $key?>">
											<span class="landing-form-type-page-img"></span>
											<span class="landing-form-type-page-title"><?= $title?></span>
										</label>
									</span>
											<?endforeach;?>
										</div>
									<?endif;?>
								</div>
							</div>
						</td>
					</tr>
				<?endif;?>
				<?if ($arResult['TEMPLATES']):?>
					<tr class="landing-form-hidden-row">
						<td class="ui-form-label ui-form-label-align-top"><?= Loc::getMessage('LANDING_TPL_LAYOUT');?></td>
						<td class="ui-form-right-cell">
							<div class="ui-checkbox-hidden-input ui-checkbox-hidden-input-layout">
								<?
								$saveRefs = '';
								$tplUsed = false;
								if (isset($arResult['TEMPLATES'][$row['TPL_ID']['CURRENT']]))
								{
									$tplUsed = true;
									$aCount = $arResult['TEMPLATES'][$row['TPL_ID']['CURRENT']]['AREA_COUNT'];
									for ($i = 1; $i <= $aCount; $i++)
									{
										$saveRefs .= $i . ':' . (isset($tplRefs[$i]) ? $tplRefs[$i] : '0') . ',';
									}
								}
								?>
								<input type="hidden" name="fields[TPL_REF]" value="<?= $saveRefs;?>" id="layout-tplrefs"/>
								<input type="checkbox" class="ui-checkbox" id="layout-tplrefs-check"<?if ($tplUsed){?> checked="checked"<?}?> />
								<div class="ui-checkbox-hidden-input-inner landing-form-page-layout">
									<label class="ui-checkbox-label" for="layout-tplrefs-check" id="layout-tplrefs-label"><?= Loc::getMessage('LANDING_TPL_LAYOUT_USE');?></label>
									<div class="landing-form-wrapper">
										<div class="landing-form-layout-select">
											<?foreach (array_values($arResult['TEMPLATES']) as $i => $tpl):?>
												<input class="layout-switcher" data-layout="<?= $tpl['XML_ID'];?>" <?
												?>type="radio" <?
													   ?>name="fields[TPL_ID]" <?
													   ?>value="<?= $tpl['ID'];?>" <?
													   ?>id="layout-radio-<?= $i + 1;?>"<?
												?><?if ($tpl['ID'] == $row['TPL_ID']['CURRENT']){?> checked="checked"<?}?>>
											<?endforeach;?>
											<div class="landing-form-list">
												<div class="landing-form-list-container">
													<div class="landing-form-list-inner">
														<?foreach (array_values($arResult['TEMPLATES']) as $i => $tpl):?>
															<label class="landing-form-layout-item landing-form-layout-item-<?= $tpl['XML_ID'];?>" <?
															?>data-block="<?= $tpl['AREA_COUNT'];?>" <?
																   ?>data-layout="<?= $tpl['XML_ID'];?>" <?
																   ?>for="layout-radio-<?= $i + 1;?>">
																<div class="landing-form-layout-item-img"></div>
															</label>
														<?endforeach;?>
													</div>
												</div>
												<div class="landing-form-select-buttons">
													<div class="landing-form-select-prev"></div>
													<div class="landing-form-select-next"></div>
												</div>
											</div>
										</div>
										<div class="landing-form-layout-detail">
											<div class="landing-form-layout-img-container">
												<?foreach (array_values($arResult['TEMPLATES']) as $i => $tpl):?>
													<div class="landing-form-layout-img landing-form-layout-img-<?= $tpl['XML_ID'];?>" data-layout="<?= $tpl['XML_ID'];?>"></div>
												<?endforeach;?>
											</div>
											<div class="landing-form-layout-block-container"></div>
										</div>
									</div>
								</div>
								<div class="ui-checkbox-hidden-input">
						</td>
					</tr>
				<?endif;?>
				<?if (isset($hooks['YACOUNTER']) || isset($hooks['GACOUNTER']) || isset($hooks['GTM'])):?>
				<tr class="landing-form-hidden-row">
					<td class="ui-form-label ui-form-label-align-top"><?= Loc::getMessage('LANDING_TPL_HOOK_METRIKA');?></td>
					<td class="ui-form-right-cell">
						<?$template->showSimple('GACOUNTER');?>
						<?$template->showSimple('GTM');?>
						<?
						if (in_array(Manager::getZone(), array('ru', 'by', 'kz')))
						{
							$template->showSimple('YACOUNTER');
						}
						?>
					</td>
				</tr>
				<?endif;?>
				<?if (isset($hooks['METAROBOTS'])):
					$pageFields = $hooks['METAROBOTS']->getPageFields();
					?>
				<tr class="landing-form-hidden-row">
					<td class="ui-form-label"><?= $hooks['METAROBOTS']->getTitle();?></td>
					<td class="ui-form-right-cell ui-form-field-wrap-align-m">
						<span class="ui-checkbox-block">
							<?
							if (isset($pageFields['METAROBOTS_INDEX']))
							{
								if (!$pageFields['METAROBOTS_INDEX']->getValue())
								{
									$pageFields['METAROBOTS_INDEX']->setValue('Y');
								}
								echo $pageFields['METAROBOTS_INDEX']->viewForm(array(
									'class' => 'ui-checkbox',
									'id' => 'checkbox-metarobots',
									'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
								));
								?>
								<label for="checkbox-metarobots" class="ui-checkbox-label">
									<?= $pageFields['METAROBOTS_INDEX']->getLabel();?>
								</label>
								<?
							}
							?>
						</span>
					</td>
				</tr>
				<?endif;?>
				<?/*<tr class="landing-form-hidden-row">
					<td class="ui-form-label">Sitemap</td>
					<td class="ui-form-right-cell ui-form-field-wrap-align-m">
						<span class="ui-checkbox-block">
							<input type="checkbox" class="ui-checkbox" id="checkbox-6" />
							<label for="checkbox-6" class="ui-checkbox-label">???????? ?????? ? sitemap.xml</label>
						</span>
					</td>
				</tr>*/?>
				<?if (isset($hooks['HEADBLOCK'])):
					$pageFields = $hooks['HEADBLOCK']->getPageFields();
					?>
				<tr class="landing-form-hidden-row">
					<td class="ui-form-label ui-form-label-align-top"><?= $hooks['HEADBLOCK']->getTitle();?></td>
					<td class="ui-form-right-cell">
						<div class="ui-checkbox-hidden-input landing-form-custom-fields">
							<?
							if (isset($pageFields['HEADBLOCK_USE']))
							{
								$pageFields['HEADBLOCK_USE']->viewForm(array(
									'class' => 'ui-checkbox',
									'id' => 'checkbox-headblock-use',
									'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
								));
							}
							?>
							<div class="ui-checkbox-hidden-input-inner">
								<?if (isset($pageFields['HEADBLOCK_USE'])):?>
								<label class="ui-checkbox-label" for="checkbox-headblock-use">
									<?= $pageFields['HEADBLOCK_USE']->getLabel();?>
								</label>
								<?endif;?>
								<?if (isset($pageFields['HEADBLOCK_CODE'])):?>
								<div class="ui-control-wrap">
									<div class="ui-form-control-label">
										<div class="ui-form-control-label-title"><?= $pageFields['HEADBLOCK_CODE']->getLabel();?></div>
										<div><?= $pageFields['HEADBLOCK_CODE']->getHelpValue();?></div>
									</div>
									<?
									$pageFields['HEADBLOCK_CODE']->viewForm(array(
										'class' => 'ui-textarea',
										'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
									));
									?>
								</div>
								<?endif;?>
								<?if (isset($pageFields['HEADBLOCK_CSS_CODE'])):?>
								<div class="ui-control-wrap">
									<div class="ui-form-control-label">
										<div class="ui-form-control-label-title"><?= $pageFields['HEADBLOCK_CSS_CODE']->getLabel();?></div>
										<div><?= $pageFields['HEADBLOCK_CSS_CODE']->getHelpValue();?></div>
									</div>
									<?
									$pageFields['HEADBLOCK_CSS_CODE']->viewForm(array(
										'class' => 'ui-textarea',
										'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
									));
									?>
								</div>
								<?endif;?>
							</div>
						</div>
					</td>
				</tr>
				<?endif;?>
				<tr class="landing-form-hidden-row">
					<td class="ui-form-label"><?= $row['SITEMAP']['TITLE']?></td>
					<td class="ui-form-right-cell ui-form-field-wrap-align-m">
						<span class="ui-checkbox-block">
							<input type="hidden" name="fields[SITEMAP]" value="N">
							<input type="checkbox" id="checkbox-sitemap" class="ui-checkbox" name="fields[SITEMAP]" value="Y"<?if ($row['SITEMAP']['CURRENT'] == 'Y'){?> checked="checked"<?}?> />
							<label for="checkbox-sitemap" class="ui-checkbox-label">
								<?= Loc::getMessage('LANDING_TPL_ACTION_ADD_IN_SITEMAP');?>
							</label>
						</span>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<div class="<?if ($request->get('IFRAME') == 'Y'){?>landing-edit-footer-fixed <?}?>pinable-block">
		<div class="landing-form-footer-container">
			<button class="webform-small-button webform-small-button-accept">
				<span class="webform-small-button-text">
					<?= Loc::getMessage('LANDING_TPL_BUTTON_' . ($arParams['LANDING_ID'] ? 'SAVE' : 'ADD'))?>
				</span>
			</button>
			<a class="landing-button-link"<?if ($request->get('IFRAME') == 'Y'){?> id="action-close"<?}?> href="<?= $arParams['PAGE_URL_LANDINGS']?>">
				<?= Loc::getMessage('LANDING_TPL_BUTTON_CANCEL')?>
			</a>
		</div>
	</div>
</form>

<script type="text/javascript">
	BX.ready(function()
	{
		new BX.Landing.Layout({
			siteId: '<?= $row['SITE_ID']['CURRENT'];?>',
			landingId: '<?= $row['ID']['CURRENT'];?>',
			type: '<?= isset($sites[$row['SITE_ID']['CURRENT']]) ? $sites[$row['SITE_ID']['CURRENT']]['TYPE'] : 'PAGE';?>',
			messages: {
				area: '<?= \CUtil::jsEscape(Loc::getMessage('LANDING_TPL_LAYOUT_AREA'));?>'
			}
			<?if (isset($arResult['TEMPLATES'][$row['TPL_ID']['CURRENT']])):?>
			,areasCount: <?= $arResult['TEMPLATES'][$row['TPL_ID']['CURRENT']]['AREA_COUNT'];?>
			,current: '<?= $arResult['TEMPLATES'][$row['TPL_ID']['CURRENT']]['XML_ID'];?>'
			<?else:?>
			,areasCount: 0
			,current: 'empty'
			<?endif;?>
		});
		new BX.Landing.EditTitleForm(BX('ui-editable-title'), 600);
		new BX.Landing.ToggleFormFields(BX('landing-page-set-form'));
		// for save
		var editComponent = new BX.Landing.EditComponent();
		top.window['landingSettingsSaved'] = false;
	<?if ($arParams['SUCCESS_SAVE']):?>
		top.window['landingSettingsSaved'] = true;
		top.BX.onCustomEvent("BX.Main.Filter:apply");
		editComponent.actionClose();
	<?endif;?>
	});
</script>