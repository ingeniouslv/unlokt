<?php
$this->set('title_for_layout', 'Account Settings');
?>
<div class="main-content page user">
	<div class="container">
		<h1 class="page-header">Account Settings</h1>
		<div class="row">
			<div class="seven columns">
				<?php echo $this->Form->create('User', array('class' => 'form-vertical control-group', 'type' => 'file')); ?>
				<div class="row control-fields">
					<div class="two columns">
						<?php echo $this->Form->label('picture', 'Picture'); ?>
					</div>
					<div class="ten columns">
						<img src="<?php echo $this->Html->gen_path('user', $this->Auth->user('id'), 80); ?>" class="pull-left profile-image">
						<p>Fore best results, use an image of 160x160 pixels<br>File formats accepted are JPEG, PNG, and GIF.</p>
						<input type="file" name="file" class="input" data-type="file-input">
					</div>
				</div>

				<div class="row control-fields">
					<div class="two columns">
						<?php echo $this->Form->label('first_name', 'Name'); ?>
					</div>
					<?php echo $this->Form->input('first_name', array('class' => 'twelve', 'label' => false, 'div' => 'five columns')); ?>
					<?php echo $this->Form->input('last_name', array('class' => 'twelve', 'label' => false, 'div' => 'five columns')); ?>
				</div>

				<div class="row control-fields">
					<div class="two columns">
						<?php echo $this->Form->label('email', 'Email'); ?>
					</div>
					<?php echo $this->Form->input('email', array('class' => 'twelve', 'label' => false, 'div' => 'seven columns')); ?>
				</div>

				<div class="row control-fields <?php echo (isset($this->request->data['User']['password']) ? 'hide' : ''); ?> passwordbutton">
					<div class="two columns">
						<?php echo $this->Form->label('password', 'Password'); ?>
					</div>
					<div class="seven columns">
						<input type="text" value="Password Hidden for Safety" class="twelve" disabled>
					</div>
					<div class="three columns text-right">
						<a class="btn-link btn-large" onclick="$('.passwordbutton').hide();$('.passwordfield').show();return false;" href="javascript:void(0);"><i class="icon-pencil"></i>Change</a>
					</div>
				</div>

				<!-- Change password div -->
				<div class="row control-fields <?php echo (!isset($this->request->data['User']['password']) ? 'hide' : ''); ?> passwordfield">
					<div class="two columns">
						<?php echo $this->Form->label('password', 'Password'); ?>
					</div>
					<div class="ten columns">
						<h3>Change Password</h3>
						<p>Please enter your new password and confirm the new password.<br>
							If you do not wish to change your password, do not enter a password.</p>
						<div class="row">
							<div class="six columns">
								<?php echo $this->Form->input('password', array('class' => 'twelve', 'autocomplete' => 'off')); ?>
							</div>
							<div class="six columns">
								<?php echo $this->Form->input('password2', array('type' => 'password', 'label' => 'Password Confirmation', 'class' => 'twelve', 'autocomplete' => 'off', 'div' => array('class' => 'input text required'))); ?>
							</div>
						</div>
					</div>
				</div>
				<!-- end of change password div -->
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
			</div>
		</div>
		<div class="btn-group">
			<?php
			echo $this->Html->link('Cancel', array('action' => 'account'), array('class' => 'btn btn-large btn-red'));
			echo $this->Form->button('Save Settings', array('class' => 'btn btn-blue btn-large', 'type' => 'submit'));
			?>
			
			
			
			<?php echo $this->Html->link('Delete Account', array('action' => 'account_delete'), array('class' => 'btn btn-red btn-large pull-right'), 'Are you sure you want to delete your account?'); ?>
		</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>