<script type="text/javascript">
	$(function() {
		// window.frontpagemap = new com.unlokt.map('map_canvas', {
		// }).registerEvents(true);
		
	});
</script>

<section class="block block-white mod-map">
	<div id="map_canvas" style="width: 753px; height: 334px;">
	</div>

	<div class="clearfix center-text-align search-params">
		<div class="third">
			<div class="input-append">
				<input type="search" class="grid-1">
				<button class="btn btn-light" type="button">Search</button>
			</div>
		</div>
		<div class="third">
			<select id="uniform-select">
				<option>Today</option>
				<option>Tomorrow</option>
				<option>Next 3 Days</option>
				<option>Next Week</option>
			</select>
		</div>
		<div class="third">
			<select id="uniform-select">
				<option>Most Popular</option>
				<option>Highest Rated</option>
				<option>Most Recent</option>
			</select>
		</div>
	</div>
</section>
