<div class="note-slider twelve">
	<div class="block-slider-nav note-slider-nav">
		<a class="left" href="javascript:void(0);"></a>
		<a class="right" href="javascript:void(0);"></a>
	</div>
	<div class="note-slider-container review-wr">
		<% for (var i in reviews) { var review = reviews[i]; %>
		<!-- Review Item -->
		<div class="note-slide columns">
			<div class="review-item tile">	
				<div class="head">	
					<img src="<% print(unlokt.helpers.gen_path('user', review.Review.user_id, 40)); %>" class="pull-left">
			
					<!-- <?php echo $this->element('piece-rating_system', array("rating_size" => "inline")); ?> -->
					
					<div class="rating votes" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
						<div class="rating-stars">
							<%
							var empty_stars = 5 - review.Review.stars;
							print('<span class="star"></span>'.repeat(empty_stars));
							print('<span class="star full"></span>'.repeat(review.Review.stars));
							%>
						</div>
					</div><!-- end of .rating.votes -->
					
					<% if (review.Review.name) { %>
						<h3 class="title"><%= h(review.Review.name) %></h3>
					<% } %>
				</div>	
				
				<div>
					<p class="description"><%= h(review.Review.review) %></p>
				</div>	
				<div class="note-actions">
					<span class="review-spot">Noted: <a href="<%= unlokt.settings.webroot %>spots/view/<%= review.Spot.id %>"><%= h(review.Spot.name) %></a></span>
					<a href="javascript:void(0);" data-flag-review="<%= review.Review.id %>">Flag Note</a>

					<a class="more" href="<%= unlokt.settings.webroot %>reviews/view/<%= h(review.Review.id) %>">Read More</a>
				</div>	
			</div>	
		</div>
		<!-- End Review Item -->
	<% } %>
</div>