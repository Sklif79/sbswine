<?php
namespace Bitrix\Landing\Components\LandingEdit;

class Template
{
	/**
	 * Result of template.
	 * @var array
	 */
	private $result = array();

	/**
	 * Constructor.
	 * @param array $result Result of template.
	 */
	public function __construct($result)
	{
		$this->result = $result;
	}

	/**
	 * Display simple hook.
	 * @param string $code Code of hook.
	 * @return void
	 */
	public function showSimple($code)
	{
		$code = strtoupper($code);
		$hooks = isset($this->result['HOOKS'])
					? $this->result['HOOKS']
					: array();

		if (isset($hooks[$code]))
		{
			$pageFields = $hooks[$code]->getPageFields();

			?><div class="ui-checkbox-hidden-input"><?

				// use-checkbox
				if (isset($pageFields[$code . '_USE']))
				{
					$pageFields[$code . '_USE']->viewForm(array(
						'class' => 'ui-checkbox',
						'id' => 'checkbox-' . strtolower($code) . '-use',
						'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
					));
				}

				?><div class="ui-checkbox-hidden-input-inner"><?

				// use-label
				if (isset($pageFields[$code . '_USE']))
				{
					?>
						<label class="ui-checkbox-label" for="<?= 'checkbox-' . strtolower($code) . '-use';?>">
							<?= $pageFields[$code . '_USE']->getLabel();?>
						</label>
					<?
					unset($pageFields[$code . '_USE']);
				}

				foreach ($pageFields as $key => $field)
				{
					$key = $field->getCode();
					// display field
					echo $field->viewForm(array(
						'class' => 'ui-input',
						'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
					));
				}

				?></div><?

			?></div><?
		}
	}

	/**
	 * Display picture.
	 * @param \Bitrix\Landing\Field $field Picture field for display.
	 * @param string $imgPath Path to img by default.
	 * @param array $params Some params.
	 * @return void
	 */
	public function showPictureJS(\Bitrix\Landing\Field $field, $imgPath = '', $params = array())
	{
		if (!isset($params['imgId']))
		{
			return;
		}

		$imgId = $field->getValue();
		$code = strtolower($field->getCode());
		$code = preg_replace('/[^a-z]+/', '', $code);
		?>
		<script type="text/javascript">
			BX.ready(function()
			{
				var imageFieldWrapper = BX('<?= $params['imgId']?>');
				var imageFieldInput = BX('landing-form-<?= $code?>-input');

				if (imageFieldWrapper)
				{
					var imageField = new BX.Landing.UI.Field.Image({
						id: 'page_settings_<?= $code?>',
                        disableAltField: true
						<?if ($imgId):?>
						,content: {
							src: '<?= \CUtil::jsEscape(str_replace(' ', '%20', \htmlspecialcharsbx((int) $imgId > 0 ? \CFile::getPath($imgId) : $imgId)));?>',
							id : <?= $imgId ? intval($imgId) : -1?>,
							alt : ''
						}
						<?else:?>
						,content: {
							src: '<?= \CUtil::jsEscape(str_replace(' ', '%20', \htmlspecialcharsbx($imgPath)));?>',
							id : -1,
							alt : ''
						}
						<?endif;?>
						<?if (isset($params['width']) && isset($params['height'])):?>
						,dimensions: {
							width: <?= (int)$params['width']?>,
							height: <?= (int)$params['height']?>
						}
						<?endif;?>
						<?if (isset($params['uploadParams']) && !empty($params['uploadParams'])):?>
						,uploadParams: <?= \CUtil::phpToJsObject($params['uploadParams']);?>
						<?endif;?>
					});

					if (imageFieldWrapper)
					{
						imageFieldWrapper.appendChild(imageField.layout);
						if (imageFieldInput)
						{
							imageField.layout.addEventListener('input', function()
							{
								var img = imageField.getValue();
								imageFieldInput.value = parseInt(img.id) > 0 ? img.id : '';
							});
						}
						<?if (isset($params['imgEditId'])):?>
						BX.bind(BX('<?= $params['imgEditId']?>'), 'click', function (event)
						{
							imageField.onUploadClick(event);
						});
						<?endif;?>
					}
				}
			});
		</script>
		<?
		$field->viewForm(array(
			'id' => 'landing-form-' . $code . '-input',
			'name_format' => 'fields[ADDITIONAL_FIELDS][#field_code#]'
		));
	}
}
