var FeedModel = Backbone.Model.extend({
	urlRoot: '/feeds'
});

var FeedCollection = Backbone.Collection.extend({
	model: FeedModel,
	url: '/feeds',
	// Parse the feed to accept data from CakePHP structure.
	parse: function(results) {
		// If we have a results.feeds object, return it as the result set.
		if (typeof results.feeds != 'undefined') {
			return results.feeds;
		} else {
			return results;
		}
	}
});

var FeedView = Backbone.View.extend({
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
		this.$el.html(this.template({feeds: this.collection.toJSON()}));
	}
});