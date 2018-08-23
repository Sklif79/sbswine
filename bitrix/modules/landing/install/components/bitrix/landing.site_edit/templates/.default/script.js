BX.namespace("BX.Landing");

/**
 * Bbase script for component.
 * @param {Object} params Some params.
 * @returns {void}
 */
BX.Landing.EditComponent = function()
{
	this.actionCloseId = BX("action-close");

	if (this.actionCloseId)
	{
		BX.bind(this.actionCloseId, "click", BX.delegate(this.actionClose, this));
	}
};

BX.Landing.EditComponent.prototype = {
	/**
	 * Close the slider.
	 * @returns {void}
	 */
	actionClose: function(e)
	{
		if (
			typeof top.BX.Bitrix24 !== 'undefined' &&
			typeof top.BX.Bitrix24.PageSlider !== 'undefined'
		)
		{
			top.BX.Bitrix24.PageSlider.close();
		}
		else if (typeof top.BX.SidePanel !== 'undefined')
		{
			top.BX.SidePanel.Instance.close()
		}
		BX.PreventDefault(e);
	}
};

