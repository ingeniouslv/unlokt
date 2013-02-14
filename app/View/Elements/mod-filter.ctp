<div class="filter">
	<!-- Filter Tabs -->
	<ul class="tabs filter-tabs">
		<li class="advanced-search-tab"><a href="#advanced-search" data-toggle="tab">Search +</a></li>
		<li class="active quick-search-tab"><a href="#quick-search" data-toggle="tab">Quick Search</a></li>
		<li class="toggle-map map-search-tab"><a href="javascript:void(0);"><i class="icon-map"></i></a></li>
	</ul>
	<!-- End Filter Tabs -->

	<!-- Simple / Quick Search Tab -->
	<div id="quick-search" class="filter-quick block tab-content active">
		<div class="row">
			<div class="ten columns">
				<ul class="nav">
					<li class="active explore" data-search="explore">
						<a href="javascript:void(0);" title="">
							<i class="icon-location"></i>
						</a>
						<div>
							<a href="javascript:void(0);">Explore</a>
							<a class="clear subsearch active" data-subsearch="all" href="javascript:void(0);">All</a>
							<a class="disabled subsearch" data-subsearch="my-spots" href="javascript:void(0);">My Spots</a>
						</div>
					</li>
					<li data-search="now"><a href="javascript:void(0);" title=""><i class="icon-pin"></i> Now</a></li>
					<li data-search="tonight"><a href="javascript:void(0);" title=""><i class="icon-moon"></i> Tonight</a></li>
					<li data-search="happy-hour"><a href="javascript:void(0);" title=""><i class="icon-clock-1"></i> Happy Hour</a></li>
					<li data-search="deals"><a href="javascript:void(0);" title=""><i class="icon-key"></i> Specials</a></li>
					<li data-search="events"><a href="javascript:void(0);" title=""><i class="icon-calendar"></i> Events</a></li>
					<li data-search="popular"><a href="javascript:void(0);" title=""><i class="icon-heart"></i> Popular</a></li>
					<li data-search="favorites"><a href="javascript:void(0);" title=""><i class="icon-star"></i> Favorites</a></li>
				</ul>
			</div>

			<div class="two columns">
				<form class="form-horizontal">
					<div class="input-search">
						<input type="text" class="input-full search" placeholder="Search for anything">
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- End Quick Search Tab -->

	<!-- Advanced Search Tab -->
	<div id="advanced-search" class="filter-advanced block tab-content">
		<div class="row">
			<div class="twelve columns">
				<form class="form-horizontal">
					<div class="control-group">
						<label for="type">Looking For</label>
						<select id="type">
							<option value="spot" selected>A Spot to Go</option>
							<option value="event">Events</option>
							<option value="happy-hour">Happy Hour</option>
							<option value="deal">Spot Specials</option>
						</select>
					</div>

					<div class="control-group">
						<label for="when">When</label>
						<select id="when">
							<option value="today">Today</option>
							<option value="tomorrow" selected>Tomorrow</option>
							<option value="next3days">Next 3 Days</option>
							<option value="nextweek">Next Week</option>
							<option value="nextmonth">Next Month</option>
						</select>
					</div>
					<?php echo $this->Form->input('Category', array('div' => 'control-group', 'id' => 'category', 'empty' => '- Any -'));?>
					<div class="control-group">
						<label for="where">Where</label>
						<input type="text" id="where" placeholder="ZIP Code" class="input-small">
					</div>

					<div class="control-group">
						<label for="keywords">Keywords</label>
						<input type="text" id="keywords" class="input-medium">
					</div>

					
					<button type="submit" class="btn btn-red">Search <i class="icon-search"></i></button>
				</form>
			</div>
		</div>
	</div>
	<!-- End Advanced Search Tab -->

</div>