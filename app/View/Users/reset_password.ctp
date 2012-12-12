<?php
$this->set('title_for_layout', 'Resetting Password');
?>
<div class="main-content page user">
	<div class="container">
		<h1>Resetting Password</h1>
		<p>Resetting password for <b><?php echo h($user['User']['name']); ?> &lt;<?php echo h($user['User']['email']); ?>&gt;</b></p>
		<?php
		echo $this->Form->create('User', array('class' => 'control-group form-vertical'));
		echo $this->Form->input('password');
		echo $this->Form->input('password2', array('label' => 'Confirm Password', 'type' => 'password', 'div' => array('class' => 'input text required')));
		echo $this->Form->submit('Reset Password');
		?>
	</div>
</div>