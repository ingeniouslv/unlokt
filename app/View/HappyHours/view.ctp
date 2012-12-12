<?php
$this->set('title_for_layout', "Happy Hour for '". h($spot['Spot']['name']). "'");
?>
<div class="main-content">
	<div class="container"></div>
		<div class="happyHours view">
		<h2><?php  echo __('Happy Hour'); ?></h2>
			<dl>
				<dt><?php echo __('Id'); ?></dt>
				<dd>
					<?php echo h($happyHour['HappyHour']['id']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Spot'); ?></dt>
				<dd>
					<?php echo $this->Html->link($happyHour['Spot']['name'], array('controller' => 'spots', 'action' => 'view', $happyHour['Spot']['id'])); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Start'); ?></dt>
				<dd>
					<?php echo h($happyHour['HappyHour']['start']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('End'); ?></dt>
				<dd>
					<?php echo h($happyHour['HappyHour']['end']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Day Of Week'); ?></dt>
				<dd>
					<?php echo h($happyHour['HappyHour']['day_of_week']); ?>
					&nbsp;
				</dd>
				<dt><?php echo __('Parent Happy Hour'); ?></dt>
				<dd>
					<?php echo $this->Html->link($happyHour['ParentHappyHour']['id'], array('controller' => 'happy_hours', 'action' => 'view', $happyHour['ParentHappyHour']['id'])); ?>
					&nbsp;
				</dd>
			</dl>
		</div>
		<div class="actions">
			<h3><?php echo __('Actions'); ?></h3>
			<ul>
				<li><?php echo $this->Html->link(__('Edit Happy Hour'), array('action' => 'edit', $happyHour['HappyHour']['id'])); ?> </li>
				<li><?php echo $this->Form->postLink(__('Delete Happy Hour'), array('action' => 'delete', $happyHour['HappyHour']['id']), null, __('Are you sure you want to delete # %s?', $happyHour['HappyHour']['id'])); ?> </li>
				<li><?php echo $this->Html->link(__('List Happy Hours'), array('action' => 'index')); ?> </li>
				<li><?php echo $this->Html->link(__('New Happy Hour'), array('action' => 'add')); ?> </li>
				<li><?php echo $this->Html->link(__('List Spots'), array('controller' => 'spots', 'action' => 'index')); ?> </li>
				<li><?php echo $this->Html->link(__('New Spot'), array('controller' => 'spots', 'action' => 'add')); ?> </li>
				<li><?php echo $this->Html->link(__('List Happy Hours'), array('controller' => 'happy_hours', 'action' => 'index')); ?> </li>
				<li><?php echo $this->Html->link(__('New Parent Happy Hour'), array('controller' => 'happy_hours', 'action' => 'add')); ?> </li>
			</ul>
		</div>
	</div>	
</div>