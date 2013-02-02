<div class="block block-darkgray nh">
	<h4><i class="icon-pencil"></i>  Spot Notes</h4>
</div>
<div class="note-slider twelve">
	<div class="block-slider-nav note-slider-nav">
		<a class="left" href="javascript:void(0);">&lsaquo;</a>
		<a class="right" href="javascript:void(0);">&rsaquo;</a>
	</div>
	<div class="note-slider-container review-wr">
		<% _.each(reviews, function(review) { %>
			<!-- Review Item -->
			<div class="note-slide columns">
				<div class="review-item tile">
					<div class="head">	
						<img src="<% print(unlokt.helpers.gen_path('user', review.Review.user_id, 40, 40, review.User.image_name)); %>" class="pull-left">
						<% if (review.Review.name) { %>
							<h3 class="title"><%= h(review.Review.name) %></h3>
						<% } %>
					</div>	
					
					<div>
						<p class="description"><%= h(review.Review.review) %></p>
					</div>	
					<div class="note-actions">
						<span class="review-spot">Noted: <a href="<%= unlokt.settings.webroot %>spots/view/<%= review.Spot.id %>"><%= h(review.Spot.name) %></a></span>
						<a class="flag-icon" href="javascript:void(0);" data-flag-review="<%= review.Review.id %>"> &#9873;</a>

						<a class="more" href="<%= unlokt.settings.webroot %>reviews/view/<%= h(review.Review.id) %>">Read More</a>
					</div>	
				</div>	
			</div>
			<!-- End Review Item -->
		<% }); %>
	</div>
</div>