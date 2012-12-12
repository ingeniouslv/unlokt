<?php
$this->set('title_for_layout', 'Add Plan');
?>
<div class="main-content page plan">
	<div class="container">
		<h1>Create a New Plan</h1>
		<div class="row">
			<div class="six columns">
				<?php echo $this->Form->create('Plan', array( 'class' => array('form-vertical control-group'))); ?>
				
					<h2 class="form-section-label">Plan Information</h2>
					<?php
						echo $this->Form->input('name', array('div' => 'control-fields', 'class' => 'input-full', 'label' => false, 'placeholder' => 'Name'));
						echo $this->Form->input('months', array('div' => 'control-fields', 'class' => 'input-full', 'label' => false, 'placeholder' => 'Months'));
						echo $this->Form->input('price');
						echo $this->Form->input('is_public');
					?>
					<div class="btn-group">
						<?php echo $this->Form->submit('Create Plan', array('div' => false, 'class' => 'btn btn-blue')); ?>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
