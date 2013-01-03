<?php
$this->set('title_for_layout', "Edit Spot Option '".$this->data['SpotOption']['name']."'");
?>
<div class="main-content page spot-option">
	<div class="container">
		<h1>Edit Spot Option</h1>
		<div class="row">
			<div class="six columns">
				<?php echo $this->Form->create('SpotOption', array( 'class' => array('form-vertical control-group'))); ?>
				
					<?php echo $this->Form->hidden('id'); ?>
					
					<h2 class="form-section-label">Spot Option Information</h2>
					<?php
						echo $this->Form->input('name');
						echo $this->Form->input('css_class'), array('div' => 'control-fields', 'class' => 'input-full');
						echo $this->Form->input('Spot', array('div' => 'control-fields'));
					?>
					<div class="btn-group">
						<?php echo $this->Form->submit('Update Spot Option', array('div' => false, 'class' => 'btn btn-blue')); ?>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
