<div class="block block-darkgray">
	<h4><i class="icon-megaphone"></i> Spot Feed</h4>
	<% for (var i in feeds) { var feed = feeds[i]; %>
		<!-- Feed Item -->
		<div class="feed-item">
			<img src="<% print(unlokt.helpers.gen_path('spot', feed.Spot.id, 40, 40)); %>" class="pull-left">
			<h3 class="title"><a href="<%= unlokt.settings.webroot %>spots/view/<%= feed.Spot.id %>"><%= h(feed.Spot.name) %></a></h3>
			<div class="description">
				<p><%= h(feed.Feed.feed) %></p>
				<% if (typeof feed.Attachment !== 'undefined' && _.isArray(feed.Attachment) && feed.Attachment.length > 0) { %>
					<div class="attachments">
						<% for (var x in feed.Attachment) { if (feed.Attachment[x] == 'undefined') {continue;} %>
							<img data-attachment-id="<%= feed.Attachment[x].id %>" data-spot-id="<%= feed.Spot.id %>" src="<% print(unlokt.helpers.gen_path('attachment', feed.Attachment[x].id, 40, 40)); %>">
						<% /*End of for()*/ } %>
					</div>
					<% /*End if*/ } %>
			</div>
			<a class="more" href="<%= unlokt.settings.webroot %>spots/view/<%= feed.Spot.id %>#feeds" title="">Read More</a>
		</div>
		<!-- End Feed Item -->
	<% } %>
	
<!-- 	<div class="block-actions">
		<a class="btn btn-blue">Show More</a>
	</div> -->
</div>