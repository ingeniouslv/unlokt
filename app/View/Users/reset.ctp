<?php
$this->set('title_for_layout', 'Password Reset Request');
?>
<div class="main-content page user">
	<div class="container">
		<h1>Reset Password</h1>
		<?php
		echo $this->Form->create();
		echo $this->Form->input('email');
		echo $this->Form->submit('Reset password');
		?>
	</div>
</div>