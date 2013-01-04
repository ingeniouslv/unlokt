com.unlokt.map = function(id, settings) {
	if (typeof settings == 'undefined') {
		var settings = {};
	}
	var that = this;
	// Default settings for THIS MAP CLASS
	this.settings = $.extend({
		styles: styleOriginal,
		lat: 36.1368526,
		lng: -115.1786924,
		markers: [], // The default markers for all maps.
		radius: 5, // The default radius for searching - in miles.
		// The URL for pulling spot feeds based upon scrolling/zooming the map.
		feed_url: function() {
			var bounds = that.map.getBounds();
			var NE = bounds.getNorthEast();
			var SW = bounds.getSouthWest();
			return '/spots/map_feed/' + SW.lat() + '/' + NE.lat() + '/' + SW.lng() + '/' + NE.lng();
		},
		// The URL for searching feeds. This will do some more lookup stuff. Maybe incorporate backbone.
		search_url: function() {
			var center = that.center();
			return '/spots/map_search/' + that.settings.radius + '/' + center[0] + '/' + center[1];
		}
	}, settings);
	
	// Default options for GOOGLE MAP
	this.settings.options = $.extend({
		zoom: 12,
		maxZoom: 14,
		mapTypeId: google.maps.MapTypeId.ROADMAP,
	}, this.settings.options);
	
	// Set the target element's ID
	this.id = id;

	// Execute the logic of starting up the map.
	this.init();
	
	return this;
}; // end of map();

com.unlokt.map.prototype.getBoundsString = function() {
	var bounds = this.map.getBounds();
	var NE = bounds.getNorthEast();
	var SW = bounds.getSouthWest();
	return SW.lat() + '/' + NE.lat() + '/' + SW.lng() + '/' + NE.lng();
}

com.unlokt.map.prototype.init = function() {

	// Generate the center of the map using Google Map's LatLng class.
	this.settings.options.center = new google.maps.LatLng(this.settings.lat, this.settings.lng);

	// Check for styling
	if (this.settings.styles) {
		// Set the map types to nothing. That way no names/labels appear on the top-right of the map.
		this.settings.options.mapTypeControlOptions = {
			mapTypeIds: []
		}
		this.styledMap = new google.maps.StyledMapType(this.settings.styles, {name: null});
	}

	// Create new GoogleMap object and assign it to this object.
	this.map = new google.maps.Map(document.getElementById(this.id), this.settings.options);
	
	this.infowindow = new google.maps.InfoWindow();
	
	// If there are styles applied to this object, then let's apply the styled map
	if (this.settings.styles) {
		this.map.mapTypes.set('', this.styledMap);
		this.map.setMapTypeId('');
	}
	
	// An array holding the marker IDs.
	// This will ensure we don't add markers already on the map
	this.marker_ids = [];
	
	this.setMarkers(this.settings.markers);
	
	return this;
}; // end if init();

// Get or Set the Center the map.
com.unlokt.map.prototype.center = function(lat, lng) {
	// If the lat or lng are not set then return the center.
	if (typeof lat == 'undefined' || typeof lng == 'undefined') {
		var center = this.map.getCenter();
		return [center.lat(), center.lng()];
	}
	this.settings.lat = lat;
	this.settings.lng = lng;
	this.map.setCenter(new google.maps.LatLng(this.settings.lat, this.settings.lng));
	return this;
}; // end of center();

// resetMarkers() is intended to clear the map of markers and delete the markers from memory.
com.unlokt.map.prototype.resetMarkers = function() {
	// Set all the current marker's map to null (if there are any)
	if (typeof this.markers == 'object' && this.markers.length) {
		_.each(this.markers, function(marker) {
			marker.setMap(null);
		});
	}
	// Clear/create/reset the object of markers
	this.markers = [];
	this.marker_ids = [];
	// Reset the bounds
	this.markerBounds = new google.maps.LatLngBounds();
}; // end of resetMarkers();

com.unlokt.map.prototype.setMarkers = function(markerData) {
	// Since we are "Setting Markers" then we assume we are to delete the old markers.
	// If the intention is to just add markers (without deleting the current ones) then use addMarkers() instead.
	this.resetMarkers();
	this.addMarkers(markerData);
}; // end of setMarkers();

com.unlokt.map.prototype.addMarker = function(markerData) {
	if (this.marker_ids.indexOf(markerData.id) != -1) {
		return;
	}
	// Create icon. This will later be determined by the type of location
	var icon = new google.maps.MarkerImage('/maps/markers/marker2.png', new google.maps.Size(38, 53), new google.maps.Point(0,0), new google.maps.Point(18, 53));
	var latlng = new google.maps.LatLng(markerData.lat, markerData.lng);
	// This marker data is coming from wherever it's being set. No telling what data is contained on this object.
    var marker = new google.maps.Marker({
        position: latlng,
        map: this.map,
        icon: icon,
        title: markerData.name,
        address: markerData.address + ' ' + markerData.address2,
        id: markerData.id
        // animation: google.maps.Animation.DROP
    });
    this.marker_ids.push(markerData.id);
    
    // Add this new Marker to the official marker array
	this.markers.push(marker);
	// Add this Marker's bounds to the markerBounds object so that we can have a proper zoom with all the markers in view
	this.markerBounds.extend(latlng);
	var that = this;
	google.maps.event.addListener(marker, 'click', function(event) {
		that.infoWindow(event, this);
	});
	return this;
}; // end of addMarker()

com.unlokt.map.prototype.fitMapToBounds = function() {
	this.map.fitBounds(this.markerBounds);
} // end of fitMapToBounds();

// Add markers to the current map. This is similar to setMarkers() except this method does not delete old markers first.
com.unlokt.map.prototype.addMarkers = function(markerData) {
	// var that = this;
	_.each(markerData, function(marker) {
		this.addMarker(marker);
	}, this);
	return this;
}; // end of addMarkers();

// com.unlokt.map.prototype.removeMarker = function(id) {
	// this.marker_ids.splice(this.marker_ids.indexOf(id), 1);
	// for (var i in this.markers) {
		// var marker = this.markers[i];
		// if (marker.id == id) {
			// marker.setMap(null);
			// this.markers.splice(i, 1);
		// }
	// }
// };

// checkMarkers() will iterate through the markers and delete any which are out of bounds.
com.unlokt.map.prototype.checkBoundMarkers = function() {
	var map_bounds = this.map.getBounds();
	_.each(this.markers, function(marker, i) {
		// If the marker does not fit within the map bounds, remove it from our map.
		if (!map_bounds.contains(marker.position)) {
			marker.setMap(null);
			this.marker_ids.splice(_.indexOf(this.marker_ids, marker.id), 1);
			this.markers.splice(i, 1);
			if (marker.id == this.infowindow.id) {
				this.infowindow.close();
			}
		}
	}, this);
};

com.unlokt.map.prototype.updateFeed = function() {
	var that = this;
	console.log('poll ' + this.settings.feed_url());
	$.getJSON(this.settings.feed_url(), function(markers) {
		console.log('updateFeed() fetched ' + markers.length + ' markers');
		that.addMarkers(markers).checkBoundMarkers();
	});
	return this;
};

com.unlokt.map.prototype.registerEvents = function(trigger) {
	// this.timeout = setTimeout(function() {}, 1);
	var that = this;
	var timeout_length = 100; // number of milliseconds to wait to no more events
	// Create two events.
	// FIRST EVENT - listen to when the center of the map has changed.
	google.maps.event.addListener(this.map, 'center_changed', function() {
		clearTimeout(that.timeout);
		that.timeout = setTimeout(function() {
			that.updateFeed();
		}, timeout_length);
	});
	// SECOND EVENT - listen to when the zoom has chanhed.
	google.maps.event.addListener(this.map, 'zoom_changed', function() {
		clearTimeout(that.timeout);
		that.timeout = setTimeout(function() {
			that.updateFeed();
		}, timeout_length);
	});
	// Now that we have added the two listeners to the map, 
	// determine if we should execute the updateFeed() automatically.
	if (trigger) {
		this.timeout = setTimeout(function() {
			that.updateFeed();
		}, 500);
	}
	return this;
};

com.unlokt.map.prototype.infoWindow = function(event, marker) {
	var info_window_parts = [];
	info_window_parts.push('<div>');
	info_window_parts.push('<h3>' + marker.title + '</h3>');
	info_window_parts.push('<p classs="address">' + marker.address + '</p>');
	info_window_parts.push('</div>');
	
	this.infowindow.setContent(info_window_parts.join(''));
	this.infowindow.setPosition(marker.position);
	this.infowindow.id = marker.id;
	this.infowindow.open(this.map);
};

var testMarkers = [
	{
		name: 'Zach',
		lat: 36.138833,
		lng: -115.193195
	},
	{
		name: 'Joey',
		lat: 36.128833,
		lng: -115.171134
	},
	{
		name: 'Matt',
		lat: 36.108533,
		lng: -115.131134
	},
	{
		name: 'Far',
		lat: 36.10,
		lng: -115.1
	},
	{
		name: 'Jane',
		lat: 36.113533,
		lng: -115.141231
	}
];

// Map Styling
var styleOriginal = [
	{
		featureType: "water",
		stylers: [
			{ color: "#73b7e6" }
		]
	},{
		featureType: "landscape.natural",
		stylers: [
			{ color: "#e9e0d8" }
		]
	},{
		featureType: "landscape.man_made",
		stylers: [
			{ color: "#e2d8ce" }
		]
	},{
		featureType: "administrative.locality",
		elementType: "labels.text.fill",
		stylers: [
			{ color: "#181818" }
		]
	},{
		featureType: "administrative.province",
		elementType: "geometry",
		stylers: [
			{ color: "#bebbb8" }
		]
	},{
		featureType: "road",
		elementType: "geometry.fill",
		stylers: [
			{ color: "#ffffff" }
		]
	},{
		featureType: "road",
		elementType: "geometry.stroke",
		stylers: [
			{ color: "#c4beb7" },
			{ weight: 1 }
		]
	},{
		featureType: "road.arterial",
		elementType: "labels.text.stroke",
		stylers: [
			{ color: "#ffffff" }
		]
	},{
		featureType: "road.highway",
		elementType: "labels.text.stroke",
		stylers: [
			{ color: "#ffffff" }
		]
	},{
		featureType: "poi.attraction",
		stylers: [
			{ color: "#cbe4aa" }
		]
	},{
		featureType: "administrative.province",
		elementType: "labels.text.fill",
		stylers: [
			{ color: "#181818" }
		]
	},{
		featureType: "poi.park",
		elementType: "geometry.fill",
		stylers: [
			{ color: "#b8d089" }
		]
	}
];

var styleNew = [
	{
		featureType: "water",
		stylers: [
			{ color: "#90c4ce" }
		]
	},{
		featureType: "landscape.natural",
		elementType: "geometry",
		stylers: [
			{ color: "#edf0f7" }
		]
	},{
		featureType: "poi.park",
		elementType: "geometry",
		stylers: [
			{ color: "#8fceb1" }
		]
	},{
		featureType: "administrative",
		elementType: "geometry.fill",
		stylers: [
			{ color: "#d5d8df" }
		]
	},{
		featureType: "road",
		elementType: "geometry.fill",
		stylers: [
			{ saturation: -24 },
			{ lightness: 40 },
			{ color: "#ffffff" }
		]
	},{
		featureType: "road.highway",
		elementType: "geometry.stroke",
		stylers: [
			{ weight: 1.1 },
			{ saturation: -100 },
			{ lightness: 28 },
			{ color: "#30363e" }
		]
	},{
		featureType: "road",
		elementType: "labels.text.stroke",
		stylers: [
			{ color: "#ffffff" }
		]
	},{
		featureType: "road",
		elementType: "labels.text.fill",
		stylers: [
			{ color: "#000000" }
		]
	},{
		featureType: "road.arterial",
		elementType: "geometry.stroke",
		stylers: [
			{ color: "#808080" }
		]
	},{
		featureType: "road.local",
		elementType: "geometry.stroke",
		stylers: [
			{ color: "#808080" }
		]
	}
];