var DealModel = Backbone.Model.extend({
	urlRoot: '/deals'
});

var DealCollection = Backbone.Collection.extend({
	model: DealModel,
	url: '/deals',
	// Parse the feed to accept data from CakePHP structure.
	parse: function(results) {
		// If we have a results.deals object, return it as the result set.
		if (typeof results.deals != 'undefined') {
			return results.deals;
		} else {
			return results;
		}
	}
});

var DealView = Backbone.View.extend({
	events: {
		
	},
	initialize: function() {
		this.template = _.template(this.options.template);
		this.collection.on('reset', this.render, this);
		// If our view starts and we don't have any data, make sure to call fetch() on the collection.
		if (!this.collection.length) {
			// this.collection.fetch();
		}
	},
	render: function() {
		this.$el.html(this.template({deals: this.collection.toJSON(), new_limit: this.collection.length + 10}));
	}
});