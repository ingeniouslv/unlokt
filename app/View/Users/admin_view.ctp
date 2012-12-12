<?php
$this->set('title_for_layout', h($user['User']['first_name']. ' '. $user['User']['last_name']));
?>
<div class="main-content page user">
	<div class="container">

		<div class="row">
			<div class="nine columns">
				<div class="page-header">
					<h1 class="name"><?php echo h($user['User']['name']); ?></h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="eight columns">
				<h2>Email</h2>
				<?php echo h($user['User']['email']); ?>
				<h2>Active</h2>
				<?php echo h(($user['User']['is_active']?'Yes':'No')); ?>
				<h2>Super Admin</h2>
				<?php echo h(($user['User']['is_super_admin']?'Yes':'No')); ?>
				<h2>Created</h2>
				<?php echo h($user['User']['created']); ?>
			</div>
		</div>
	</div>
</div>

<!-- <div class="users view">
<h2><?php  echo __('User'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($user['User']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('First Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['first_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Last Name'); ?></dt>
		<dd>
			<?php echo h($user['User']['last_name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Email'); ?></dt>
		<dd>
			<?php echo h($user['User']['email']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Password'); ?></dt>
		<dd>
			<?php echo h($user['User']['password']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Active'); ?></dt>
		<dd>
			<?php echo h($user['User']['is_active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Is Super Admin'); ?></dt>
		<dd>
			<?php echo h($user['User']['is_super_admin']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($user['User']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Active Deals'), array('controller' => 'active_deals', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Active Deal'), array('controller' => 'active_deals', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Attachments'), array('controller' => 'attachments', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Attachment'), array('controller' => 'attachments', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Managers'), array('controller' => 'managers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Manager'), array('controller' => 'managers', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Password Resets'), array('controller' => 'password_resets', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Password Reset'), array('controller' => 'password_resets', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Reviews'), array('controller' => 'reviews', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Review'), array('controller' => 'reviews', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Active Deals'); ?></h3>
	<?php if (!empty($user['ActiveDeal'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Deal Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Completed Step'); ?></th>
		<th><?php echo __('Is Completed'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['ActiveDeal'] as $activeDeal): ?>
		<tr>
			<td><?php echo $activeDeal['id']; ?></td>
			<td><?php echo $activeDeal['deal_id']; ?></td>
			<td><?php echo $activeDeal['user_id']; ?></td>
			<td><?php echo $activeDeal['completed_step']; ?></td>
			<td><?php echo $activeDeal['is_completed']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'active_deals', 'action' => 'view', $activeDeal['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'active_deals', 'action' => 'edit', $activeDeal['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'active_deals', 'action' => 'delete', $activeDeal['id']), null, __('Are you sure you want to delete # %s?', $activeDeal['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Active Deal'), array('controller' => 'active_deals', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Attachments'); ?></h3>
	<?php if (!empty($user['Attachment'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Spot Id'); ?></th>
		<th><?php echo __('Feed Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Mime'); ?></th>
		<th><?php echo __('Type'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Attachment'] as $attachment): ?>
		<tr>
			<td><?php echo $attachment['id']; ?></td>
			<td><?php echo $attachment['spot_id']; ?></td>
			<td><?php echo $attachment['feed_id']; ?></td>
			<td><?php echo $attachment['user_id']; ?></td>
			<td><?php echo $attachment['mime']; ?></td>
			<td><?php echo $attachment['type']; ?></td>
			<td><?php echo $attachment['name']; ?></td>
			<td><?php echo $attachment['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'attachments', 'action' => 'view', $attachment['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'attachments', 'action' => 'edit', $attachment['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'attachments', 'action' => 'delete', $attachment['id']), null, __('Are you sure you want to delete # %s?', $attachment['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attachment'), array('controller' => 'attachments', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Managers'); ?></h3>
	<?php if (!empty($user['Manager'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Spot Id'); ?></th>
		<th><?php echo __('Is Admin'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Manager'] as $manager): ?>
		<tr>
			<td><?php echo $manager['id']; ?></td>
			<td><?php echo $manager['user_id']; ?></td>
			<td><?php echo $manager['spot_id']; ?></td>
			<td><?php echo $manager['is_admin']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'managers', 'action' => 'view', $manager['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'managers', 'action' => 'edit', $manager['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'managers', 'action' => 'delete', $manager['id']), null, __('Are you sure you want to delete # %s?', $manager['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Manager'), array('controller' => 'managers', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Password Resets'); ?></h3>
	<?php if (!empty($user['PasswordReset'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Hash'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['PasswordReset'] as $passwordReset): ?>
		<tr>
			<td><?php echo $passwordReset['id']; ?></td>
			<td><?php echo $passwordReset['user_id']; ?></td>
			<td><?php echo $passwordReset['hash']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'password_resets', 'action' => 'view', $passwordReset['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'password_resets', 'action' => 'edit', $passwordReset['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'password_resets', 'action' => 'delete', $passwordReset['id']), null, __('Are you sure you want to delete # %s?', $passwordReset['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Password Reset'), array('controller' => 'password_resets', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Reviews'); ?></h3>
	<?php if (!empty($user['Review'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Spot Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Review'); ?></th>
		<th><?php echo __('Stars'); ?></th>
		<th><?php echo __('Ip'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['Review'] as $review): ?>
		<tr>
			<td><?php echo $review['id']; ?></td>
			<td><?php echo $review['user_id']; ?></td>
			<td><?php echo $review['spot_id']; ?></td>
			<td><?php echo $review['name']; ?></td>
			<td><?php echo $review['review']; ?></td>
			<td><?php echo $review['stars']; ?></td>
			<td><?php echo $review['ip']; ?></td>
			<td><?php echo $review['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'reviews', 'action' => 'view', $review['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'reviews', 'action' => 'edit', $review['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'reviews', 'action' => 'delete', $review['id']), null, __('Are you sure you want to delete # %s?', $review['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Review'), array('controller' => 'reviews', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div> -->
