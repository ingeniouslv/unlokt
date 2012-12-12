<div class="payments view">
<h2><?php  echo __('Payment'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Spot'); ?></dt>
		<dd>
			<?php echo $this->Html->link($payment['Spot']['name'], array('controller' => 'spots', 'action' => 'view', $payment['Spot']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Subscription Type'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['subscription_type']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Amount Paid'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['amount_paid']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Paid Date'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['paid_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pay Period Start'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['pay_period_start']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Pay Period End'); ?></dt>
		<dd>
			<?php echo h($payment['Payment']['pay_period_end']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Payment'), array('action' => 'edit', $payment['Payment']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Payment'), array('action' => 'delete', $payment['Payment']['id']), null, __('Are you sure you want to delete # %s?', $payment['Payment']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Payments'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Payment'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Spots'), array('controller' => 'spots', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Spot'), array('controller' => 'spots', 'action' => 'add')); ?> </li>
	</ul>
</div>
