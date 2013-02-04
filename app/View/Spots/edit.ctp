<?php
$this->set('title_for_layout', "Editing Spot '".h($spot['Spot']['name']))."'";
?>
<div class="main-content page spot">
	<div class="container">
		<h1>Edit Spot <?php echo $this->Html->link($spot['Spot']['name'], array('action' => 'view', $spot['Spot']['id'])); ?></h1>
		<div class="row">
			<div class="six columns">
				<?php echo $this->Form->create('Spot', array('class' => 'form-vertical control-group', 'type' => 'file')); ?>
				<h2 class="form-section-label">Spot Picture</h2>
				<img src="<?php echo $this->Html->gen_path('spot', $spot['Spot']['id'], 200, null, $spot['Spot']['image_name']); ?>?<?php echo time(); ?>"><br>
				<input type="file" name="file" data-type="file-input"><br>
				
				<h2 class="form-section-label">Information</h2>
				<?php echo $this->Form->input('name', array('div' => 'control-fields', 'class' => 'input-full', 'placeholder' => 'Name', 'name' => 'name')); ?>
				<?php echo $this->Form->input('parent_spot_id', array('div' => 'control-fields', 'class' => 'input-full', 'options' => $parentSpots, 'empty' => 'No Parent Spot')); ?>
				
				<h2 class="form-section-label">Location</h2>
				<?php
				// Allow admins to pick Location for Spot
				if ($this->Auth->user('is_super_admin')) {
					echo $this->Form->input('location_id');
				}
				echo $this->Form->input('address', array('div' => 'control-fields', 'class' => 'input-full', 'placeholder' => 'Address'));
				echo $this->Form->input('address2', array('div' => 'control-fields', 'class' => 'input-full', 'placeholder' => 'Address 2'));
				?>
				<div class="control-group row">
					<div class="seven columns">
						<?php echo $this->Form->input('city', array('div' => 'control-fields', 'class' => 'input-full', 'placeholder' => 'City')); ?>
					</div>
					<div class="two columns">
						<?php echo $this->Form->input('state', array('div' => 'control-fields', 'class' => 'input-full', 'placeholder' => 'State')); ?>
					</div>
					<div class="three columns">
						<?php echo $this->Form->input('zip', array('div' => 'control-fields', 'class' => 'input-full', 'placeholder' => 'ZIP / Postal')); ?>
					</div>
				</div>

				<h2 class="form-section-label">Latitude &amp; Longitude</h2>
				<div class="control-group row" id="coordinates-automatic">
					<div class="columns">
						Latitude and Longitude coordinates are calculated automatically. If you wish to manually input the coordinates, click the button below.
						<div>
							<a class="btn" id="coordinates-manual-button">Switch to manual coordinate input</a>
						</div>
					</div>
				</div>
				<div class="control-group row hide" id="coordinates-manual">
					<div class="six columns">
						<?php echo $this->Form->input('lat', array('div' => 'control-fields', 'placeholder' => 'Latitude', 'class' => 'input-full', 'disabled' => 'disabled')); ?>
					</div>
					<div class="six columns">
						<?php echo $this->Form->input('lng', array('div' => 'control-fields', 'placeholder' => 'Logitude', 'class' => 'input-full', 'disabled' => 'disabled')); ?>
					</div>
					<div class="columns">
						<a class="btn" id="coordinates-automatic-button">Switch to automatic coordinate lookup</a>
					</div>
				</div>
				<script>
					// Script for toggling the coordinate lookup divs.
					$('#coordinates-manual-button').click(function() {
						$('#coordinates-automatic').hide();
						$('#coordinates-manual').show().find('input').attr('disabled', false);
					});
					$('#coordinates-automatic-button').click(function() {
						$('#coordinates-manual').hide().find('input').attr('disabled', true);
						$('#coordinates-automatic').show();
					});
				</script>

				<h2 class="form-section-label">Details</h2>
				<?php
				echo $this->Form->input('phone', array('div' => 'control-fields', 'placeholder' => '(702) 987-3333'));
				echo $this->Form->input('url', array('div' => 'control-fields', 'label' => 'URL', 'placeholder' => 'http://www.example.com', 'class' => 'input-full'));
				echo $this->Form->input('email', array('div' => 'control-fields', 'label' => 'Business Email', 'placeholder' => 'info@example.com', 'class' => 'input-full'));
				?>
				<h2 class="form-section-label">Categories</h2>
				<?php echo $this->Form->select('Category', $categories, array('div' => 'control-fields', 'class' => 'input-full', 'multiple' => 'checkbox')); ?>
				<h2 class="form-section-label">Spot Options</h2>
				<?php echo $this->Form->select('SpotOption', $spotOptions, array('div' => 'control-fields', 'class' => 'input-full', 'multiple' => 'checkbox')); ?>

				<h2 class="form-section-label">Profile</h2>
				<?php echo $this->Form->input('spotlight_1', array('div' => 'control-fields', 'label' => 'Spotlight', 'class' => 'spot-spotlight_1-editor tinymce')); ?>
				<?php echo $this->Form->input('description', array('div' => 'control-fields', 'class' => 'spot-description-editor tinymce')); ?>
				<?php echo $this->Form->input('spotlight_2', array('div' => 'control-fields', 'label' => 'Spotlight Mini', 'class' => 'spot-spotlight_2-editor tinymce')); ?>
				
				<h2 class="form-section-label">Social Media</h2>
				<?php
					echo $this->Form->input('facebook_url', array('div' => 'control-fields', 'label' => 'Facebook', 'class' => 'input-full'));
					echo $this->Form->input('twitter_url', array('div' => 'control-fields', 'label' => 'Twitter', 'class' => 'input-full'));
					echo $this->Form->input('instagram_url', array('div' => 'control-fields', 'label' => 'Instagram', 'class' => 'input-full'));
				?>
				
				<?php if($this->Auth->user('is_super_admin')) : ?>
					<h2 class="form-section-label">Super Admin Controls</h2>
						<?php echo $this->Form->input('is_active', array('div' => 'control-fields', 'label' => 'Active')); ?>
						<?php echo $this->Form->input('is_premium', array('div' => 'control-fields', 'label' => 'Premium')); ?>
						<?php echo $this->Form->input('is_pending', array('label' => 'Spot is Pending Approval')); ?>
				<?php endif; ?>

				<div class="btn-group">
					<?php echo $this->Form->submit('Update Spot', array('div' => false, 'class' => 'btn btn-blue')); ?>
				</div>
			<?php echo $this->Form->end(); ?>
			</div>

			<div class="four columns">
				<div class="block block-white">
					<h4>Tip</h4>
					<p><strong>Looking to manage Happy Hour settings?<br>Head to <a href="/happy_hours/manage/<?php echo $spot['Spot']['id']; ?>">Happy Hours</a> to manage them.</strong></p>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	$().ready(function() {
		
		$('textarea.spot-spotlight_2-editor.tinymce, textarea.spot-description-editor.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '<?php echo $this->webroot; ?>js/libs/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "paste",

			// Theme options
			theme_advanced_buttons1 : ",newdocument,|,bold,italic,underline,strikethrough,|,cut,copy,paste,pastetext,pasteword,|,formatselect,",
			theme_advanced_buttons2 : ",undo,redo,|,link,unlink,image,cleanup,code,|,forecolor,",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : "<?php echo $this->webroot; ?>css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
		
		$('textarea.spot-spotlight_1-editor.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '<?php echo $this->webroot; ?>js/libs/tiny_mce/tiny_mce.js',

			// General options
			theme : "advanced",
			plugins : "paste",

			// Theme options
			theme_advanced_buttons1 : ",newdocument,|,bold,italic,underline,strikethrough,|,cut,copy,paste,pastetext,pasteword,|,formatselect,",
			theme_advanced_buttons2 : ",undo,redo,|,link,unlink,image,cleanup,code,|,",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			content_css : "<?php echo $this->webroot; ?>css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});
	});
</script>