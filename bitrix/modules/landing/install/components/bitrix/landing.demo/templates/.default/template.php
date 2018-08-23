<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

use \Bitrix\Main\Page\Asset;
use \Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

if ($arResult['ERRORS'])
{
	foreach ($arResult['ERRORS'] as $error)
	{
		echo '<p style="color: red;">' . $error . '</p>';
	}
}

if ($arResult['FATAL'])
{
	return;
}

$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$curUrl = $request->getRequestUri();

$bodyClass = $APPLICATION->GetPageProperty('BodyClass');
$APPLICATION->SetPageProperty('BodyClass', ($bodyClass ? $bodyClass.' ' : '') . 'no-all-paddings no-background');
$APPLICATION->setTitle(Loc::getMessage('LANDING_TPL_TITLE'));

\CJSCore::Init(array('popup', 'action_dialog'));

Asset::getInstance()->addCSS('/bitrix/components/bitrix/landing.sites/templates/.default/style.css');
Asset::getInstance()->addJS('/bitrix/components/bitrix/landing.sites/templates/.default/script.js');

?>

<div class="grid-tile-wrap" id="grid-tile-wrap">
	<div class="grid-tile-inner" id="grid-tile-inner">

<?foreach ($arResult['DEMO'] as $item):
	if ($item['HIDE'])
	{
		continue;
	}
	$uriSelect = new \Bitrix\Main\Web\Uri($curUrl);
	$uriSelect->addParams(array(
		'action' => 'select',
		'param' => $item['ID'],
		'sessid' => bitrix_sessid()
	));
	?>
	<?if ($item['AVAILABLE']):?>
	<a href="<?= $uriSelect->getUri();?>" class="landing-item landing-item-payment landing-item-hover">
	<?else:?>
	<span class="landing-item landing-item-hover landing-item-disabled">
	<?endif;?>
		<span class="landing-item-inner">
			<div class="landing-title">
				<div class="landing-title-wrap">
					<div class="landing-title-overflow"><?= \htmlspecialcharsbx($item['TITLE'])?></div>
				</div>
			</div>
			<?if (trim($item['DESCRIPTION'])):?>
				<span class="landing-item-cover landing-item-cover-short">
					<?if ($item['PREVIEW']):?>
						<img class="landing-item-cover-img"
							 src="<?= \htmlspecialcharsbx($item['PREVIEW'])?>"
							 srcset="<?= \htmlspecialcharsbx($item['PREVIEW2X'])?> 2x,
									<?= \htmlspecialcharsbx($item['PREVIEW3X'])?> 3x">
					<?endif;?>
				</span>
				<span class="landing-item-description">
					<span class="landing-item-desc-inner">
						<span class="landing-item-desc-overflow">
							<span class="landing-item-desc-height">
								<?= \htmlspecialcharsbx($item['DESCRIPTION'])?>
							</span>
						</span>
						<span class="landing-item-desc-open"></span>
					</span>
				</span>
			<?else:?>
				<span class="landing-item-cover">
					<?if ($item['PREVIEW']):?>
						<img class="landing-item-cover-img"
							 src="<?= \htmlspecialcharsbx($item['PREVIEW'])?>"
							 srcset="<?= \htmlspecialcharsbx($item['PREVIEW2X'])?> 2x,
									<?= \htmlspecialcharsbx($item['PREVIEW3X'])?> 3x">
					<?endif;?>
				</span>
			<?endif?>
		</span>
	<?if (!$item['AVAILABLE']):?>
	</span>
	<?else:?>
	</a>
	<?endif;?>
<?endforeach;?>

	</div>
</div>

<script type="text/javascript">
	BX.ready(function ()
	{
		var wrapper = BX('grid-tile-wrap');
		var tiles = Array.prototype.slice.call(wrapper.getElementsByClassName('landing-item'));
		new BX.Landing.Component.Demo({
			wrapper : wrapper,
			inner: BX('grid-tile-inner'),
			tiles : tiles
		});
		<?if ($arResult['LIMIT_REACHED']):?>
		BX.Landing.PaymentAlert({
			nodes: wrapper.querySelectorAll('.landing-item-payment'),
			title: '<?= \CUtil::jsEscape(Loc::getMessage('LANDING_TPL_LIMIT_REACHED_TITLE'));?>',
			message: '<?= ($arParams['SITE_ID'] > 0)
							? \CUtil::jsEscape(Loc::getMessage('LANDING_TPL_PAGE_LIMIT_REACHED_TEXT'))
							: \CUtil::jsEscape(Loc::getMessage('LANDING_TPL_SITE_LIMIT_REACHED_TEXT'));
						?>'
		});
		<?endif;?>
		
		for(var i=0; i<tiles.length; i++) {
			tiles[i].addEventListener('click', showLoader.bind(this));
		}

		function showLoader(event) {
			if(event.target.classList.contains("landing-item-desc-open"))
			{
				return;
			}

			var loader = BX.create('div',{
				attrs:{className:'landing-loader'}
			});
			document.body.appendChild(loader);
		}
	})
</script>