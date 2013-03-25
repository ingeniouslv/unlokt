<h2>
	<% if (deal.Deal.keys == 0) { %>
		<h4><i class="icon-calendar">Event</i></h4>
	<% } else if (deal.Deal.keys == 1) { %>
		<h4><i class="icon-tag-2"></i> Special</h4>
	<% } else { %>
		<h4><i class="icon-key"></i> Reward</h4>
	<% } %>
</h2>
<div class="tile">
	<img src="/gen/temp/0/270x270/<%= deal.Deal.tmp_image_name %>">
	<img src="/img/new-tag.png" class="new">
	<div class="tile-footer">	
		<div class="tile-type">
			<% if (deal.Deal.keys == 0) { %>
				<h4><i class="icon-calendar"></i></h4>
			<% } else if (deal.Deal.keys == 1) { %>
				<h4><i class="icon-tag-2"></i></h4>
			<% } else { %>
				<h4><i class="icon-key"></i></h4>
			<% } %>
			<h2><%= h(deal.Deal.name) %></h2>
		</div>	
		<div class="block-actions">
			<p><%= h(deal.Deal.description) %></p>
			<% if(deal.Deal.keys > 1) { %>
				<span class="keys-total"><%= deal.Deal.keys %></span>
			<% } %>
			<% if(deal.Deal.keys > 0) { %>
				<a class="btn btn-yellow pull-right" href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">View Special</a>
			<% } else { %>
				<a class="btn btn-yellow pull-right" href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">View Event</a>
			<% } %>
		</div>
	</div>	
</div>