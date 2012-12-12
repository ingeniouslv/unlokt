<?php
$this->set('title_for_layout', 'Spot Manager');
?>
<div class="main-content page spot">
	<div class="container">
		<h1>Spots Manager</h1>

		<table class="zebra">
			<thead>
				<tr>
					<th>Spot Name</th>
					<th>Has Owner</th>
					<th>Current ($)</th>
					<th class="actions">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($spots as $spot): ?>
				<tr>
					<td class="spot-name"><?php echo $this->Html->link(__($spot['Spot']['name']), array('action' => 'view', $spot['Spot']['id'])); ?></td>
					<td>[Spot][owner?]</td>
					<td>[Spot][is_current]</td>
					<td class="actions">
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $spot['Spot']['id']), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $spot['Spot']['id']), array('class' => 'btn btn-red'), __('Are you sure you want to delete # %s?', $spot['Spot']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>