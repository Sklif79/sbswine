;(function() {
	"use strict";

	BX.namespace("BX.Landing");


	/**
	 * Implements interface for works with cache
	 * @constructor
	 */
	BX.Landing.Cache = function()
	{
		this.store = [];
	};


	BX.Landing.Cache.prototype = {
		/**
		 * Adds entry to store
		 * @param args
		 * @param value
		 */
		add: function(args, value)
		{
			if (!this.has(args))
			{
				this.store.push(new BX.Landing.Cache.Entry(args, value));
			}
		},


		/**
		 * Checks that store has entry with args
		 * @param args
		 * @return {Boolean}
		 */
		has: function(args)
		{
			return this.store.some(function(entry) {
				return entry.has(args);
			});
		},


		/**
		 * Gets entry from cache store
		 * @param args
		 * @return {?Entry}
		 */
		get: function(args)
		{
			var entry = this.store.find(function(entry) {
				return entry.has(args);
			});

			if (entry)
			{
				return entry.value;
			}

			return null;
		},


		/**
		 * Clears store
		 */
		clear: function()
		{
			this.store = [];
		}
	};
})();