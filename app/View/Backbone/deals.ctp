<div class="row" id="staggered">
	<!-- Filtered Item-->
	<% _.each(deals, function(deal) { %>
		<div class="columns staggered-item">
			<div class="tile">
				<% if (typeof deal.HappyHour != 'undefined') { %>
					<a href="<%= unlokt.settings.webroot %>spots/view/<%= deal.Spot.id %>">
						<img src="<% print(unlokt.helpers.gen_path('spot', deal.Spot.id, 223)); %>">
					</a>	
				<% } else if (typeof deal.Deal == 'undefined') { %>
					<a href="<%= unlokt.settings.webroot %>spots/view/<%= deal.Spot.id %>">
						<img src="<% print(unlokt.helpers.gen_path('spot', deal.Spot.id, 223)); %>">	
					</a>
				<% } else if (deal.Deal.keys == 0) { %>
					<a href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">
						<img src="<% print(unlokt.helpers.gen_path('deal', deal.Deal.id, 223)); %>">
					</a>
				<% } else if (deal.Deal.keys == 1) { %>
					<a href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">
						<img src="<% print(unlokt.helpers.gen_path('deal', deal.Deal.id, 223)); %>">
					</a>
				<% } else { %>
					<a href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">
						<img src="<% print(unlokt.helpers.gen_path('deal', deal.Deal.id, 223)); %>">
					</a>
				<% } %>
	
				<!-- If Happy Hour is currently happening, show the times. --> 
				<%
				var now = new XDate();
				var todays_day = now.getDay(); /* returns 0-6, day of the week.*/
				if (typeof deal.HappyHour != 'undefined') {
					/* Create a date so we can parse the time. Le Sigh. */
					var happy_hour_end_xdate = new XDate('2012-01-01 ' + deal.ParentHappyHour.end);
					/* In this case, happy hour is currently happening */ %>
					<div class="tile-footer">	
						<div class="tile-type">
							<h4><i class="icon-clock-2"></i></h4>
							<h2><%= deal.Spot.name %></h2>
						</div>
						<div class="block-actions">
							<div class="happy-hour">
								<p><%= deal.HappyHour.title %></p>
								<div class="is-active">

									<span>Happening 'till <span class="end-time"><% print(happy_hour_end_xdate.toString('h:mm tt')); %></span></span>
								</div>
							</div>
							<a class="btn btn-red pull-right" href="<%= unlokt.settings.webroot %>spots/view/<%= deal.Spot.id %>">View Spot</a>
						</div>
					</div>	
				<!-- The current Deal is a Spot - show first sentence of description and follow link -->
				<% } else if (typeof deal.Deal == 'undefined') { %>
					<div class="tile-footer">
						<div class="tile-type">
							<h4><i class="icon-location"></i></h4>
							<h2><%= deal.Spot.name %></h2>
							
						</div>
						<div class="block-actions">
							<p><%= deal.Spot.short_description %></p>
							<% if(_.indexOf(spot_ids_i_follow, parseInt(deal.Spot.id)) > -1) { %>
								<a class="btn btn-blue pull-right following" href="javascript:void(0);" data-spot-id="<%= deal.Spot.id %>">Unfollow Spot</a>
							<% } else { %>
								<a class="btn btn-red pull-right follow" href="javascript:void(0);" data-spot-id="<%= deal.Spot.id %>">Follow Spot</a>
							<% } %>
						</div>
					</div>	
				<!-- The current Deal is not a HappyHour - show the keys required and a link -->
				<% } else { %>
					<div class="tile-footer">
						<div class="tile-type">
							<% if (deal.Deal.keys == '0') { %>
								<h4><i class="icon-event"></i></h4>
							<% } else if (deal.Deal.keys == '1') { %>
								<h4><i class="icon-tag-2"></i></h4>
							<% } else { %>
								<h4><i class="icon-key"></i></h4>
							<% } %>
							<h2><%= deal.Deal.name %></h2>
						</div>
						<div class="block-actions">
							<p><%= deal.Deal.description %></p>
							<% if (deal.Deal.keys > 1) { %>
							<span class="keys-total pull-left"><%= deal.Deal.keys %></span>
							<% } %>
							<% if (deal.Deal.keys > 0) { %>
								<a class="btn btn-red pull-right" href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">View Special</a>
							<% } else { %>
								<a class="btn btn-red pull-right" href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">View Event</a>
							<% } %>
						</div>
					</div>
					<!-- <div class="block-actions">
						<% if(deal.Deal.keys > 1) { %>
							<span class="keys-total"><%= deal.Deal.keys %></span>
						<% } %>
						<% if(deal.Deal.keys > 0) { %>
							<a class="btn btn-red pull-right" href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">View Special</a>
						<% } else { %>
							<a class="btn btn-red pull-right" href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">View Event</a>
						<% } %>
					</div> -->
				<% } %>
				<!-- END OF HAPPY HOUR CONDITIONAL -->

			</div>
		</div>
	<% }); %>



</div>
	<!-- End Filtered Item -->

<div class="row">
	<a class="btn-tap" href="javascript:search(<%= new_limit %>);">Show More</a>
</div>