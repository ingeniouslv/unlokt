// Create default model
var FeedModel=StdModel.extend({url:"http://dev-unlokt/feeds"}),FeedCollection=StdCollection.extend({model:FeedModel,url:"/feeds",parse:function(e){var t=[];for(var n in e.feeds){e.feeds[n].id=e.feeds[n].Feed.id;t.push(e.feeds[n])}return t}}),FeedView=StdView.extend({events:{"click em.angel":"sayCheese","click .close":"del"},sayCheese:function(e,t){var n=$(e.currentTarget).data("id")},del:function(e){}}),feeds=(new FeedCollection).on("add",function(e){var t=e.get("Feed");console.log("Calling Backbone.sync to sync: "+e.get("Feed").feed);console.log($.param(e.toJSON()))});