<?php
namespace Bitrix\Landing\PublicAction;

use \Bitrix\Landing\Template as TemplateCore;
use \Bitrix\Landing\PublicActionResult;

class Template
{
	/**
	 * Get available templates.
	 * @param array $params Params ORM array.
	 * @return \Bitrix\Landing\PublicActionResult
	 */
	public static function getList($params = array())
	{
		$result = new PublicActionResult();

		$data = array();
		$res = TemplateCore::getList($params);
		while ($row = $res->fetch())
		{
			$data[] = $row;
		}
		$result->setResult($data);

		return $result;
	}
}