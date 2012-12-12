<?php
$this->set('title_for_layout', 'Feed Manager');
?>
<div class="feeds index">
	<h2><?php echo __('Feeds'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('spot_id'); ?></th>
			<th><?php echo $this->Paginator->sort('feed'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($feeds as $feed): ?>
	<tr>
		<td><?php echo h($feed['Feed']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($feed['Spot']['name'], array('controller' => 'spots', 'action' => 'view', $feed['Spot']['id'])); ?>
		</td>
		<td><?php echo h($feed['Feed']['feed']); ?>&nbsp;</td>
		<td><?php echo h($feed['Feed']['created']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $feed['Feed']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $feed['Feed']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $feed['Feed']['id']), null, __('Are you sure you want to delete # %s?', $feed['Feed']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Feed'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Spots'), array('controller' => 'spots', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Spot'), array('controller' => 'spots', 'action' => 'add')); ?> </li>
	</ul>
</div>
