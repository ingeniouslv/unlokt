<?php
$this->set('title_for_layout', h($spot['Spot']['name']));
?>

<div class="main-content page deal">
	<div class="container">
		<div class="row">
			<div class="three columns">
				<?php echo $this->Form->create('Manager', array('class' => 'form-vertical control-group')); ?>
				
				<?php echo $this->Form->hidden('spot_id', array('value' => $spot['Spot']['id'])); ?>
				
				<?php echo $this->Form->input('email', array('div' => 'control-fields', 'class' => 'input-full', 'label' => false, 'placeholder' => 'Email')); ?>
				<?php echo $this->Form->input('is_admin', array('div' => 'control-fields', 'class' => 'input-full', 'label' => 'Admin')); ?>
				
				<div class="btn-group">
					<?php echo $this->Form->submit('Create Manager', array('div' => false, 'class' => 'btn btn-blue')); ?>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>	
		</div>
	</div>
</div>
