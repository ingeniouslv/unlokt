<?php
$this->set('title_for_layout', "Happy Hour Manager");
?>
<div class="happyHours index">
	<h2><?php echo __('Happy Hours'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('spot_id'); ?></th>
			<th><?php echo $this->Paginator->sort('start'); ?></th>
			<th><?php echo $this->Paginator->sort('end'); ?></th>
			<th><?php echo $this->Paginator->sort('day_of_week'); ?></th>
			<th><?php echo $this->Paginator->sort('parent_happy_hour_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($happyHours as $happyHour): ?>
	<tr>
		<td><?php echo h($happyHour['HappyHour']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($happyHour['Spot']['name'], array('controller' => 'spots', 'action' => 'view', $happyHour['Spot']['id'])); ?>
		</td>
		<td><?php echo h($happyHour['HappyHour']['start']); ?>&nbsp;</td>
		<td><?php echo h($happyHour['HappyHour']['end']); ?>&nbsp;</td>
		<td><?php echo h($happyHour['HappyHour']['day_of_week']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($happyHour['ParentHappyHour']['id'], array('controller' => 'happy_hours', 'action' => 'view', $happyHour['ParentHappyHour']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $happyHour['HappyHour']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $happyHour['HappyHour']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $happyHour['HappyHour']['id']), null, __('Are you sure you want to delete # %s?', $happyHour['HappyHour']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Happy Hour'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Spots'), array('controller' => 'spots', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Spot'), array('controller' => 'spots', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Happy Hours'), array('controller' => 'happy_hours', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Happy Hour'), array('controller' => 'happy_hours', 'action' => 'add')); ?> </li>
	</ul>
</div>
