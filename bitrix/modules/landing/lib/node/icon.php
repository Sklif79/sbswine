<?php
namespace Bitrix\Landing\Node;

class Icon extends \Bitrix\Landing\Node
{
	/**
	 * Get class - frontend handler.
	 * @return string
	 */
	public static function getHandlerJS()
	{
		return 'BX.Landing.Block.Node.Icon';
	}


	/**
	 * Save data for this node.
	 * @param \Bitrix\Landing\Block &$block Block instance.
	 * @param string $selector Selector.
	 * @param array $data Data array.
	 * @return void
	 */
	public static function saveNode(\Bitrix\Landing\Block &$block, $selector, array $data)
	{
		$doc = $block->getDom();
		$resultList = $doc->querySelectorAll($selector);

		foreach ($data as $pos => $value)
		{
			$classList = is_array($value['classList']) ? $value['classList'] : array();
			$className = implode(' ', $classList);
			if ($classList)
			{
				if (isset($resultList[$pos]))
				{
					$resultList[$pos]->setAttribute('class', $className);
				}
			}
		}
	}
}