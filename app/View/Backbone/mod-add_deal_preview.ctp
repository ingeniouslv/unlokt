<div class="block block-white block-glow">
	<% if (deal.Deal.keys == 0) { %>
		<h4><i class="icon-event"></i> Event</h4>
	<% } else if (deal.Deal.keys == 1) { %>
		<h4><i class="icon-coupon"></i> Spot Special</h4>
	<% } else { %>
		<h4><i class="icon-tag-2"></i> Spot Special</h4>
	<% } %>
	<img src="/gen/temp/0/223x223/<%= deal.Deal.tmp_image_name %>">
	<h2><%= h(deal.Deal.name) %></h2>
	<p><%= h(deal.Deal.description) %></p>
	<div class="block-actions">
		<% if(deal.Deal.keys > 1) { %>
			<span class="keys-total"><%= deal.Deal.keys %></span>
		<% } %>
		<% if(deal.Deal.keys > 0) { %>
			<a class="btn btn-red pull-right" href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">View Special</a>
		<% } else { %>
			<a class="btn btn-red pull-right" href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">View Event</a>
		<% } %>
	</div>
</div>