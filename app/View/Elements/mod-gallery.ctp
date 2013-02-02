<?php
$this->Html->add_script('libs/jquery.lazyload.min.js');
?>

<div class="modal modal-gallery hide" id="galleryModal">
	<div class="modal-header">
		<a class="close" data-dismiss="modal"></a>
		<h4><i class="icon-picture"></i>Gallery</h4>
	</div>
	<div class="modal-body">
		<div class="image">
			<div class="image-selecter-nav">
				<a class="left" href="javascript:void(0);">&lsaquo;</a>
				<a class="right" href="javascript:void(0);">&rsaquo;</a>
			</div>	
				
			<div class="image-wrapper">	
				<img src="">
			</div>		
		</div>
		<div class="image-selecter-nav">
			<a class="left" href="javascript:void(0);">&lsaquo;</a>
			<a class="right" href="javascript:void(0);">&rsaquo;</a>
		</div>
		<div class="image-selecter">
			<div class="images">
				<!-- <li><img src="http://placehold.it/100x100"></li>
				<li><img src="http://placehold.it/100x100"></li> -->
			</div>
		</div>
	</div>
</div>

<script>
	
	/* Author: Zach Jones <zach@peacefulcomputing.com,zach@voxelinc.com,jonezach@gmail.com> */

	var GalleryView = Backbone.View.extend({
		
		//////////////////////////////////////////////////
		
		events: {
			'click .images img': 'click_to_load',
			'click .image-selecter-nav .left': 'click_left',
			'click .image-selecter-nav .right': 'click_right',
			'click .image .left' : 'click_to_load_left',
			'click .image .right' : 'click_to_load_right'
		},
		
		//////////////////////////////////////////////////
		
		click_to_load_right: function(event) {
			if(this.options.current_index < this.options.data.length - 1) {
				var attachment_id = parseInt(this.options.data[this.options.current_index+1]);
				this.load_image(attachment_id);
			}
		}, // end of click_to_load()
		
		//////////////////////////////////////////////////
		
		click_to_load_left: function(event) {
			if(this.options.current_index > 0) {
				var attachment_id = parseInt(this.options.data[this.options.current_index-1]);
				this.load_image(attachment_id);
			}
		}, // end of click_to_load()
		
		//////////////////////////////////////////////////
		
		click_to_load: function(event) {
			var attachment_id = $(event.currentTarget).data('attachment-id');
			this.load_image(attachment_id);
		}, // end of click_to_load()
		
		//////////////////////////////////////////////////
		
		render: function() {
			var thumbs = [];
			for (var i in this.options.data) {
				var attachment_id = this.options.data[i];
				thumbs.push('<div><img data-original="' + unlokt.settings.webroot + 'gen/attachment/' + attachment_id + '/100x100/default.jpg" data-attachment-id="' + attachment_id + '" class="lazy" width="100" height="100"></div>');
			}
			// Put the HTML string of thumbs into the thumb selector
			this.$('.images').html(thumbs.join(''));
			// Open the gallery as a modal.
			this.$el.modal();
			// Now that our thumbs are loaded, calculate how wide the container div needs to be in order to fit all the images in one row.
			// Then set the 'left: 0' property so that it starts all the way to the left.
			var container_div_width = (this.$('.images img').first().parent().width() + 5) * this.options.data.length;
			this.$('.images').width(container_div_width + 'px').css('left', 0);
			// Display the desired image.
			this.load_image(this.options.start_on_id != 0 ? this.options.start_on_id : this.options.data[0]);
			// Lazy load the images (i.e. make the images load as the user brings the images into viewport)
			this.$('.lazy').lazyload({
				container: this.$('.image-selecter'),
				threshold: 400
			});
		}, // end of render()
		
		//////////////////////////////////////////////////
		
		load_image: function(attachment_id) {
			// Make sure we're not initiating sliding mid-slide
			if (this.is_moving) {
				return;
			}
			this.$('.image img').attr('src', unlokt.settings.webroot + 'gen/attachment/' + attachment_id + '/0x450/default.jpg');
			// Attempt to center on the thumbnail
			var that = this;
			// Clear the 'active' class on all of the images
			this.$('.images img.active').removeClass('active');
			var $pic_container = this.$('.lazy[data-attachment-id="' + attachment_id + '"]').addClass('active').parent();
			//update current index
			this.options.current_index =  _.indexOf(this.options.data, attachment_id + "");
			//if current index is at the beginning or end, hide the proper left or right buttons
			$('.image .right, .image .left').show();
			if(this.options.current_index == 0) $('.image .left').hide(); //hide left button
			if(this.options.current_index == this.options.data.length - 1) $('.image .right').hide(); //hide right button
			
			var slider_width = this.$('.images').width();
			var container_width = this.$('.image-selecter').width();
			var slider_left = parseInt(this.$('.images').css('left').replace(/[^0-9]/, ''));
			if (isNaN(slider_left)) {
				slider_left = 0;
			}
			var side_of_thumb_space = (container_width - $pic_container.width()) / 2;
			var pic_container_left = $pic_container.position()['left'];
			var move_to_position = (pic_container_left * -1) + side_of_thumb_space;
			var maximum_right = (slider_width - container_width) * -1;
			if (move_to_position > 0) {
				move_to_position = 0;
			} else if (move_to_position < maximum_right && maximum_right < 0) {
				move_to_position = maximum_right;
			} else if (move_to_position < maximum_right && maximum_right >= 0) {
				move_to_position = 0;
			}
			this.is_moving = true;
			this.$('.images').animate({left: move_to_position + 'px'}, {
				complete: function() {
					that.is_moving = false;
					that.$('.lazy').lazyload({
						container: that.$('.image-selecter'),
						threshold: 400
					});
				}
			});
		}, // end of load_image()
		
		//////////////////////////////////////////////////
		
		click_right: function(event) {
			// Make sure we're not initiating sliding mid-slide
			if (this.is_moving) {
				return;
			}
			var that = this;
			var container_width = this.$('.image-selecter').width();
			var slider_width = this.$('.images').width();
			// If the slider isn't bigger than the container then there's no need to scroll.
			if (slider_width <= container_width) {
				return;
			}
			var distance_to_move = slider_width / 4;
			var slider_left = parseInt(this.$('.images').css('left').replace(/[^\-0-9]/, ''));
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
			this.is_moving = true;
			this.$('.images').animate({left: move_to_position + 'px'}, {
				complete: function() {
					that.is_moving = false;
					that.$('.lazy').lazyload({
						container: that.$('.image-selecter'),
						threshold: 400
					});
				}
			});
		}, // end of click_right()
		
		//////////////////////////////////////////////////
		
		click_left: function(event) {
			// Make sure we're not initiating sliding mid-slide
			if (this.is_moving) {
				return;
			}
			var that = this;
			var container_width = this.$('.image-selecter').width();
			var slider_width = this.$('.images').width();
			var distance_to_move = slider_width / 4;
			var slider_left = parseInt(this.$('.images').css('left').replace(/[^\-0-9]/, ''));
			// If the slider isn't bigger than the container then there's no need to scroll.
			if (slider_width <= container_width) {
				return;
			}
			if (isNaN(slider_left)) {
				slider_left = 0;
			} else if (slider_left > 0) {
				return;
			}
			if (distance_to_move > Math.abs(slider_left)) {
				distance_to_move = Math.abs(slider_left);
			}
			this.is_moving = true;
			this.$('.images').animate({left: '+=' + distance_to_move + 'px'}, {
				complete: function() {
					that.is_moving = false;
					that.$('.lazy').lazyload({
						container: that.$('.image-selecter'),
						threshold: 400
					});
				}
			});
		}, // end of click_left()
		
		//////////////////////////////////////////////////
		
		initialize: function(options) {
			// merge options into default options
			this.options = $.extend({
				// The ID of attachment to start on.
				// If 0, the first item in gallery will be shown.
				start_on_id: 0
			}, options);
			var that = this;
			if (!this.options.spot_id) {
				throw "Requires Spot ID";
			}
			// Call method to load the currently-request gallery.
			this.load_gallery(this.options.spot_id, this.options.start_on_id);
			// Keep track of whether or not the slider is already going.
			this.is_moving = false;
		}, // end of initialize
		
		//////////////////////////////////////////////////
		
		load_gallery: function(spot_id, attachment_id) {
			var that = this;
			this.options.spot_id = spot_id;
			this.options.start_on_id = attachment_id;
			$.get(unlokt.settings.webroot + 'attachments/gallery/' + this.options.spot_id, function(data) {
				// Parse the data we have - parse it as JSON
				data = JSON.parse(data);
				// Set the data object on our options & render the content.
				that.options.data = data;
				that.render();
			});
		} // end of load_gallery()
	});
	
	//////////////////////////////////////////////////

</script>