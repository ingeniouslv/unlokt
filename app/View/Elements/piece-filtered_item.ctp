<?php if (isset($deal['HappyHour'])): ?>
	<img src="<?php echo $this->Html->gen_path('spot', $deal['Spot']['id'], 223); ?>">
	<h4><i class="icon-clock-1"></i> Happy Hour</h4>
	<h2><?php echo h($deal['Spot']['name']); ?></h2>
<?php elseif ($deal['Deal']['keys'] == 0): ?>
	<h4><i class="icon-coupon"></i> Event</h4>
	<img src="<?php echo $this->Html->gen_path('deal', $deal['Deal']['id'], 223); ?>">
<!-- 					<img src="http://placehold.it/223x223"> -->
	<h2><?php echo h($deal['Deal']['name']); ?></h2>
<?php elseif ($deal['Deal']['keys'] == 1): ?>
	<h4><i class="icon-coupon"></i> Spot Special</h4>
	<img src="<?php echo $this->Html->gen_path('deal', $deal['Deal']['id'], 223); ?>">
<!-- 					<img src="http://placehold.it/223x223"> -->
	<h2><?php echo h($deal['Deal']['name']); ?></h2>
<?php else: ?>
	<h4><i class="icon-tag-2"></i> Spot Special</h4>
	<img src="<?php echo $this->Html->gen_path('deal', $deal['Deal']['id'], 223); ?>">
	<h2><?php echo h($deal['Deal']['name']); ?></h2>
<?php endif; ?>




<!-- If Happy Hour is currently happening, show the times. --> 
<?php if (isset($deal['HappyHour'])): ?>
	
	<div class="happy-hour">
		<?php
		$this->set('happening_until', date('g:i a', strtotime($deal['HappyHour']['end'])));
		echo $this->element('piece-happy_hour');
		?>
	</div>
	<div class="block-actions">
		<a class="btn btn-red pull-right" href="<?php echo $this->webroot; ?>spots/view/<?php echo $deal['Deal']['spot_id']; ?>">View Spot</a>
	</div>
<?php else: ?>
	<p><?php echo h($deal['Deal']['description']); ?></p>
	<div class="block-actions">
		<?php if($deal['Deal']['keys'] > 1): ?>
			<span class="keys-total"><?php echo $deal['Deal']['keys']; ?></span>
		<?php endif; ?>
		<?php if($deal['Deal']['keys'] > 0) : ?>
			<a class="btn btn-red pull-right" href="<?php echo $this->webroot; ?>special/view/<?php echo $deal['Deal']['id']; ?>">View Spot Special</a>
		<?php else: ?>
			<a class="btn btn-red pull-right" href="<?php echo $this->webroot; ?>special/view/<?php echo $deal['Deal']['id']; ?>">View Event</a>
		<?php endif; ?>
	</div>
<?php endif; ?>