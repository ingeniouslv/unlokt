/* Author: Zach Jones <zach@peacefulcomputing.com,zach@voxelinc.com,jonezach@gmail.com> */

var NetflixViewer = Backbone.View.extend({
	
	//////////////////////////////////////////////////
	
	initialize: function(options) {
		var that = this;
		// merge options into default options
		this.options = $.extend({
			click_left: '.left',
			click_right: '.right',
			container: '.container',
			slider: '.slider',
			slider_speed: 1000, // How many milliseconds for looping movements.
			slider_distance: 16, // How far (in pixels) to move the slider every this.slider_speed milliseconds.
			item_padding: 0 // Amount of padding to calculate for the slider width
		}, options);
		this.options.$click_left = this.$(this.options.click_left);
		this.options.$click_right = this.$(this.options.click_right);
		this.options.$container = this.$(this.options.container);
		this.options.$slider = this.$(this.options.slider);
		// Default to the slider not moving.
		this.is_moving = false;
		// Generate some events manually.
		// We have to generate them because the target DOM elements are dynamically named and fed as options to this program.
		// Set the this.events hash and manually call this.delegateEvents() which binds the events.
		var events = {};
		events['click ' + this.options.click_left] = 'click_left';
		events['hover ' + this.options.click_left] = 'click_left';
		events['click ' + this.options.click_right] = 'click_right';
		events['hover ' + this.options.click_right] = 'click_right';
		// Merge our new events into this backbone view's actual event hash. Then delegate (a.k.a. 'bind') the events.
		this.events = $.extend(events, this.events);
		this.delegateEvents();
		// I have to make these annoying hover() calls in jQuery so that I can continuously scroll.
		this.options.$click_left.hover(
			function() {
				that.options.hover_left = true;
			},
			function() {
				that.options.hover_left = false;
			}
		);
		this.options.$click_right.hover(
			function() {
				that.options.hover_right = true;
			},
			function() {
				that.options.hover_right= false;
			}
		);
		// We keep track of a single timeout. Keep that on this.slider_timeout.
		this.slider_timeout = false;
		// Render the 
		this.render();
		
	}, // end of initialize
	
	//////////////////////////////////////////////////
	
	// Generate this.events hash manually and then call this.delegateEvents();
	events: {
	},
	
	//////////////////////////////////////////////////
	
	render: function() {
		
		// Calculate the width the slider needs to be.
		var $slider_children = this.options.$slider.children();
		var slider_width = ($slider_children.first().width() + this.options.item_padding) * $slider_children.length;
		// Adjust the slider's width
		this.options.$slider.width(slider_width);
		// Fire off a click_left() function so that our arrows show/hide accordingly.
		this.click_left();
	}, // end of render()
	
	click_right: function() {
		// Make sure we're not initiating sliding mid-slide
		if (this.is_moving) {
			return;
		}
		var that = this;
		var container_width = this.options.$container.width() + 10;
		var slider_width = this.options.$slider.width();
		// If the slider isn't bigger than the container then there's no need to scroll.
		if (slider_width <= container_width) {
			return;
		}
		// var distance_to_move = container_width * this.options.slider_multiplier;
		var distance_to_move = this.options.slider_distance;
		var slider_left = parseInt(this.options.$slider.css('left').replace(/[^\-0-9\.]/, ''));
		if (isNaN(slider_left)) {
			slider_left = 0;
		}
		var total_width_after_move = Math.abs(slider_left) + container_width + distance_to_move;
		var move_to_position;
		
		if (total_width_after_move > slider_width) {
			move_to_position = (slider_width - container_width) * -1;
		} else {
			move_to_position = slider_left - distance_to_move;
		}
		if (move_to_position == slider_left) {
			this.options.$click_right.hide();
			return;
		}
		this.options.$click_left.show();
		this.options.$click_right.show();
		this.is_moving = true;
		this.options.$slider.css('left', move_to_position + 'px');
		that.is_moving = false;
		if (this.options.hover_right) {
			if (this.slider_timeout !== false) {
				clearTimeout(this.slider_timeout);
				this.slider_timeout = false;
			}
			this.slider_timeout = setTimeout(function() {
				that.click_right();
			}, this.options.slider_speed);
		}
	}, // end of click_right()
	
	//////////////////////////////////////////////////
	
	click_left: function() {
		// Make sure we're not initiating sliding mid-slide
		if (this.is_moving) {
			return;
		}
		var that = this;
		var container_width = this.options.$container.width() + 10;
		var slider_width = this.options.$slider.width();
		// var distance_to_move = container_width * this.options.slider_multiplier;
		var distance_to_move = this.options.slider_distance;
		var slider_left = parseInt(this.options.$slider.css('left').replace(/[^\-0-9\.]/, ''));
		// If the slider isn't bigger than the container then there's no need to scroll.
		if (slider_width <= container_width) {
			this.options.$click_left.hide();
			this.options.$click_right.hide();
			return;
		}
		if (isNaN(slider_left)) {
			slider_left = 0;
		} else if (slider_left > 0) {
			return;
		} else if (distance_to_move > Math.abs(slider_left)) {
			return;
		}
		var left = slider_left + distance_to_move;
		if (left + this.options.slider_distance > 0) {
			left = 0;
			this.options.$click_left.hide();
		}
		this.options.$click_right.show();
		this.is_moving = true;
		this.options.$slider.css('left', left + 'px');
		that.is_moving = false;
		if (this.options.hover_left && left < 0) {
			if (this.slider_timeout !== false) {
				clearTimeout(this.slider_timeout);
				this.slider_timeout = false;
			}
			this.slider_timeout = setTimeout(function() {
				that.click_left();
			}, this.options.slider_speed);
		}
	} // end of click_left()
	
});