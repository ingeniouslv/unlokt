<?php
$this->set('title_for_layout', 'Account Settings');
?>
<div class="main-content page user">
	<div class="container">
		<h1 class="page-header">Account</h1>

		<div class="row">
			<div class="one columns">
				<img src="<?php echo $this->Html->gen_path('user', $user['User']['id'], 80); ?>" class="profile-image" title="<?php echo h($user['User']['name']); ?>">
			</div>

			<div class="eleven columns">
				<h2><?php echo h($user['User']['name']); ?></h2>
				<p><?php echo h($user['User']['email']); ?></p>
				<?php if ($user['User']['is_active']): ?>
					<p>Active User</p>
				<?php endif; ?>
				<?php if ($user['User']['is_super_admin']): ?>
					<p>Super Administrator</p>
				<?php endif; ?>
				<?php echo $this->Html->link('Edit Account', array('action' => 'account_edit'), array('class' => 'btn')); ?>
			</div>
	</div>
</div>