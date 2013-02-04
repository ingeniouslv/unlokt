<?php
$this->set('title_for_layout', "Editing Location '".h($this->data['Location']['name'])."'");
?>
<div class="main-content page">
	<div class="container">
		<h1>Edit Location</h1>
		<div class="row">
			<div class="six columns">
				<?php echo $this->Form->create('Location', array( 'class' => array('form-vertical control-group'))); ?>
				
					<?php echo $this->Form->hidden('id'); ?>
					
					<h2 class="form-section-label">Location Information</h2>
					<?php
						echo $this->Form->input('name', array('div' => 'control-fields', 'class' => 'input-full required', 'label' => 'Name'));
						echo $this->Form->input('lat', array('div' => 'control-fields', 'class' => 'input-full required', 'label' => 'Latitude'));
						echo $this->Form->input('lng', array('div' => 'control-fields', 'class' => 'input-full required', 'label' => 'Longitude'));
						echo $this->Form->input('is_active', array('div' => 'control-fields', 'class' => 'input-full required', 'label' => 'Active'));
					?>
					<div class="btn-group">
						<a class="btn" href="">Cancel</a>
						<?php echo $this->Form->submit('Update Location', array('div' => false, 'class' => 'btn btn-blue')); ?>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>