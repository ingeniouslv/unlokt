<!-- Semantic Rating System -->
<!-- http://schema.org/AggregateRating -->

<!--
	NOTE for Rating Stars (.rating-stars):
	********************************************

	1. Direction is in right-to-left format, meaning that the highest rating is the
	   top-most '.star' element.
	2. Use '.full', '.one-third', '.one-half', '.two-thirds' to fill in stars (choose only
	   one element, other elements will cascade properly).
	3. When a user selects a rating, apply '.user-selected' to that element.
-->

<div class="rating votes" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
	<?php
	$base_rating = !empty($review['Review']['stars']) ? $review['Review']['stars'] : $spot['Spot']['rating'];
	// Calculate  FULL STARS, PARTIAL STAR, EMPTY STARS
	$full_stars = floor($base_rating);
	$partial_star = round(fmod($base_rating, $full_stars), 2);
	$empty_stars = 5 - ceil($base_rating);
	?>
	<div class="rating-stars">
		<?php
		echo str_repeat('<span class="star"></span>', $empty_stars);
		$class = null;
		switch (true) {
			case $partial_star <= .33:
				$class = 'one-third';
				break;
			case $partial_star <= .5:
				$class = 'one-half';
				break;
			case $partial_star <= .66:
			default:
				$class = 'two-thirds';
				break;
		}
		if ($partial_star > 0) {
			echo "<span class=\"star $class\"></span>";
		}
		echo str_repeat('<span class="star full"></span>', $full_stars);
		?>
	</div>

	<?php if(isset($rating_size)): ?>
		<?php if ($rating_size == "inline"): ?>
		<?php endif; ?>
	<?php else: ?>
		<div class="rating-value">
			<span class="value-group"><span itemprop="ratingValue"><?php echo $spot['Spot']['rating']; ?></span> of 5</span>
			(<span itemprop="reviewCount"><?php echo $spot['Spot']['rating_count']; ?></span> Ratings)
		</div>
	<?php endif; ?>
</div>