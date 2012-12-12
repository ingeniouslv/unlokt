/* =========================================================
 * voxel-fileinput.js v1.0.0
 * http://voxelinc.com
 * Copyright 2012 Voxel, Inc.
 * Author: Zach Jones <zach@peacefulcomputing.com>
 * ========================================================= */

!function ($) {

	"use strict";

	/* File Input Plugin
	 * ================= */
	$.fn.fileInput = function() {
		if (!this.length) {
			return;
		}
		$.each(this, function(index, obj) {
			// Grab the DOMElement instead of using the jQuery object.
			var el = obj;
			// Is the current <input multiple>? If so, change the words to plural.
			var multiple = !!$(this).prop('multiple');
			// Create DIV element for holding our new INPUT and associated elements.
			var parentDiv = document.createElement('div');
			parentDiv.className = 'file-input';
			var browseSpan = document.createElement('span');
			if (multiple) {
				browseSpan.appendChild(document.createTextNode('Choose Files'));
			} else {
				browseSpan.appendChild(document.createTextNode('Choose File'));
			}
			browseSpan.className = 'browse';
			var filenameSpan = document.createElement('span');
			if (multiple) {
				filenameSpan.appendChild(document.createTextNode('No Files Chosen'));
			} else {
				filenameSpan.appendChild(document.createTextNode('No File Chosen'));
			}
			filenameSpan.className = 'filename';
			var fileInput = document.createElement('input');
			fileInput.className = 'input';
			fileInput.setAttribute('type', 'file');
			if (multiple) {
				fileInput.setAttribute('multiple', 'multiple');
			}
			// Retain the same [name], [id] attribute
			fileInput.setAttribute('name', el.getAttribute('name'));
			var original_id = el.getAttribute('id');
			if (original_id) {
				fileInput.setAttribute('id', original_id);
			}
			// Add event listener to the <input> to trigger changing of text when files are selected.
			$(fileInput).on('change', function() {
				var name = $(this).val().split('\\').pop();
				if (name != '') {
					if (multiple) {
						$(this).siblings('.browse').html('Files Chosen');
						$(this).siblings('.filename').html(name);
					} else {
						$(this).siblings('.browse').html('File Chosen');
						$(this).siblings('.filename').html(name);
					}
				} else {
					if (multiple) {
						$(this).siblings('.browse').html('Choose Files');
						$(this).siblings('.filename').html('No Files Chosen');
					} else {
						$(this).siblings('.browse').html('Choose File');
						$(this).siblings('.filename').html('No File Chosen');
					}
				}
			});
			
			// Put the elements inside the parentDiv in the correct order.
			parentDiv.appendChild(browseSpan);
			parentDiv.appendChild(filenameSpan);
			parentDiv.appendChild(fileInput);
			
			// Put the new parentDiv we created before the original <input>, 
			// then delete the old node from the tree.
			el.parentNode.insertBefore(parentDiv, el);
			el.parentNode.removeChild(el);
		}); // end of $.each()
	};

	/* File Input Data-API
	 * =================== */
	$(function () {
		$('[data-type="file-input"]').fileInput();
	});

}(window.jQuery);

/* 

Turn:
	<input type="file" data-type="file-input">
	
Into:
	<div class="file-input">
		<span class="browse">Choose File</span>
		<span class="filename">No file chosen</span>
		<input type="file" data-type="file-input" class="input">
	</div>

Note:
If	<input type="file" multiple>
	span.browse = "Choose Files"
	span.filename = "No Files Chosen"

*/