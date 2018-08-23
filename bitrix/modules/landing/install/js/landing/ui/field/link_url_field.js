;(function() {
	"use strict";

	BX.namespace("BX.Landing.UI.Field");

	var isBoolean = BX.Landing.Utils.isBoolean;
	var prepend = BX.Landing.Utils.prepend;
	var remove = BX.Landing.Utils.remove;
	var data = BX.Landing.Utils.data;
	var attr = BX.Landing.Utils.attr;
	var addClass = BX.Landing.Utils.addClass;
	var removeClass = BX.Landing.Utils.removeClass;
	var proxy = BX.Landing.Utils.proxy;

	/**
	 * Implements interface for works with url href list
	 *
	 * @extends {BX.Landing.UI.Field.Text}
	 *
	 * @constructor
	 */
	BX.Landing.UI.Field.LinkURL = function(data)
	{
		BX.Landing.UI.Field.Text.apply(this, arguments);
		this.options = data.options || {};

		if (data.disallowType === true)
		{
			addClass(this.layout, "landing-ui-disallow-type");
		}

		this.disableBlocks = isBoolean(data.disableBlocks) ? data.disableBlocks: false;
		this.disableCustomURL = isBoolean(data.disableCustomURL) ? data.disableCustomURL : false;

		this.layout.classList.add("landing-ui-field-link-url");

		this.button = new BX.Landing.UI.Button.BaseButton("dropdown_button", {
			text: BX.message("LINK_URL_SUGGESTS_SELECT"),
			className: "landing-ui-button-select-link",
			onClick: this.disableBlocks ? this.onListShow.bind(this, "landings", this.options) : this.onSelectButtonClick.bind(this)
		});
		this.popup = null;

		this.grid = BX.create("div", {props: {className: "landing-ui-field-link-url-grid"}});
		this.gridLeft = BX.create("div", {props: {className: "landing-ui-field-link-url-grid-left"}});
		this.gridCenter = BX.create("div", {props: {className: "landing-ui-field-link-url-grid-center"}});
		this.gridRight = BX.create("div", {props: {className: "landing-ui-field-link-url-grid-right"}});
		this.grid.appendChild(this.gridLeft);
		this.grid.appendChild(this.gridCenter);
		this.grid.appendChild(this.gridRight);
		this.gridCenter.appendChild(this.input);
		this.gridRight.appendChild(this.button.layout);
		this.layout.appendChild(this.grid);

		this.preparePlaceholder();

		this.typeDropdown = new BX.Landing.UI.Field.Dropdown({
			items: [
				{name: BX.message("LANDING_LINK_FIELD_URL_TYPE_LINK"), value: ""},
				{name: BX.message("LANDING_LINK_FIELD_URL_TYPE_PHONE"), value: "tel:"},
				{name: BX.message("LANDING_LINK_FIELD_URL_TYPE_SKYPE"), value: "skype:"},
				{name: BX.message("LANDING_LINK_FIELD_URL_TYPE_SMS"), value: "sms:"},
				{name: BX.message("LANDING_LINK_FIELD_URL_TYPE_EMAIL"), value: "mailto:"}
			],
			onValueChange: this.onTypeChange.bind(this)
		});

		this.adjustValue();

		remove(this.typeDropdown.header);
		prepend(this.typeDropdown.layout, this.gridLeft);

		this.editPrevented = this.disableCustomURL ? data.disableCustomURL : this.getValue().indexOf("span") !== -1;
		this.onTypeChange(this.typeDropdown);
	};

	BX.Landing.UI.Field.LinkURL.prototype = {
		constructor: BX.Landing.UI.Field.LinkURL,
		__proto__: BX.Landing.UI.Field.Text.prototype,

		onTypeChange: function(field)
		{
			var value = field.getValue();

			if (value === "")
			{
				data(this.input, "data-placeholder", this.placeholder || BX.message("FIELD_LINK_HREF_PLACEHOLDER"));

				if (this.disableBlocks && this.disableCustomURL)
				{
					attr(this.input, "data-placeholder", BX.message("FIELD_LINK_HREF_PLACEHOLDER_PAGES_ONLY"))
				}

				if (!this.disableBlocks && this.disableCustomURL)
				{
					attr(this.input, "data-placeholder", BX.message("FIELD_LINK_HREF_PLACEHOLDER_WITHOUT_CUSTOM_URL"))
				}

				removeClass(this.button.layout, "landing-ui-disable");
				this.gridRight.removeEventListener("mouseover", proxy(this.onButtonMouseover, this));
				this.gridRight.removeEventListener("mouseout", proxy(this.onButtonMouseout, this));
				return;
			}

			if (value === "tel:")
			{
				data(this.input, "data-placeholder", BX.message("LANDING_LINK_FIELD_URL_TYPE_PHONE_PLACEHOLDER"));
				addClass(this.button.layout, "landing-ui-disable");
			}

			if (value === "skype:")
			{
				data(this.input, "data-placeholder", BX.message("LANDING_LINK_FIELD_URL_TYPE_SKYPE_PLACEHOLDER"));
				addClass(this.button.layout, "landing-ui-disable");
			}

			if (value === "sms:")
			{
				data(this.input, "data-placeholder", BX.message("LANDING_LINK_FIELD_URL_TYPE_SMS_PLACEHOLDER"));
				addClass(this.button.layout, "landing-ui-disable");
			}

			if (value === "mailto:")
			{
				data(this.input, "data-placeholder", BX.message("LANDING_LINK_FIELD_URL_TYPE_EMAIL_PLACEHOLDER"));
				addClass(this.button.layout, "landing-ui-disable");
			}

			this.gridRight.addEventListener("mouseover", proxy(this.onButtonMouseover, this));
			this.gridRight.addEventListener("mouseout", proxy(this.onButtonMouseout, this));
		},

		onButtonMouseover: function()
		{
			this.sustomTypeSuggestTimeout = setTimeout(function() {
				BX.Landing.UI.Tool.Suggest.getInstance().show(this.button.layout, {
					description: BX.message("LANDING_LINK_FIELD_URL_TYPE_CUSTOM_BUTTON_TITLE")
				});
				this.pulseTimeout = setTimeout(function() {
					addClass(this.typeDropdown.input, "landing-ui-pulse");
				}.bind(this), 1000);
			}.bind(this), 100);
		},


		onButtonMouseout: function()
		{
			clearTimeout(this.sustomTypeSuggestTimeout);
			BX.Landing.UI.Tool.Suggest.getInstance().hide();

			clearTimeout(this.pulseTimeout);
			removeClass(this.typeDropdown.input, "landing-ui-pulse");
		},

		preparePlaceholder: function()
		{
			var landingRegExp = new RegExp("^#landing[0-9]*");
			var blockRegExp = new RegExp("^#block[0-9]*");
			var systemRegExp = new RegExp("^#system_[a-z]*");

			if (landingRegExp.test(this.content))
			{
				var landingId = this.content.replace("#landing", "");
				BX.Landing.UI.Panel.URLList.getInstance().getLanding(landingId, this.options)
					.then(function(landing) {
						landing = landing[0];
						if (landing)
						{
							this.setValue(this.createPlaceholder({type: "landing", id: landing.ID, name: landing.TITLE}));
						}
					}.bind(this));
			}

			if (blockRegExp.test(this.content))
			{
				var blockId = parseInt(this.content.replace("#block", ""));
				BX.Landing.UI.Panel.URLList.getInstance().getBlocks(null, this.options).then(function(blocks) {
					blocks.forEach(function(block) {
						if (blockId === block.id)
						{
							this.setValue(this.createPlaceholder({type: "block", id: block.id, name: block.name}));
						}
					}, this);
				}.bind(this));
			}

			if (systemRegExp.test(this.content))
			{
				requestAnimationFrame(function() {
					var systemCode = this.content.replace("#system_", "");
					var systemPages = BX.Landing.Main.getInstance().options.syspages;

					if (systemCode in systemPages)
					{
						var page = systemPages[systemCode];
						this.setValue(this.createPlaceholder({type: "system", id: "_" + systemCode, name: page.name}));
					}
				}.bind(this));
			}
		},

		onSelectButtonClick: function()
		{
			if (!this.popup)
			{
				this.popup = BX.PopupMenu.create(
					"link_list_" + (+new Date()),
					this.button.layout,
					[
						{
							text: BX.message("LANDING_LINKS_BUTTON_LANDINGS"),
							onclick: this.onListShow.bind(this, "landings", this.options)
						},
						{
							text: BX.message("LANDING_LINKS_BUTTON_BLOCKS"),
							onclick: this.onListShow.bind(this, "blocks", this.options)
						}
					],
					{
						events: {
							onPopupClose: function() {
								this.button.layout.classList.remove("landing-ui-active");
								this.popup.destroy();
								this.popup = null;
							}.bind(this)
						}
					}
				);

				this.button.layout.parentNode.appendChild(this.popup.popupWindow.popupContainer);
			}

			this.button.layout.classList.add("landing-ui-active");
			this.popup.show();

			var rect = BX.pos(this.button.layout, this.button.layout.parentNode);
			this.popup.popupWindow.popupContainer.style.top = rect.bottom + "px";
			this.popup.popupWindow.popupContainer.style.left = "auto";
			this.popup.popupWindow.popupContainer.style.right = "0";
		},

		onListShow: function(view, options)
		{
			BX.Landing.UI.Panel.URLList.getInstance().show(view, options).then(this.onListItemClick.bind(this));
		},

		isEditPrevented: function()
		{
			return this.editPrevented;
		},

		enableEdit: function()
		{
			if (!this.isEditPrevented() && !this.disableCustomURL)
			{
				BX.Landing.UI.Field.Text.prototype.enableEdit.apply(this);
			}
		},


		/**
		 * Creates internal url placeholder
		 * @param {{type: string, id: string|number, name: string}} data
		 * @returns {Element}
		 */
		createPlaceholder: function(data)
		{
			return BX.create("span", {
				props: {className: "landing-ui-field-url-placeholder"},
				attrs: {
					"data-placeholder": ["#", data.type, data.id].join("")
				},
				children: [
					BX.create("span", {props: {className: "landing-ui-field-url-placeholder-text"}, text: data.name}),
					BX.create("span", {props: {className: "landing-ui-field-url-placeholder-delete"}})
				]
			});
		},

		onPlaceholderRemoveClick: function(event)
		{
			this.editPrevented = false;
			this.enableEdit();
			BX.remove(event.target.parentNode);
			this.setValue("");
			BX.fireEvent(this.layout, "input");
			this.onInputHandler(this.input.innerText);
		},

		onListItemClick: function(item)
		{
			this.setValue(this.createPlaceholder(item));
			BX.fireEvent(this.layout, "input");
		},

		onInputClick: function(event)
		{
			BX.Landing.UI.Field.Text.prototype.onInputClick.apply(this, arguments);

			if (event.target.classList.contains("landing-ui-field-url-placeholder-delete"))
			{
				this.onPlaceholderRemoveClick(event);
			}
		},

		adjustValue: function()
		{
			if (this.content.includes("tel:"))
			{
				this.typeDropdown.setValue("tel:");
				this.input.innerText = this.input.innerText.replace("tel:", "");
				return;
			}

			if (this.content.includes("skype:"))
			{
				this.typeDropdown.setValue("skype:");
				this.input.innerText = this.input.innerText.replace("skype:", "");
				return;
			}

			if (this.content.includes("sms:"))
			{
				this.typeDropdown.setValue("sms:");
				this.input.innerText = this.input.innerText.replace("sms:", "");
				return;
			}

			if (this.content.includes("mailto:"))
			{
				this.typeDropdown.setValue("mailto:");
				this.input.innerText = this.input.innerText.replace("mailto:", "");
				return;
			}

			this.typeDropdown.setValue("");
		},

		setValue: function(value)
		{
			if (typeof value === "object")
			{
				this.disableEdit();
				this.editPrevented = true;
				this.input.innerHTML = value.outerHTML;
				this.value = value.dataset.placeholder;
				this.onInputHandler(this.input.innerText);
			}
			else
			{
				this.editPrevented = false;
				this.enableEdit();
				this.input.innerText = value.toString().trim();
				this.value = null;
			}

			this.adjustValue();
		},

		getValue: function()
		{
			return this.typeDropdown.getValue() + (this.value ? this.value : this.input.innerText);
		}
	};
})();