<div class="block block-darkgray">
	<h4><i class="icon-megaphone"></i> Spot Feed</h4>
	<?php foreach ($feeds as $feed): ?>
		<!-- Feed Item -->
		<div class="feed-item">
			<img src="<?php echo $this->Html->gen_path('spot', $feed['Spot']['id'], 40); ?>" class="pull-left">
			<?php if (isset($feed['Attachment']) && count($feed['Attachment'])): ?>
				<div class="attachments">
					<?php foreach ($feed['Attachment'] as $attachment): ?>
						<img data-attachment-id="<?php echo $attachment['id']; ?>" data-spot-id="<?php echo $feed['Spot']['id']; ?>" src="<?php echo $this->Html->gen_path('attachment', $attachment['id'], 40, null, $spot['Spot']['image_name']); ?>"> 
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<h3 class="title"><?php echo h($feed['Spot']['name']); ?></h3>
			<div class="description">
				<p><?php echo h($feed['Feed']['feed']); ?></p>
			</div>
			<?php if ($this->Auth->loggedIn() && ($this->Auth->user('is_super_admin') || (isset($managerOfCurrentSpot) && $managerOfCurrentSpot))): ?>
				<a href="javascript:void(0);" class="delete-feed" data-feed-id="<?php echo $feed['Feed']['id']; ?>">Delete</a>
			<?php endif; ?>
			<a class="more" href="" title="">Read More</a>
		</div>
		<!-- End Feed Item -->
	<?php endforeach; ?>

</div>