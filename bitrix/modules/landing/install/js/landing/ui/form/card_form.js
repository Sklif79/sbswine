;(function() {
	"use strict";

	BX.namespace("BX.Landing.UI.Form");


	/**
	 * Implements interface for works with card form
	 *
	 * @extends {BX.Landing.UI.Form.BaseForm}
	 *
	 * @param {{[title]: ?string}} data
	 *
	 * @constructor
	 */
	BX.Landing.UI.Form.CardForm = function(data)
	{
		BX.Landing.UI.Form.BaseForm.apply(this, arguments);
		this.layout.classList.add("landing-ui-form-card");
	};


	BX.Landing.UI.Form.CardForm.prototype = {
		constructor: BX.Landing.UI.Form.CardForm,
		__proto__: BX.Landing.UI.Form.BaseForm.prototype
	};
})();