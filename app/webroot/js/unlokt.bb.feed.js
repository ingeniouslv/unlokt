// Create default model
var FeedModel = StdModel.extend({
	url: 'http://dev-unlokt/feeds'
});

// Create default collection
var FeedCollection = StdCollection.extend({
	model: FeedModel,
	url: '/feeds',
	parse: function(results) {
		var retval = [];
		for (var i in results.feeds) {
			results.feeds[i]['id'] = results.feeds[i]['Feed']['id'];
			retval.push(results.feeds[i]);
		}
		return retval;
	}
});

// Create default view
var FeedView = StdView.extend({
	events: {
		"click em.angel": "sayCheese",
		'click .close': 'del'
	},
	
	sayCheese: function(e, s) {
		var id = $(e.currentTarget).data('id');
	},
	
	del: function(e) {
		// var id = $(e.currentTarget).parents('[data-id]').data('id');
		// this.collection.get(id).destroy();
		// console.log(this);
		// Backbone.sync();
	}
});

// Here we have our data. This will come from CakePHP
var feeds = new FeedCollection(
	// [
	// 	{id: 1, name: 'Zach'},
	// 	{id: 2, name: 'John'},
	// 	{id: 3, name: 'The Wolf'},
	// 	{id: 4, name: 'Jones'},
	// 	{id: 99, name: 'Jay-Z'}
	// ]
).on('add', function(feed) {
	var thefeed = feed.get('Feed');
	console.log('Calling Backbone.sync to sync: ' + feed.get('Feed').feed);
	console.log($.param(feed.toJSON()));
	// Backbone.sync('create', feed, {
		// success: function(obj, obj1) {
			// console.log('success!!');
			// console.log(obj);
			// console.log(obj1);
		// },
		// error: function(obj) {
			// console.log('error');
			// console.log(obj);
		// }
	// });
});

// Here is where all the parts come together and create some views with all the parts.
// var feedview = new FeedView({
	// collection: feeds,
	// el: $('#welp'),
	// template: $('#abc123').html()
// });

// feeds.on('add remove', function(){
// 	this.trigger('render');
// }, feeds);
