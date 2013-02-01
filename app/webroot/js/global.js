if (typeof com == 'undefined') {
	var com = {};
}

com.unlokt = function(settings) {
	// Take in settings given at startup.
	this.settings = $.extend({
		base_url: 'http://unlokt.com',
		use_static_domain: false
	}, settings);
	// Initialize the rest of this object by calling init()
	this.init();
};

com.unlokt.prototype.init = function() {
	// Make an object to hold our global junk.
	this.data = {};
};

com.unlokt.prototype.check_privileges = function() {
	if (typeof auth === 'undefined' || auth == null) {
		// Open the 'Not Authenticated' modal.
		alert('You are not logged in. This alert will eventually be a modal.');
		throw "Not Authenticated";
	}
};

com.unlokt.prototype.helpers = {
	
	// Helper function to generate a URI for loading images.
	gen_path: function(type, id, width, height, file) {
		if (typeof type === 'undefined' || typeof id === 'undefined' || typeof width === 'undefined') {
			throw 'Missing a required parameter.';
		}
		// Must be a square image if the height is undefined.
		if (typeof height == 'undefined' || height == null) {
			height = width;
		}
		if (typeof file == 'undefined') {
			file = 'default.jpg';
		}
		if (unlokt.settings.use_static_domain) {
			return unlokt.settings.static_domain + unlokt.settings.webroot + 'gen/' + type + '/' + id + '/' + width + 'x' + height + '/' + file;
		} else {
			return unlokt.settings.webroot + 'gen/' + type + '/' + id + '/' + width + 'x' + height + '/' + file;
		}
	}
};

$(function() {
	prepare_window_scroll_lock();
	match_body_padding_with_footer();
	bind_general_user_actions();
	$('.timepicker').timepicker();
	$('.datepicker').datepicker();
	// $('[data-type="editor"]').htmlarea({
	// 	toolbar: [
	// 		["bold", "italic", "underline", "|", "forecolor"],
	// 		["p", "h1", "h2", "h3", "h4", "h5", "h6"],
	// 		["link", "unlink", "|", "image"]
	// 	],
	// 	css: '/css/jhtml.css'
	// });
});

/* Author: Zach Jones <zach@peacefulcomputing.com>
 * When the window is scrolling, we need to track the position of the
 * viewport so we can adjust the nagivation bar on the left.
 */
function prepare_window_scroll_lock() {
	unlokt.data.$content = $('.main-content .tracked-content');
	unlokt.data.$sidebar = $('.main-content .fixed-element');
	// Make sure both items exist. If not, return early like a noob.
	if (!unlokt.data.$content.length || !unlokt.data.$sidebar.length) {
		return;
	}
	$(window).scroll(function() {
		var threshold = unlokt.data.$content.position().top + unlokt.data.$content.height() - $(window).scrollTop();
		if (threshold < unlokt.data.$sidebar.height()) {
			unlokt.data.$sidebar.addClass('sidebar-absolute-bottom');
		} else {
			unlokt.data.$sidebar.removeClass('sidebar-absolute-bottom');
		}
	});
}

function match_body_padding_with_footer() {
	$('#body-container').css('padding-bottom', $('footer').height());
	$('footer').css('margin-top', $('footer').height() * -1);
}

// Login Modal Prompt
$(function() {
	$('#login-modal').modal();
});

// Our lovely global h() function for htmlspecialchars()
function h(unsafe) {
  return unsafe
      .replace(/&/g, "&amp;")
      .replace(/</g, "&lt;")
      .replace(/>/g, "&gt;")
      .replace(/"/g, "&quot;")
      .replace(/'/g, "&#039;");
}

// Add left-pad functionality to javascript's String type.
String.prototype.lpad = function(padString, length) {
	var str = this;
    while (str.length < length)
        str = padString + str;
    return str;
}

String.prototype.repeat = function(num) {
    return new Array(parseInt(num) + 1).join(this);
}

// Extend jQuery functionality.
// Cake2JSON accepts inputs to serialize from cake-formatted inputs (data[Model][property]) and
// turns it into {property: value}
$.fn.Cake2JSON = function() {
	var json = {};
	jQuery.map($(this).serializeArray(), function(n, i) {
		// Grab the name of the key based upon CakePHP's way of formatting names.
		var name = n['name'].replace(/data\[\w+\]\[(\w+)\]/, '$1');
		if (!name || name == '') {
			throw "Expected to have a value for name";
		}
		json[name] = n['value'];
	});
	return json;
};

// Main function for opening a Gallery of images for a spot.
// Accepts optional Attachment ID for displaying that attachment.
function start_gallery(spot_id, attachment_id) {
	if (typeof attachment_id == 'undefined') {
		// If there's no attachment ID, use 0 and gallery will start at the beginning.
		attachment_id = 0;
	}
	if (typeof window.galleryview == 'undefined') {
		window.galleryview = new GalleryView({
			el: $('#galleryModal'),
			spot_id: spot_id,
			start_on_id: attachment_id
		});
	} else {
		window.galleryview.load_gallery(spot_id, attachment_id);
	}
}

function bind_general_user_actions() {
	
	//////////////////////////////////////////////////
	
	// DELETING FEEDS
	$('.delete-feed').click(function() {
		if (!confirm('Are you sure you want to permanently delete this Feed?')) {
			return;
		}
		var feed_id = $(this).data('feed-id');
		var $that = $(this);
		$.post(unlokt.settings.webroot + 'feeds/delete/' + feed_id, function() {
			$that.closest('.feed-item').remove();
		});
	});
	
	//////////////////////////////////////////////////
	
	// Flagging reviews for review.
	$('body').on('click', '[data-flag-review]', function() {
		if (!confirm('Are you sure you want to flag this Note? An administrator will review this Note.')) {
			return;
		}
		var review_id = $(this).data('flag-review');
		var $that = $(this);
		$.get(unlokt.settings.webroot + 'reviews/flag_review/' + review_id, function(data) {
			if (data != 'Review Flagged') {
				alert('Something went wrong.');
			}
		});
	});
	
	//////////////////////////////////////////////////
}

// Make sure our Windows/IE users aren't ever receiving javascript errors because of stray console.log()s.
if (typeof console == 'undefined') {
	var console = {
		log: function(log) {
			// Do nothing.
		}
	};
}

//

$(document).ready(function() {
	// Target <select> tags which are not 'multiple' or 'data-no-sb'
  
});

(function($) {


	// Return if native support is available.
	if ("placeholder" in document.createElement("input")) return;

	$(document).ready(function(){
		$(':input[placeholder]').not(':password').each(function() {
			setupPlaceholder($(this));
		});

		$(':password[placeholder]').each(function() {
			setupPasswords($(this));
		});

		$('form').submit(function(e) {
			clearPlaceholdersBeforeSubmit($(this));
		});
	});

	function setupPlaceholder(input) {

		var placeholderText = input.attr('placeholder');

		setPlaceholderOrFlagChanged(input, placeholderText);
		input.focus(function(e) {
			if (input.data('changed') === true) return;
			if (input.val() === placeholderText) input.val('');
		}).blur(function(e) {
			if (input.val() === '') input.val(placeholderText); 
		}).change(function(e) {
			input.data('changed', input.val() !== '');
		});
	}

	function setPlaceholderOrFlagChanged(input, text) {
		(input.val() === '') ? input.val(text) : input.data('changed', true);
	}

	function setupPasswords(input) {
		var passwordPlaceholder = createPasswordPlaceholder(input);
		input.after(passwordPlaceholder);

		(input.val() === '') ? input.hide() : passwordPlaceholder.hide();

		$(input).blur(function(e) {
			if (input.val() !== '') return;
			input.hide();
			passwordPlaceholder.show();
		});

		$(passwordPlaceholder).focus(function(e) {
			input.show().focus();
			passwordPlaceholder.hide();
		});
	}

	function createPasswordPlaceholder(input) {
		return $('<input>').attr({
			placeholder: input.attr('placeholder'),
			value: input.attr('placeholder'),
			id: input.attr('id'),
			readonly: false
		}).addClass(input.attr('class'));
	}

	function clearPlaceholdersBeforeSubmit(form) {
		form.find(':input[placeholder]').each(function() {
			if ($(this).data('changed') === true) return;
			if ($(this).val() === $(this).attr('placeholder')) $(this).val('');
		});
	}
})(jQuery);