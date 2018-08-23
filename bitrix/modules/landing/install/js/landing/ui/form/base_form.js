;(function() {
	"use strict";

	BX.namespace("BX.Landing.UI.Form");

	var append = BX.Landing.Utils.append;

	/**
	 * Implements base interface for works with forms
	 *
	 * @param {{[title]: ?string, [description]: string, [type]: string}} [data]
	 *
	 * @constructor
	 */
	BX.Landing.UI.Form.BaseForm = function(data)
	{
		data = BX.type.isPlainObject(data) ? data : {};
		this.id = "id" in data ? data.id : "";
		this.title = "title" in data ? data.title : "";
		this.type = "type" in data ? data.type : "content";
		this.descriptionText = "description" in data ? data.description : "";
		this.layout = BX.Landing.UI.Form.BaseForm.createLayout();
		this.fields = new BX.Landing.Collection.BaseCollection();
		this.description = BX.Landing.UI.Form.BaseForm.createDescription();
		this.header = BX.Landing.UI.Form.BaseForm.createHeader();
		this.body = BX.Landing.UI.Form.BaseForm.createBody();
		this.header.innerHTML = this.title;
		this.layout.appendChild(this.header);

		if (this.descriptionText)
		{
			this.description.innerHTML = this.descriptionText;
			this.layout.appendChild(this.description);
		}

		this.layout.appendChild(this.body);

	};


	/**
	 * Creates form layout
	 * @return {HTMLElement}
	 */
	BX.Landing.UI.Form.BaseForm.createLayout = function()
	{
		return BX.create("div", {props: {className: "landing-ui-form"}});
	};


	/**
	 * Creates form header layout
	 * @return {HTMLElement}
	 */
	BX.Landing.UI.Form.BaseForm.createHeader = function()
	{
		return BX.create("div", {props: {className: "landing-ui-form-header"}});
	};

	/**
	 * Creates form description layout
	 * @return {HTMLElement}
	 */
	BX.Landing.UI.Form.BaseForm.createDescription = function()
	{
		return BX.create("div", {props: {className: "landing-ui-form-description"}});
	};

	/**
	 * Creates form body layout
	 * @return {HTMLElement}
	 */
	BX.Landing.UI.Form.BaseForm.createBody = function()
	{
		return BX.create("div", {props: {className: "landing-ui-form-body"}});
	};


	BX.Landing.UI.Form.BaseForm.prototype = {
		addField: function(field)
		{
			this.fields.add(field);
			this.body.appendChild(field.getNode());
		},

		getNode: function()
		{
			return this.layout;
		},

		addCard: function(card)
		{
			append(card.layout, this.body);
			card.fields.forEach(function(field) {
				this.fields.add(field);
			}, this)
		}
	};
})();