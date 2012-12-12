<?php
$this->set('title_for_layout', "Add a Spot Special to '". h($spot['Spot']['name']). "'");
?>
<div class="main-content page deal">
	<div class="container">
		<h1>Create a Spot Special</h1>

		<div class="row">
			<div class="six columns tracked-content">
				<!-- Create iframe for POSTing a photo upload in the background -->
				<iframe id="upload-preview-image-iframe" class="hide"></iframe>
				<h2 class="form-section-label">Picture</h2>
				<?php
				//////////////////////////////////////////////////
				// Create a form JUST FOR SENDING PICTURE VIA IFRAME
				echo $this->Form->create(false, array('class' => 'form-vertical control-group', 'url' => array('action' => 'upload_preview_image'), 'target' => 'upload-preview-image-iframe', 'type' => 'file'));
				echo $this->Form->input('file', array('div' => 'control-fields', 'label' => false, 'class' => 'twelve', 'type' => 'file', 'data-type' => 'file-input'));
				echo $this->Form->end();
				
				//////////////////////////////////////////////////
				// Start a new form for the rest of the Deal.
				echo $this->Form->create('Deal', array('class' => 'form-vertical control-group'));
				// Create hidden input to hold temporary image name.
				// This will be used on the back end to match up the uploaded picture.
				echo $this->Form->hidden('tmp_image_name');
				?>
				
				<h2 class="form-section-label">Information</h2>
				<?php echo $this->Form->input('name', array('div' => 'control-fields', 'label' => false, 'class' => 'twelve', 'placeholder' => 'Spot Special Title')); ?>

				<h2 class="form-section-label">Description</h2>
				<?php echo $this->Form->input('description', array('div' => 'control-fields', 'label' => false, 'class' => 'twelve', 'placeholder' => 'Description')); ?>
				<?php echo $this->Form->input('long_description', array('div' => 'control-fields', 'label' => false, 'class' => 'twelve', 'placeholder' => 'Long Description')); ?>
				<?php echo $this->Form->input('fine_print', array('div' => 'control-fields', 'label' => false, 'class' => 'twelve', 'placeholder' => 'Fine Print')); ?>

				<h2 class="form-section-label">Details</h2>
				<?php echo $this->Form->input('start_date', array('type' => 'text', 'div' => 'control-fields', 'class' => 'datepicker')); ?>
				<?php echo $this->Form->input('end_date', array('type' => 'text', 'div' => 'control-fields', 'class' => 'datepicker')); ?>
				<?php echo $this->Form->input('all_day', array('type' => 'checkbox', 'div' => 'control-fields')); ?>
				<div id="timeframe" class="control-fields">
					<?php echo $this->Form->input('start_time', array('type' => 'text', 'div' => 'control-fields', 'class' => 'timepicker', 'value' => '')); ?>
					<?php echo $this->Form->input('end_time', array('type' => 'text', 'div' => 'control-fields', 'class' => 'timepicker', 'value' => '')); ?>
				</div>
				<div class="control-fields inline-radios">
					<?php echo $this->Form->radio('quick_options', array('every_day' => 'Every Day', 'weekdays' => 'Weekdays', 'weekends' => 'Weekends', 'custom' => 'Custom'), array('type' => 'radio', 'div' => 'control-fields inline-radios', 'legend' => false, 'selected' => 'every_day')); ?>
				</div>
				<div id="days-of-the-week" class="control-fields inline-checkboxes">
					<?php echo $this->Form->input('sunday', array('class' => 'checkbox', 'checked', 'label' => 'Sun')); ?>
					<?php echo $this->Form->input('monday', array('class' => 'checkbox', 'checked', 'label' => 'Mon')); ?>
					<?php echo $this->Form->input('tuesday', array('class' => 'checkbox', 'checked', 'label' => 'Tue')); ?>
					<?php echo $this->Form->input('wednesday', array('clas' => 'checkbox', 'checked', 'label' => 'Wed')); ?>
					<?php echo $this->Form->input('thursday', array('class' => 'checkbox', 'checked', 'label' => 'Thu')); ?>
					<?php echo $this->Form->input('friday', array('class' => 'checkbox', 'checked', 'label' => 'Fri')); ?>
					<?php echo $this->Form->input('saturday', array('class' => 'checkbox', 'checked', 'label' => 'Sat')); ?>
				</div>
				<?php echo $this->Form->input('is_active', array('div' => 'control-fields')); ?>
				<?php echo $this->Form->input('is_public', array('div' => 'control-fields')); ?>


				<div class="row">
					<div class="five columns">
						<h2 class="form-section-label">Keys</h2>
						<?php echo $this->Form->input('keys', array('div' => 'control-fields', 'readonly', 'class' => 'twelve')); ?>
						<div class="btn-group">
							<a href="javascript:void(0);" class="btn btn-primary" id="increase-keys">More Keys</a>
							<a href="javascript:void(0);" class="btn btn-primary" id="decrease-keys">Less Keys</a>
						</div>
					</div>
					<div id="redemption-codes" class="seven columns">
						<h2 class="form-section-label">Redemption Code for Each Key</h2>
						<?php for ($i = 1; $i <= $this->request->data['Deal']['keys']; $i ++): ?>
							<?php echo $this->Form->input("redemption_$i", array('label' => "Redemption Code for Key #$i", 'div' => 'control-fields input text required', 'class' => 'twelve')); ?>
						<?php endfor; ?>
					</div>
				</div>

				<h2 class="form-section-label">Settings</h2>
				<?php echo $this->Form->input('sku', array('div' => 'control-fields', 'label' => 'SKU (for entering into your POS system)')); ?>
				<?php echo $this->Form->input('limit_per_customer', array('div' => 'control-fields', 'label' => 'Limit per Customer (0 = unlimited)', 'type' => 'text')); ?>

				<div class="btn-group">
					<?php echo $this->Form->button('Create Spot Special', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
			
			<div class="three pull-right">
				<!-- The Deal preview tile will be rendered here via Backbone. Don't remove this empty div =] -->
				<div class="fixed-element" id="dealPreview"></div>
			</div> 
		</div>
	</div>
</div>

<script>

	//////////////////////////////////////////////////
	
	// When an image is selected, automatically POST it.
	// We do this function after ready setTimeout funkyness because the #file DOM input is changed by $.fileInput()
	$(function() {
		setTimeout(function() {
			$('#file').on('change', function() {
				var file = $(this).val();
				if (file != '') {
					$('#addForm').submit();
				}
			});
		}, 200);
	});
	
	//////////////////////////////////////////////////
	
	// upload_preview_image_postback(filename) will be called when someone selects a photo to upload.
	// When a photo is selected, the <form> is submitted to a hidden iframe.
	// When the iframe receives the photo it will call this postback function to update the filename and preview image [src]
	function upload_preview_image_postback(filename) {
		$('#DealTmpImageName').val(filename);
		// Change the tmp_image_name on the model and then trigger a change in order to re-render the preview tile.
		dealpreview.attributes.Deal.tmp_image_name = filename;
		dealpreview.trigger('change');
	}

	//////////////////////////////////////////////////
	
	// Create a Backbone model and view for the preview tile.
	var DealPreviewView = Backbone.View.extend({
		initialize: function() {
			this.template = _.template(this.options.template);
			this.model.on('reset change', this.render, this);
			this.render();
		},
		render: function() {
			this.$el.html(this.template({deal: this.model.toJSON()}));
		}
	});
	var dealpreview = new Backbone.Model(<?php echo @json_encode($deal); ?>);
	var dealpreviewview = new DealPreviewView({
		model: dealpreview,
		el: $('#dealPreview'),
		template: templates['mod-add_deal_preview']
	});

	//////////////////////////////////////////////////

	// Add listeners to all inputs so that the preview Deal tile continually updates upon edit
	$('input, textarea').on('keyup change', function() {
		dealpreview.set({Deal: $('#DealAddForm').Cake2JSON()});
	});
	
	//////////////////////////////////////////////////
	
	// When someone chooses a picture, upload it to an iframe and update tmp_image_name with a new value
	$('#DealFile').change(function() {
		console.log($(this).val());
	});

	//////////////////////////////////////////////////
	
	function toggleTimeFrame() {
		if ($('#DealAllDay:checked').size()) {
			$('#timeframe').hide();
			$('#DealStartTime').attr('value', '');
			$('#DealEndTime').attr('value', '');
		} else {
			$('#timeframe').show();
		}
	}
	
	$('#DealAllDay').click(toggleTimeFrame);
	
	$('#DealAllDay').attr('checked', true);
	toggleTimeFrame();
	
	$('#DealQuickOptionsEveryDay').click(function() {
		//everyday
		$("#days-of-the-week").hide();
		setDays(true, true, true, true, true, true, true);
	});
	$('#DealQuickOptionsWeekdays').click(function() {
		//weekdays
		$("#days-of-the-week").hide();
		setDays(false, true, true, true, true, true, false);
	});
	$('#DealQuickOptionsWeekends').click(function() {
		//weekends
		$("#days-of-the-week").hide();
		setDays(true, false, false, false, false, false, true);
	});
	$('#DealQuickOptionsCustom').click(function() {
		//custom
		$("#days-of-the-week").show();
	});
	$('#DealQuickOptionsEveryDay').click();
	
	//////////////////////////////////////////////////
	
	function setDays(sunday, monday, tuesday, wednesday, thursday, friday, saturday) {
		$('#DealSunday').attr('checked', sunday);
		$('#DealMonday').attr('checked', monday);
		$('#DealTuesday').attr('checked', tuesday);
		$('#DealWednesday').attr('checked', wednesday);
		$('#DealThursday').attr('checked', thursday);
		$('#DealFriday').attr('checked', friday);
		$('#DealSaturday').attr('checked', saturday);
	}
	
	//////////////////////////////////////////////////
	
	$('#increase-keys').click(function() {
		var new_number_of_keys = parseInt($('#DealKeys').val())+1;
		$('#DealKeys').val(new_number_of_keys).trigger('change');
		$('#redemption-codes').append('<div class="control-fields input text required"><label for="DealRedemption' + new_number_of_keys + '">Redemption Code for Key #' + new_number_of_keys + '</label><input name="data[Deal][redemption_' + new_number_of_keys + ']" type="text" id="DealRedemption' + new_number_of_keys + '" class="twelve"/></div>');
	});
	$('#decrease-keys').click(function() {
		var current_number_of_keys = parseInt($('#DealKeys').val());
		if (current_number_of_keys == 0) {
			return;
		}
		var new_number_of_keys = parseInt($('#DealKeys').val())-1;
		$('#DealKeys').val(new_number_of_keys).trigger('change');
		$('#DealRedemption' + current_number_of_keys).closest('div').remove();
	});
	
	//////////////////////////////////////////////////
	
</script>
