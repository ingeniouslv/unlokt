<div class="row" id="staggered">
	<!-- Filtered Item-->
	<% _.each(deals, function(deal) { %>
		<div class="columns staggered-item">
			<div class="tile">
				<% var now = new XDate(); %>
				<% if (typeof deal.HappyHour != 'undefined') { %>
					<a href="<%= unlokt.settings.webroot %>spots/view/<%= deal.Spot.id %>">
						<img src="<% print(unlokt.helpers.gen_path('spot', deal.Spot.id, 223, 223, deal.Spot.image_name)); %>">
						<% 
							var createDate = new XDate(deal.HappyHour.created);
							if(createDate.diffDays(now) < 8)  { 
						%>
						<img src="/img/new-tag.png" class="new">		
						<% } %>
					</a>	
				<% } else if (typeof deal.Deal == 'undefined') { %>
					<a href="<%= unlokt.settings.webroot %>spots/view/<%= deal.Spot.id %>">
						<img src="<% print(unlokt.helpers.gen_path('spot', deal.Spot.id, 223, 223, deal.Spot.image_name)); %>">
						<% 
							var createDate = new XDate(deal.Spot.created);
							if(createDate.diffDays(now) < 8)  { 
						%>
						<img src="/img/new-tag.png" class="new">		
						<% } %>
					</a>
				<% } else if (deal.Deal.keys == 0) { %>
					<a href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">
						<img src="<% print(unlokt.helpers.gen_path('deal', deal.Deal.id, 223, 223, deal.Deal.image_name)); %>">
						<% 
							var createDate = new XDate(deal.Deal.created);
							if(createDate.diffDays(now) < 8)  { 
						%>
						<img src="/img/new-tag.png" class="new">		
						<% } %>
					</a>
				<% } else if (deal.Deal.keys == 1) { %>
					<a href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">
						<img src="<% print(unlokt.helpers.gen_path('deal', deal.Deal.id, 223, 223, deal.Deal.image_name)); %>">
						<% 
							var createDate = new XDate(deal.Deal.created);
							if(createDate.diffDays(now) < 8)  { 
						%>
						<img src="/img/new-tag.png" class="new">		
						<% } %>
					</a>
				<% } else { %>
					<a href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">
						<img src="<% print(unlokt.helpers.gen_path('deal', deal.Deal.id, 223, 223, deal.Deal.image_name)); %>">
						<% 
							var createDate = new XDate(deal.Deal.created);
							if(createDate.diffDays(now) < 8)  { 
						%>
						<img src="/img/new-tag.png" class="new">		
						<% } %>
					</a>
				<% } %>
	
				<!-- If Happy Hour is currently happening, show the times. --> 
				<%
				var now = new XDate();
				var todays_day = now.getDay(); /* returns 0-6, day of the week.*/
				if (typeof deal.HappyHour != 'undefined') {
					/* Create a date so we can parse the time. Le Sigh. */
					var happy_hour_end_xdate = new XDate('2012-01-01 ' + deal.HappyHour.end);
					var happy_hour_start_xdate = new XDate('2012-01-01 ' + deal.HappyHour.start);
					var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
					/* In this case, happy hour is currently happening */ %>
					<div class="tile-footer">	
						<div class="tile-type">
							<h4><i class="icon-clock-2"></i></h4>
							<h2><%= deal.Spot.name %></h2>
						</div>
						<div class="block-actions">
							<div class="happy-hour">
								<div class="title">	
									<p><%= deal.HappyHour.title %><span class="end-time-wrapper"><b><span class="end-time"><% print(happy_hour_start_xdate.toString('h:mm tt')); %></span> - <span class="end-time"><% print(happy_hour_end_xdate.toString('h:mm tt')); %></span></b></span> </p>
								</div>	
								<div class="is-active">
									<span class="week-day"><%= days[deal.HappyHour.day_of_week] %></span>
									<%= deal.HappyHour.description %>
								</div>
							</div>
							<%
								var days_of_week = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
								var days_of_week_full = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
								var day_class = '';
								 
								for (var i = 0; i < days_of_week.length; i ++){
									dayi_class = (deal.HappyHour.day_of_week == i)?'special-active-day':'special-inactive-day';
								%>
								<span class="<%= day_class %>"><%= days_of_week[i] %></span>
							<%
							}
							%>
							<a class="btn btn-yellow pull-right" href="<%= unlokt.settings.webroot %>spots/view/<%= deal.Spot.id %>">View Spot</a>
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
							<% if(_.indexOf(spot_ids_i_follow, parseInt(deal.Spot.id)) > -1) { %>
								<a class="btn btn-blue pull-right following" href="javascript:void(0);" data-spot-id="<%= deal.Spot.id %>">Unfollow Spot</a>
							<% } else { %>
								<a class="btn btn-yellow pull-right follow" href="javascript:void(0);" data-spot-id="<%= deal.Spot.id %>">Follow Spot</a>
							<% } %>
						</div>
					</div>	
				<!-- The current Deal is not a HappyHour - show the keys required and a link -->
				<% } else { %>
					<div class="tile-footer">
						<div class="tile-type">
							<% if (deal.Deal.keys == '0') { %>
								<h4><i class="icon-calendar"></i></h4>
							<% } else if (deal.Deal.keys == '1') { %>
								<h4><i class="icon-tag-2"></i></h4>
							<% } else { %>
								<h4><i class="icon-key"></i></h4>
							<% } %>
							<h2><%= deal.Deal.name %></h2>
						</div>
						<div class="block-actions">
							<% if(deal.Deal.keys < 2) { %>
								<p>
									<%
										/* Loop through a weeks worth of days.
											The soonest matching day should be selected as the next occurrence date.
											This logic might have to be adjusted later to skip date ranges or something. */
										var xdate = new XDate();
										var displayDate = '';
										for (var i = 0; i < 7; i ++) {
											xdate.addDays(i ? 1 : 0);
											var day_of_week = xdate.toString('dddd').toLowerCase();
											if (deal.Deal[day_of_week] == 1) {
												displayDate = xdate.toString('ddd d MMM');
												break;
											}
										}
									%>
									<%= displayDate %>
								</p>
							<% } %>
							<p><%= deal.Deal.description %></p>
							<% if (deal.Deal.keys > 1) { %>
								<span class="keys-total pull-left"><%= deal.Deal.keys %></span>
							<% } else { %>
								<%
								var days_of_week = ['S', 'M', 'T', 'W', 'T', 'F', 'S'];
								var days_of_week_full = ['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'];
								var day_class = '';
								 
								for (var i = 0; i < days_of_week.length; i ++){
									switch(i) {
										case 0:
											day_class = deal.Deal.sunday?'special-active-day':'special-inactive-day';
											break;
										case 1:
											day_class = deal.Deal.monday?'special-active-day':'special-inactive-day';
											break;
										case 2:
											day_class = deal.Deal.tuesday?'special-active-day':'special-inactive-day';
											break;
										case 3:
											day_class = deal.Deal.wednesday?'special-active-day':'special-inactive-day';
											break;
										case 4:
											day_class = deal.Deal.thursday?'special-active-day':'special-inactive-day';
											break;
										case 5:
											day_class = deal.Deal.friday?'special-active-day':'special-inactive-day';
											break;
										case 6:
											day_class = deal.Deal.saturday?'special-active-day':'special-inactive-day';
											break;
									}
								%>
									<span class="<%= day_class %>"><%= days_of_week[i] %></span>
								<%
								}
								%>
							<% } %>
							<% if (deal.Deal.keys > 0) { %>
								<a class="btn btn-yellow pull-right" href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">View Special</a>
							<% } else { %>
								<a class="btn btn-yellow pull-right" href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">View Event</a>
							<% } %>
						</div>
					</div>
					<!-- <div class="block-actions">
						<% if(deal.Deal.keys > 1) { %>
							<span class="keys-total"><%= deal.Deal.keys %></span>
						<% } %>
						<% if(deal.Deal.keys > 0) { %>
							<a class="btn btn-yellow pull-right" href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">View Special</a>
						<% } else { %>
							<a class="btn btn-yellow pull-right" href="<%= unlokt.settings.webroot %>deals/view/<%= deal.Deal.id %>">View Event</a>
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
	<a class="btn-tap" href="javascript:search(<%= deal_new_limit %>, <%= feed_new_limit %>, <%= review_new_limit %>);">Show More</a>
</div>