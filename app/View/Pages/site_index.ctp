<?php
$this->set('title_for_layout', 'Homepage');
$this->Html->add_script(array(
	'backbone/feed',
	'backbone/deal',
	'backbone/review',
	'libs/jquery.grid-a-licious.min'
));
?>
<div class="showcase" id="showcase" style="background-image: url('../img/bg.jpg');">
	<div id="homepagemap" style="height: 300px;"></div>
</div>
<div class="main-content">
	<div class="container">

		<?php echo $this->element('mod-filter'); ?>

		<div class="row">
			<div class="seven columns">
				<span id="homepagedeal"><span style="color: white;">Loading...</span></span>
			</div>

			<div class="five columns">
				<span id="homepagefeed"><span style="color: white;">Loading...</span></span>
				<span id="homepagereview"><span style="color: white;"><br>Loading...</span></span>
			</div>
		</div>
	</div>
</div>

<!-- Backbone scripts to start the homepage. -->
<script src="/js/nf-slider-call.js"></script>
<script>

	//////////////////////////////////////////////////
	
	var deals = new DealCollection();
	var dealsview = new DealView({
		collection: deals,
		template: templates['deals'],
		el: $('#homepagedeal')
	});
	
	//////////////////////////////////////////////////
	
	var feeds = new FeedCollection();
	var feedsview = new FeedView({
		collection: feeds,
		template: templates['feeds'],
		el: $('#homepagefeed')
	});
	
	//////////////////////////////////////////////////
	
	var reviews = new ReviewCollection();
	var reviewsview = new ReviewView({
		collection: reviews,
		template: templates['reviews'],
		el: $('#homepagereview')
	});
	
	//////////////////////////////////////////////////
	
	var locations = <?php echo json_encode($locations); ?>;
	var closestLocation = <?php echo json_encode($locations); ?>;
	var distanceFromClosestLocation = -1;
	var spot_ids_i_follow = <?php echo json_encode($spot_ids_i_follow); ?>;
	var location_id = <?php echo json_encode($user['User']['location_id']); ?>;
	var category_id = <?php echo json_encode(isset($_GET['category'])?$_GET['category']:false); ?>;
	
	function search(limit) {

		//set the default number of deals shown
		if(typeof(limit)==='undefined') limit = 10;
		var search_type,
			url,
			radius = 10,
			search_url;
		
		if ($('.quick-search-tab.active').length) {
			search_type = 'quick';
		} else if ($('.advanced-search-tab.active').length) {
			search_type = 'advanced';
		} else {
			throw "No search type to use?";
		}
		
		// Determine the URL for searching based upon whether or not we're using RADIUS+COORDINATES or MAP BOUNDS
		var search_by_bounds = $('#showcase').hasClass('map-open');
		if (search_by_bounds) {
			try {
				search_url = unlokt.settings.webroot + 'spots/homepage_data_by_bounds/' + window.homepagemap.getBoundsString() + '?';
			} catch (err) {
				// This is the case when Google Maps has not finished initializing
				// Attempt to re-call this method after a short timeout.
				// Hopefully this is the only exception being thrown at this time, because the errors are different per browser.
				setTimeout(function() {
					search(limit);
				}, 100);
				return;
			}
		} else {
			
			search_url = unlokt.settings.webroot + 'spots/homepage_data_by_radius/' + Geo.lat + '/' + Geo.lon + '/' + radius + '?';
		}
		// Manually Checking for Placeholder Values to support IE Fallbacks.
		// Form Values Aren't cleared because the values are not being submitted.
		var $text = $('#quick-search input.search');
		var text = $text.val();
		if (text == $text.attr('placeholder')) {
			text = '';
		}
		var $zip = $('#where');
		var zip = $zip.val();
		if (zip == $zip.attr('placeholder')) {
			zip = '';
		}
		var params = {};
		switch (search_type) {
			case 'quick':
				var params = {
					search_type: search_type,
					search: $('#quick-search li.active').data('search'),
					text: text
				};
				if($('#quick-search li.active').data('search') == 'explore') 
					params.subsearch = $('#quick-search li.active a.active').data('subsearch');
				break;
			case 'advanced':
				var params = {
					search_type: search_type,
					type: $('#type').val(),
					keywords: $('#keywords').val(),
					when: $('#when').val(),
					category: $('#category').val(),
					zip: zip
				};
				break;
		}
		params.limit = limit;
		var url = search_url + $.param(params);
		
		console.log(url);
		$.getJSON(url, function(results) {
			feeds.reset(results.feeds);
			deals.reset(results.deals);
			reviews.reset(results.reviews);
			if (search_by_bounds && typeof results.spots != 'undefined' && results.spots.length > 0) {
				show_spots_on_map(results.spots);
			}
			
			initFooters();

			var notenetflixviewer = new NetflixViewer({
				click_left: '.left',
				click_right: '.right',
				container: '.note-slider',
				slider: '.note-slider-container',
				item_padding: 10,
				el: $('.note-slider').parent(),
				slider_speed: 15,
				slider_distance: 6
			});

		});
		return false;
	} // end of search()

	//////////////////////////////////////////////////
	
	function initFooters() {
		//add a hover effect to the tile image
		$('.tile').hover(
			function() {
				$(this).children('.tile-footer').children('.block-actions').slideDown(200);
			},
			function() {
				$(this).children('.tile-footer').children('.block-actions').slideUp(200);
			}
		);
		
		//initially hide the buttons
		$('.tile-footer .block-actions').hide();
	}
	
	//////////////////////////////////////////////////
	
	function GetLocation(location) {
		Geo.lat = location.coords.latitude;
		Geo.lon = location.coords.longitude;
		updateGeo();
		search();
	}
	
	//////////////////////////////////////////////////
	
	function updateGeo() {
		if(location_id)  {
			for(var i = 0; i < locations.length; i ++) {
				if(locations[i].Location.id == location_id)break;
			}
			closestLocation = locations[i];
			Geo.lat = closestLocation.Location.lat;
			Geo.lon = closestLocation.Location.lng;
			distanceFromClosestLocation = 0;
		} else {
			findClosestLocation();
			//alert(distanceFromClosestLocation);
			if(!isWithinLocation()) {
				Geo.lat = closestLocation.Location.lat;
				Geo.lon = closestLocation.Location.lng;
				distanceFromClosestLocation = 0;
				$("#current-location").html("<i class=\"icon-direction\"></i>" + closestLocation.Location.name);
			}
		}
		if (typeof window.homepagemap.center !== "undefined") {
			window.homepagemap.center(Geo.lat, Geo.lng);
		}
	}
	
	//////////////////////////////////////////////////
	
	function findClosestLocation() {
		var closestCityIndex = 0;
		var distanceFromClosestCity = -1;
		var distanceFromLocation = 0;
		for(var i = 0; i < locations.length; i ++) {
			//get distance from city
			distanceFromLocation = getDistanceFromLocation(i);
			//if this city is closer remember the value and which index that city is
			if(distanceFromClosestCity < 0 || distanceFromLocation < distanceFromClosestCity) {
				distanceFromClosestCity = distanceFromLocation;
				closestCityIndex = i;
			}
		}
		closestLocation = locations[closestCityIndex];
		//multiply by number of miles between each lat/long point
		distanceFromClosestLocation = distanceFromClosestCity * 68.703;
	}
	
	//////////////////////////////////////////////////
	
	function isWithinLocation() {
		return (distanceFromClosestLocation <= closestLocation.Location.city_radius);
	}
	
	//////////////////////////////////////////////////
	
	function getDistanceFromLocation(locIndex) {
		var a = Math.abs(Geo.lat - locations[locIndex].Location.lat);
		var b = Math.abs(Geo.lon - locations[locIndex].Location.lng);
		var c = Math.sqrt(Math.pow(a,2) + Math.pow(b,2));
		return c;
	}
	
	//////////////////////////////////////////////////
	updateGeo();
	//get geolocation from browser when page runs
	if(!location_id) {
		if(typeof(navigator.geolocation) != "undefined") {
			navigator.geolocation.getCurrentPosition(GetLocation);
		}
	}
	
	if(category_id) {
		$('.quick-search-tab').removeClass('active');
		$('.advanced-search-tab').addClass('active');
		$('#quick-search').hide();
		$('#advanced-search').show();
		$('#category').children('[value="'+category_id+'"]').attr('selected', true);
		$('#type').children('[value="deal"]').attr('selected', true);
	}
	
	// Execute search when the page runs.
	search();
	
	//////////////////////////////////////////////////
	
	$('body').on('click', '.follow', function() {
		var spot_id = $(this).data('spot-id');
		var $that = $(this);
		$.get('/users/follow_spot/' + spot_id, function(response) {
			if (response == 'GOOD') {
				$that.removeClass('follow btn-red').addClass('following btn-blue').html('Unfollow Spot');
				spot_ids_i_follow.push(spot_id);
			} else {
			}
		});
	});
	
	//////////////////////////////////////////////////
	
	$('body').on('click', '.following', function() {
		var spot_id = $(this).data('spot-id');
		var $that = $(this);
		$.get('/users/unfollow_spot/' + spot_id, function(response) {
			if (response == 'GOOD') {
				$that.removeClass('following btn-blue').addClass('follow btn-red').html('Follow Spot');
				var spot_id_index = _.indexOf(spot_ids_i_follow, spot_id);
				spot_ids_i_follow.splice(spot_id_index,1);
				search();
			} else {
			}
		});
	});
	
	//////////////////////////////////////////////////
	
	// Loop through Spot data and pass that information to the map for displaying :)
	// Note, this marker data is being passed to com.unlokt.map.js - which is then rendering the infowindow.
	function show_spots_on_map(spots) {
		var markers = [];
		_.each(spots, function(Spot) {
			var spot = Spot.Spot;
			var marker = {
				lat: spot.lat,
				lng: spot.lng,
				name: spot.name,
				address: spot.address,
				address2: spot.address2,
				id: spot.id
			};
			markers.push(marker);
		});
		window.homepagemap.addMarkers(markers);
	}
	
	//////////////////////////////////////////////////
	
	function bind_filter_actions() {
		// // The filter items on quicksearch
		$('#quick-search li').click(function() {
			$('#quick-search li').removeClass('active');
			$(this).addClass('active');
			search();
		});
		// The filter options on explore item
		$('#quick-search li.explore a.subsearch').click(function(event) {
			event.stopPropagation();
			$('#quick-search li').removeClass('active');
			$(this).siblings().removeClass('active');
			$(this).siblings().last().addClass('disabled');
			
			$(this).removeClass('disabled');
			$(this).addClass('active');
			$(this).parent().parent().addClass('active');
			search();
		});
		// The three search types - advanced, quick, map
		$('.tabs.filter-tabs > li').click(function() {
			// If clicking the map button - toggle the map before firing the search function.
			if ($(this).hasClass('toggle-map')) {
				toggle_homepage_map();
				$(this).toggleClass('toggled');
			}
			// When the button is clicked, make a search happen after a millisecond.
			setTimeout(function() {search();}, 1);
		});
		$('#advanced-search button').click(function() {
			search();
			return false;
		});
		
		// When the [enter] button is pressed, make the button trigger a search and blur the keyboard.
		$('#quick-search input[type="text"], #advanced-search input[type="text"]').keydown(function(event) {
			event.stopPropagation();
			if (event.which == 13) {
				event.preventDefault();
				$(this).blur();
				search();
			}
		});
	}
	
	//////////////////////////////////////////////////
	
	function toggle_homepage_map() {
		// First - is the map initialized?
		// If not, initialize the map and return.
		if (!$('#homepagemap').hasClass('initiated')) {
			$('#showcase').addClass('map-open');
			initialize_homepage_map();
			return;
		}
		// Apparently the homepage map is initialized already. Let's toggle it.
		if ($('#showcase').hasClass('map-open')) {
			// The map is open - "close" it.
			$('#homepagemap').hide();
			$('#showcase').removeClass('map-open');
		} else {
			// The map is already initialized, but currently closed. Show that map.
			$('#showcase').addClass('map-open');
			$('#homepagemap').show();
		}
	}
	
	//////////////////////////////////////////////////
	
	function initialize_homepage_map() {
		window.homepagemap = new com.unlokt.map('homepagemap', {
			lat: Geo.lat,
			lng: Geo.lng
		});
		$('#homepagemap').addClass('initiated');
		// Add some listeners so that panning or zooming on the map causes re-searching.
		var timeout_length = 100; // number of milliseconds to wait to no more events
		// FIRST EVENT - listen to when the center of the map has changed.
		google.maps.event.addListener(homepagemap.map, 'center_changed', function() {
			clearTimeout(window.homepagetimeout);
			window.homepagetimeout = setTimeout(function() {
				search();
			}, timeout_length);
		});
		// SECOND EVENT - listen to when the zoom has chanhed.
		google.maps.event.addListener(homepagemap.map, 'zoom_changed', function() {
			clearTimeout(window.homepagetimeout);
			window.homepagetimeout = setTimeout(function() {
				search();
			}, timeout_length);
		});
	}
	
	//////////////////////////////////////////////////
	
	// Run the method to bind user actions.
	bind_filter_actions();
</script>
<script>
	// Add a live binding for attachment images being clicked to open a gallery
	$('body').on('click', '.attachments img', function() {
		var spot_id = $(this).data('spot-id');
		var attachment_id = $(this).data('attachment-id');
		start_gallery(spot_id, attachment_id);
	});
</script>
<?php echo $this->element('mod-gallery'); ?>