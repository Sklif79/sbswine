;(function() {
	"use strict";

	BX.namespace("BX.Landing");

	var trim = BX.Landing.Utils.trim;

	/**
	 * Implements interface for works with link or button
	 *
	 * @extends {BX.Landing.Block.Node}
	 * @param {nodeOptions} options
	 * @constructor
	 */
	BX.Landing.Block.Node.Link = function(options)
	{
		BX.Landing.Block.Node.apply(this, arguments);

		if (!this.isGrouped())
		{
			this.node.addEventListener("click", this.onClick.bind(this));
		}

		if (this.isAllowInlineEdit())
		{
			this.node.setAttribute("title", BX.message("LANDING_TITLE_OF_LINK_NODE"));
		}
	};


	BX.Landing.Block.Node.Link.prototype = {
		__proto__: BX.Landing.Block.Node.prototype,
		constructor: BX.Landing.Block.Node.Link,

		onContentUpdate: function()
		{
			clearTimeout(this.contentEditTimeout);
			this.contentEditTimeout = setTimeout(function() {
				BX.Landing.History.getInstance().push(
					new BX.Landing.History.Entry({
						block: top.BX.Landing.Block.storage.getByChildNode(this.node).id,
						selector: this.selector,
						command: "editLink",
						undo: this.startValue,
						redo: this.getValue()
					})
				);

				this.startValue = null;
			}.bind(this), 400);

			this.getField().setValue(this.getValue());
		},

		/**
		 * Handles click event
		 * @param {MouseEvent} event
		 */
		onClick: function(event)
		{
			event.preventDefault();
			event.stopPropagation();

			BX.Landing.UI.Button.FontAction.hideAll();
			BX.Landing.UI.Button.ColorAction.hideAll();

			if (!BX.Landing.UI.Panel.StylePanel.getInstance().isShown())
			{
				BX.Landing.UI.Panel.Link.getInstance().show(this);
			}
		},


		/**
		 * Checks that button is prevented
		 * @return {boolean}
		 */
		isPrevented: function()
		{
			return this.getValue().target === "_popup";
		},


		/**
		 * Sets node value
		 * @param data
		 * @param {?boolean} [preventSave = false]
		 * @param {?boolean} [preventHistory = false]
		 */
		setValue: function(data, preventSave, preventHistory)
		{
			this.startValue = this.startValue || this.getValue();

			this.preventSave(preventSave);

			if (!this.containsImage())
			{
				this.node.innerHTML = data.text;
			}

			this.node.setAttribute("href", data.href);
			this.node.setAttribute("target", data.target);

			if ("attrs" in data)
			{
				for (var attr in data.attrs)
				{
					if (data.attrs.hasOwnProperty(attr))
					{
						this.node.setAttribute(attr, data.attrs[attr]);
					}
				}
			}
			else
			{
				this.node.removeAttribute("data-url")
			}

			this.onChange();

			if (!preventHistory)
			{
				this.onContentUpdate();
			}
		},


		/**
		 * Checks that this node contains image node
		 * @return {boolean}
		 */
		containsImage: function()
		{
			return !!this.node.firstElementChild && this.node.firstElementChild.tagName === "IMG";
		},


		/**
		 * Gets node value
		 * @return {{text: string, href: string|*, target: string|*}}
		 */
		getValue: function()
		{
			var value = {
				text: trim(BX.util.htmlspecialcharsback(this.node.innerHTML)),
				href: trim(this.node.getAttribute("href")),
				target: trim(this.node.getAttribute("target") || "_self")
			};

			if (this.node.getAttribute("data-url"))
			{
				value.attrs = {
					"data-url": trim(this.node.getAttribute("data-url"))
				};
			}

			return value;
		},


		/**
		 * Gets field
		 * @return {BX.Landing.UI.Field.BaseField}
		 */
		getField: function()
		{
			if (!this.field)
			{
				this.field = new BX.Landing.UI.Field.Link({
					title: this.manifest.name,
					selector: this.selector,
					content: this.getValue(),
					options: {
						siteId: BX.Landing.Main.getInstance().options.site_id,
						landingId: BX.Landing.Main.getInstance().id,
						filter: {
							'=TYPE': BX.Landing.Main.getInstance().options.params.type
						}
					}
				});
			}
			else
			{
				this.field.setValue(this.getValue());
				this.field.content = this.getValue();
				this.field.hrefInput.content = this.getValue().href;
				this.field.hrefInput.preparePlaceholder();
			}

			return this.field;
		}
	};

})();