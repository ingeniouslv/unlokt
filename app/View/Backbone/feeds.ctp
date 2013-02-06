<div class="block block-darkgray">
	<h4><i class="icon-megaphone"></i> Spot Feed</h4>
	<% _.each(feeds, function(feed) { %>
		<!-- Feed Item -->
		<div class="feed-item">
			<img src="<% print(unlokt.helpers.gen_path('spot', feed.Spot.id, 40, 40, feed.Spot.image_name)); %>" class="pull-left">
			<div class="attachments">
				<% _.each(feed.Attachment, function(attachment) { %>
					<img data-attachment-id="<%= attachment.id %>" data-spot-id="<%= attachment.id %>" src="<% print(unlokt.helpers.gen_path('attachment', attachment.id, 40, 40)); %>">
				<% }); %>
			</div>
			<h3 class="title"><a href="<%= unlokt.settings.webroot %>spots/view/<%= feed.Spot.id %>"><%= h(feed.Spot.name) %></a></h3>
			<div class="description">
				<p><%= h(feed.Feed.feed) %></p>
				<% if (typeof feed.Attachment !== 'undefined' && _.isArray(feed.Attachment) && feed.Attachment.length > 0) { %>
				<% /*End if*/ } %>
			</div>
			<a class="more" href="<%= unlokt.settings.webroot %>spots/view/<%= feed.Spot.id %>#feeds" title="">Read More</a>
		</div>
		<!-- End Feed Item -->
	<% }); %>
	<a class="btn-tap" href="javascript:search(<%= deal_new_limit %>, <%= feed_new_limit %>, <%= review_new_limit %>);">Show More</a>
</div>