<?php
$this->set('title_for_layout', 'Spot Special Manager');
?>

<div class="main-content page category">
	<div class="container">
		<h1>Special Manager</h1>

		<table class="zebra">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('Spot.name', 'Spot'); ?></th>
					<th><?php echo $this->Paginator->sort('is_active', 'Active'); ?></th>
					<th><?php echo $this->Paginator->sort('is_public', 'Public'); ?></th>
					<th><?php echo $this->Paginator->sort('keys'); ?></th>
					<th class="actions">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($deals as $deal): ?>
				<tr>
					<td class="deal-name">
						<?php echo $this->Html->link(__($deal['Deal']['name']), array('action' => 'view', $deal['Deal']['id'], 'admin' => false)); ?>
					</td>
					<td>
						<?php echo $this->Html->link(__($deal['Spot']['name']), array('controller' => 'spots', 'action' => 'view', $deal['Spot']['id'], 'admin' => false)); ?>
					</td>
					<td><?php echo h(($deal['Deal']['is_active']?'Yes':'No')); ?>&nbsp;</td>
					<td><?php echo h(($deal['Deal']['is_public']?'Yes':'No')); ?>&nbsp;</td>
					<td><?php echo h($deal['Deal']['keys']); ?>&nbsp;</td>
					<td class="actions">
						<?php
							if($deal['Deal']['is_active']) {
								echo $this->Form->postLink(__('Hide'), array('action' => 'toggle_is_active', $deal['Deal']['id'], 'admin' => false), array('class' => 'btn btn-red'));
							} else {
								echo $this->Form->postLink(__('Show'), array('action' => 'toggle_is_active', $deal['Deal']['id'], 'admin' => false), array('class' => 'btn btn-green'));
							}
						?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
