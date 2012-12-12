<?php
$this->set('title_for_layout', "Edit User '".h($this->data['User']['first_name']. ' '. $this->data['User']['last_name'])."'");
?>
<div class="main-content page user">
	<div class="container">
		<h1>Edit User</h1>
		<div class="row">
			<div class="six columns">
				<?php echo $this->Form->create('User', array( 'class' => array('form-vertical control-group'))); ?>
				
					<?php echo $this->Form->hidden('id'); ?>
					
					<h2 class="form-section-label">User Information</h2>
					<?php
						echo $this->Form->input('first_name', array('div' => 'control-fields', 'class' => 'input-full required', 'label' => false, 'placeholder' => 'First Name'));
						echo $this->Form->input('last_name', array('div' => 'control-fields', 'class' => 'input-full required', 'label' => false, 'placeholder' => 'Last Name'));
						echo $this->Form->input('email', array('div' => 'control-fields', 'class' => 'input-full required', 'label' => false, 'placeholder' => 'Email'));
						echo $this->Form->input('password', array('div' => 'control-fields', 'class' => 'input-full required', 'label' => false, 'placeholder' => 'Password'));
						echo $this->Form->input('password2', array('div' => 'control-fields', 'class' => 'input-full required', 'label' => false, 'placeholder' => 'Confirm Password', 'type' => 'password'));
						echo $this->Form->input('is_active', array('div' => 'control-fields', 'label', 'Active'));
						echo $this->Form->input('is_super_admin', array('div' => 'control-fields', 'label' => 'Super Admin'));
					?>
					<div class="btn-group">
						<a class="btn" href="">Cancel</a>
						<?php echo $this->Form->submit('Update User', array('div' => false, 'class' => 'btn btn-blue')); ?>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
