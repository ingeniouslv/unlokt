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
	},
	render: function() {
		var deal_new_limit = (this.collection.length > 0)?this.collection.at(0).get('deal_limit'):10;
		var feed_new_limit = (this.collection.length > 0)?this.collection.at(0).get('feed_new_limit'):5;
		var review_new_limit = (this.collection.length > 0)?this.collection.at(0).get('review_limit'):5;
		this.$el.html(this.template({feeds: this.collection.toJSON(), deal_new_limit: deal_new_limit, feed_new_limit: feed_new_limit, review_new_limit: review_new_limit}));
	}
});