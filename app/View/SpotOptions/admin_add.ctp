<?php
$this->set('title_for_layout', 'Add Spot Option');
?>
<div class="main-content page spot-option">
	<div class="container">
		<h1>Create a New Spot Option</h1>
		<div class="row">
			<div class="six columns">
				<?php echo $this->Form->create('SpotOption', array( 'class' => array('form-vertical control-group'))); ?>
				
					<h2 class="form-section-label">Plan Information</h2>
					<?php
						echo $this->Form->input('name', array('div' => 'control-fields', 'class' => 'input-full', 'placeholder' => 'Name'));
						echo $this->Form->input('css_class', array('div' => 'control-fields', 'class' => 'input-full', 'placeholder' => 'CSS Class'));
						echo $this->Form->input('Spot', array('div' => 'control-fields', 'class' => 'input-full', 'options' => $spots));
					?>
					<div class="btn-group">
						<?php echo $this->Form->submit('Create Spot Option', array('div' => false, 'class' => 'btn btn-blue')); ?>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>