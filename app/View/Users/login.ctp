<?php
$this->set('title_for_layout', 'Login');
?>
<div class="page">
	<div>
		<div class="row row-centered">
			<div class="columns mod-box">
				<div class="logo">
					<img src="/img/main-logo.png" alt="">
				</div>
				<h1>Please Log In</h1>
				<?php
				echo $this->Form->create('User', array('class' => 'control-group form-vertical form-centered'));
				echo $this->Form->input('email', array('div' => 'control-fields', 'label' => false, 'class' => 'input-full', 'placeholder' => 'Email'));
				echo $this->Form->input('password', array('div' => 'control-fields pword', 'label' => false, 'class' => 'input-full', 'placeholder' => 'Password'));
				?>
				<div class="btn-group">
					<!-- <a class="btn btn-yellow" href="/users/register">Sign Up!</a> -->
					<?php echo $this->Form->button('Log In', array('type' => 'submit', 'class' => 'btn btn-blue')); ?>
					<?php //echo $this->Html->link('Log In', array('action' => 'login_facebook', 'admin' => false), array('class' => 'btn btn-fb')); ?>
				</div>
				<div class="tip warning" style="display: none;">
					<h4>Warning</h4>
					<p>If you log in with Facebook you will not be able to log in without Facebook anymore.</p>
				</div>
				<!-- TODO: Forgot Password view -->
				<div class="btn-group">
					<a class="btn-link" href="/pages/about">About Us  </a>
					<a class="btn-link" href="/users/reset">Forgot Password?</a>
				</div>
				<?php
				echo $this->Form->end();
				?>

			</div>
		</div>
	</div>
</div>
<script>
	var fb = $('.btn-fb');
	var tip = $('.tip');
	fb.hover(
		function() {
			tip.fadeIn(100);
		},
		function() {
			tip.fadeOut(100);
		}
	);
</script>