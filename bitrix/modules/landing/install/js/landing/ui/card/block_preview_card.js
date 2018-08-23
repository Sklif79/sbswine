;(function() {
	"use strict";

	BX.namespace("BX.Landing.UI.Card");


	/**
	 * Implements interface for works with block preview card
	 *
	 * @extends {BX.Landing.UI.Card.BaseCard}
	 *
	 * @inheritDoc
	 * @constructor
	 */
	BX.Landing.UI.Card.BlockPreviewCard = function(data)
	{
		BX.Landing.UI.Card.BaseCard.apply(this, arguments);
		this.layout.classList.add("landing-ui-card-block-preview");

		this.mode = typeof data.mode === "string" ? data.mode : "img";
		this.title = typeof data.title === "string" ? data.title : "";
		this.imageSrc = typeof data.image === "string" ? data.image : "/bitrix/images/landing/empty-preview.png";
		this.code = typeof data.code === "string" ? data.code : "";
		this.isNew = typeof data.isNew === "boolean" ? data.isNew : false;
		this.imageContainer = BX.create("div", {props: {className: "landing-ui-card-block-preview-image-container"}});
		this.body.appendChild(this.imageContainer);
		this.header.innerText = this.title;
		this.layout.dataset.code = this.code;

		if (this.isNew)
		{
			this.title = BX.create("span", {
				props: {className: "landing-ui-new-inline"},
				text: BX.message("LANDING_BLOCKS_LIST_PREVIEW_NEW")
			}).outerHTML + "&nbsp;" + this.title;
			this.header.innerHTML = this.title;
		}

		if (this.mode === "background")
		{
			this.imageContainer.style.backgroundImage = "url(" + this.imageSrc + ")";
		}
		else
		{
			this.image = BX.create("img", {props: {src: this.imageSrc}});
			this.imageContainer.appendChild(this.image);
		}
	};


	BX.Landing.UI.Card.BlockPreviewCard.prototype = {
		constructor: BX.Landing.UI.Card.BlockPreviewCard,
		__proto__: BX.Landing.UI.Card.BaseCard.prototype
	};
})();