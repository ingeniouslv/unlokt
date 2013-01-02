<?php
$this->set('title_for_layout', 'Plan Manager');
?>
<div class="main-content page plan">
	<div class="container">
		<h1>Plan Manager</h1>
		<?php echo $this->Html->link(__('Add Plan'), array('action' => 'add'), array('class' => 'btn')); ?>
		<table class="zebra">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('months'); ?></th>
					<th><?php echo $this->Paginator->sort('trial_months'); ?></th>
					<th><?php echo $this->Paginator->sort('code'); ?></th>
					<th><?php echo $this->Paginator->sort('price'); ?></th>
					<th><?php echo $this->Paginator->sort('is_public'); ?></th>
					<th class="actions">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($plans as $plan): ?>
				<tr>
					<td class="plan-name">
						<?php echo $this->Html->link(__($plan['Plan']['name']), array('action' => 'view', $plan['Plan']['id'])); ?>
					</td>
					<td>
						<?php echo h($plan['Plan']['months']); ?>
					</td>
					<td>
						<?php echo h($plan['Plan']['trial_months']); ?>
					</td>
					<td>
						<?php echo h($plan['Plan']['code']); ?>
					</td>
					<td>
						$<?php echo number_format($plan['Plan']['price'], 2); ?>
					</td>
					<td>
						<?php echo $plan['Plan']['is_public'] ? 'Yes' : 'No'; ?>
					</td>
					<td class="actions">
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $plan['Plan']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $plan['Plan']['id']), array('class' => 'btn btn-red'), __('Are you sure you want to delete # %s?', $plan['Plan']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
