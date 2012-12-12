<?php
$this->set('title_for_layout', 'Login');
?>
<div class="page">
	<div class="container">
		<div class="row row-centered">
			<div class="six columns mod-box">
				<h1>Please Log In</h1>
				<?php
				echo $this->Form->create('User', array('class' => 'control-group form-vertical form-centered'));
				echo $this->Form->input('email', array('div' => 'control-fields', 'label' => false, 'class' => 'input-full', 'placeholder' => 'Email'));
				echo $this->Form->input('password', array('div' => 'control-fields', 'label' => false, 'class' => 'input-full', 'placeholder' => 'Password'));
				?>
				<div class="btn-group">
					<a class="btn btn-red" href="/users/register">Sign Up!</a>
					<?php echo $this->Form->button('Login', array('type' => 'submit', 'class' => 'btn btn-blue')); ?>
				</div>
				<!-- TODO: Forgot Password view -->
				<div class="btn-group">
					<a class="btn-link" href="/users/forgot_password">Forgot Password?</a>
				</div>
				<?php
				echo $this->Form->end();
				?>
			</div>
		</div>
	</div>
</div>