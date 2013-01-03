<?php
$this->set('title_for_layout', 'Pending Spot Manager');
?>
<div class="main-content page spot">
	<div class="container">
		<h1>Pending Spots Manager</h1>
			<h3>** <?php echo $this->Html->link("View active spots", array('action' => 'index', 'admin' => true)); ?> **</h3>
		<?php echo $this->Html->link(__('Add Spot'), array('action' => 'add'), array('class' => 'btn')); ?>
		<table class="zebra">
			<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('name', 'Spot Name'); ?></th>
					<th>Has Owner</th>
					<th>Current ($)</th>
					<th class="actions">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php foreach ($spots as $spot): ?>
				<tr>
					<td class="spot-name"><?php echo h($spot['Spot']['name']); ?></td>
					<td>
						<?php
							echo (count($spot['Manager']) > 0) ? 'Yes' : 'No'; 
						?>
					</td>
					<td>
						<?php
							echo ($spot['Spot']['is_premium'] && ($spot['Spot']['payment_due_date'] == NULL || $spot['Spot']['payment_due_date'] >= Date('Y-m-d')))?'Yes':'No';
						?>
					</td>
					<td class="actions">
						<?php echo $this->Html->link('Approve', array('controller' => 'spots', 'action' => 'approve', $spot['Spot']['id'], 'admin' => true), array('class' => 'btn btn-blue')); ?>
						<?php echo $this->Html->link('Managers', array('controller' => 'managers', 'action' => 'by_spot', $spot['Spot']['id'], 'admin' => false), array('class' => 'btn')); ?>
						<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $spot['Spot']['id'], "admin" => false), array('class' => 'btn')); ?>
						<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $spot['Spot']['id']), array('class' => 'btn btn-red'), __('Are you sure you want to delete # %s?', $spot['Spot']['id'])); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>