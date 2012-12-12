<?php
$this->set('title_for_layout', 'User Manager');
?>
<div class="main-content page user">
	<div class="container">
		<h1>User Manager</h1>
		<?php echo $this->Html->link(__('Add User'), array('action' => 'add'), array('class' => 'btn')); ?>
		<table class="zebra">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('email'); ?></th>
					<th><?php echo $this->Paginator->sort('is_active', 'Active'); ?></th>
					<th><?php echo $this->Paginator->sort('is_super_admin', 'Super Admin'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th class="actions">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($users as $user): ?>
				<tr>
					<td class="user-name">
						<?php echo $this->Html->link(__($user['User']['name']), array('action' => 'view', $user['User']['id'])); ?>
					</td>
					<td>
						<?php echo h($user['User']['email']); ?>
					</td>
					<td>
						<?php echo h(($user['User']['is_active']?'Yes':'No')); ?>
					</td>
					<td>
						<?php echo h(($user['User']['is_super_admin']?'Yes':'No')); ?>
					</td>
					<td>
						<?php echo h($user['User']['created']); ?>
					</td>
					<td class="actions">
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Html->link(__('Impersonate'), array('action' => 'impersonate', $user['User']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-red'), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
