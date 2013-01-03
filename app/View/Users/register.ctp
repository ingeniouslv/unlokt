<?php
$this->set('title_for_layout', 'Register for Free Account');
?>
<div class="main-content page">
	<div class="container">	
		<div class="row columns eight">
				<h1 class="page-header">Register for an Account</h1>
			<?php
			echo $this->Form->create('User', array('class' => 'control-group form-vertical'));
			?>
				<div class="row control-fields">
					<div class="two columns">
						<?php echo $this->Form->label('first_name', 'Name'); ?>
					</div>
					<?php echo $this->Form->input('first_name', array('class' => 'twelve', 'label' => false, 'div' => 'five columns', 'placeholder' => 'First Name')); ?>
					<?php echo $this->Form->input('last_name', array('class' => 'twelve', 'label' => false, 'div' => 'five columns', 'placeholder' => 'Last Name')); ?>
				</div>
				<div class="row control-fields">
					<div class="two columns">
						<?php echo $this->Form->label('email', 'Email'); ?>
					</div>
					<?php echo $this->Form->input('email', array('class' => 'twelve', 'label' => false, 'div' => 'five columns', 'placeholder' => 'Your Email')); ?>
					<?php echo $this->Form->input('email2', array('class' => 'twelve', 'label' => false, 'div' => 'five columns', 'placeholder' => 'Confirm Email')); ?>
				</div>
				
				<div class="row control-fields">
					<div class="two columns">
						<?php echo $this->Form->label('password', 'Password'); ?>
					</div>
					<?php echo $this->Form->input('password', array('class' => 'twelve', 'label' => false, 'div' => 'five columns', 'placeholder' => 'Your Password')); ?>
					<?php echo $this->Form->input('password2', array('class' => 'twelve', 'label' => false, 'div' => 'five columns', 'type' => 'password', 'placeholder' => 'Confirm Password')); ?>
				</div>

				<div class="row control-fields">
					<div class="two columns">
						<?php echo $this->Form->label('gender', 'You are'); ?>
					</div>
					<div class="seven columns">
						<?php echo $this->Form->input('gender', array(
							'div' => 'inline-radios',
							'type' => 'radio',
							'legend' => false,
							'options' => array('male', 'female')
						)); ?>
					</div>
				</div>
				<div class="btn-group">
					<?php echo $this->Form->submit('Register', array('class' => 'btn btn-blue pull-right')); ?>
				</div>
			<?php echo $this->Form->end(); ?>
		</div>	
	</div>	
</div>