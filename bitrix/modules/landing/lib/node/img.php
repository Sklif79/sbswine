<?php
namespace Bitrix\Landing\Node;

use \Bitrix\Landing\Manager;
use \Bitrix\Main\Web\DOM\StyleInliner;

class Img extends \Bitrix\Landing\Node
{
	/**
	 * Get class - frontend handler.
	 * @return string
	 */
	public static function getHandlerJS()
	{
		return 'BX.Landing.Block.Node.Img';
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
			$src = isset($value['src']) ? trim($value['src']) : '';
			$alt = isset($value['alt']) ? trim($value['alt']) : '';
			$id = isset($value['id']) ? intval($value['id']) : 0;

			if ($src != '')
			{
				if (isset($resultList[$pos]))
				{
					if ($resultList[$pos]->getTagName() !== 'IMG')
					{
						$styles = StyleInliner::getStyle($resultList[$pos]);
						$styles['background-image'] = 'url(\'' . $src . '\')';
						StyleInliner::setStyle($resultList[$pos], $styles);
					}
					else
					{
						$resultList[$pos]->setAttribute('src', $src);
						$resultList[$pos]->setAttribute('alt', $alt);
					}
					if ($id)
					{
						$resultList[$pos]->setAttribute('data-fileid', $id);
					}
				}
			}
		}
	}
}