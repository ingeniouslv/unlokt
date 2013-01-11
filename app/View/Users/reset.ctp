<?php
$this->set('title_for_layout', 'Password Reset Request');
?>
<div class="main-content page user">
	<div class="container">
		<?php echo $this->Form->create(array('class' => 'control-group form-vertical')); ?>	
			<div class="row columns eight">
				<h1>Reset Password</h1>		
				<div class="row control-fields">
					<div class="two columns">
						<?php echo $this->Form->label('email', 'Email', array('class' => 'required') ); ?>
					</div>
					<?php echo $this->Form->input('email', array('class' => 'twelve', 'label' => false, 'div' => 'five columns control-fields')); ?>
				</div>
			<div class="btn-group">
				<?php echo $this->Form->submit('Reset Password', array('class' => 'btn btn-blue')); ?>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>


