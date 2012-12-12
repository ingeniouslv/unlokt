<div class="deals form">
<?php echo $this->Form->create('Deal'); ?>
	<fieldset>
		<legend><?php echo __('Edit Deal'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('spot_id');
		echo $this->Form->input('start_time');
		echo $this->Form->input('end_time');
		echo $this->Form->input('is_active');
		echo $this->Form->input('is_public');
		echo $this->Form->input('total_keys');
		echo $this->Form->input('redemption_credit');
		echo $this->Form->input('repeat_dow_0');
		echo $this->Form->input('sku');
		echo $this->Form->input('limit_per_customer');
		echo $this->Form->input('views');
		echo $this->Form->input('redemptions');
		echo $this->Form->input('completions');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Deal.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Deal.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Deals'), array('action' => 'index')); ?></li>
	</ul>
</div>
