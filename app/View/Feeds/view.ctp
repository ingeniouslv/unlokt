<?php
$this->set('title_for_layout', 'Feed');
?>
<div class="feeds view">
<h2><?php  echo __('Feed'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($feed['Feed']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Spot'); ?></dt>
		<dd>
			<?php echo $this->Html->link($feed['Spot']['name'], array('controller' => 'spots', 'action' => 'view', $feed['Spot']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Feed'); ?></dt>
		<dd>
			<?php echo h($feed['Feed']['feed']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($feed['Feed']['created']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Feed'), array('action' => 'edit', $feed['Feed']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Feed'), array('action' => 'delete', $feed['Feed']['id']), null, __('Are you sure you want to delete # %s?', $feed['Feed']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Feeds'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Feed'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Spots'), array('controller' => 'spots', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Spot'), array('controller' => 'spots', 'action' => 'add')); ?> </li>
	</ul>
</div>
