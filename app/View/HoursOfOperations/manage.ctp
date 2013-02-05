<div class="main-content page hours-of-operation">
	<div class="container">
		<h1>Hours of Operation for <?php echo $this->Html->link(h($spot['Spot']['name']),array('controller' => 'spots', 'action' => 'view', $spot['Spot']['id'])); ?></h1>
		<?php echo $this->Html->link('Add Hours', array('action' => 'add', $spot['Spot']['id']), array('class' => 'btn btn-blue')); ?>
		<table class="zebra">
			<tr>
					<th>Hours</th>
					<th>Closed</th>
					<th class="actions">Actions</th>
			</tr>
			<?php
			foreach ($hours_of_operations as $hours_of_operation): ?>
			<tr>
				<td><?php echo h($hours_of_operation['HoursOfOperation']['short_string']); ?>&nbsp;</td>
				<td><?php echo $hours_of_operation['HoursOfOperation']['is_closed']?'Yes':'No'; ?>&nbsp;</td>
				<td class="actions">
					<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $hours_of_operation['HoursOfOperation']['id']), array('class' => 'btn btn-red'), __('Are you sure you want to delete # %s?', $hours_of_operation['HoursOfOperation']['id'])); ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
</div>
