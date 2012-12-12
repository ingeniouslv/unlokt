/*
 * Peaceful Computing's defaults for views, models, collections.
 * Created by Zach Jones <zach@peacefulcomputing.com>
 */
var StdView = Backbone.View.extend({
	render: function() {
		this.$el.html(this.template({data: this.collection.toJSON()}));
	}, // end of render()
	initialize: function(options) {
		// Cache the underscore template onto object.
		this.template = _.template(this.options.template);
		// When this collection receives a reset/add/remove/render event, re-render.
		this.collection.bind('reset add remove render', this.render, this);
		// Check if there is an init() function on the extending object.
		if (typeof this.init == 'function') {
			this.init();
		}
		if (this.collection.length) {
			// I assume we want to render ASAP.
			this.render();
		} else {
			this.collection.fetch();
		}
		
    } // end of initialize()
});

var StdModel = Backbone.Model.extend({

});

var StdCollection = Backbone.Collection.extend({

});

