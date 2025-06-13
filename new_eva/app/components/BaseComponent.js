const BaseComponent = (function () {
	const Constructor = function (options) {
		this.el = options.el;
		this.data = options.data;
		this.template = options.template;
	};

	/* Rendering the data to the DOM. */
	Constructor.prototype.render = function () {
		const d = document;
		const $el = d.querySelector(this.el);
		if (!$el) return;
		$el.innerHTML = this.template(this.data);
		console.log(this.data);
	};

	/* Setting the state of the data. */
	Constructor.prototype.setState = function (obj) {
		for (let key in obj) {
			if (this.data.hasOwnProperty(key)) {
				this.data[key] = obj[key];
			}
		}
		this.render();
	};

	/* Returning a copy of the data. */
	Constructor.prototype.getState = function () {
		return JSON.parse(JSON.stringify(this.data));
	};

	return Constructor;
})();
