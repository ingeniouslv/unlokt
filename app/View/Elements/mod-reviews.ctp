<div class="note-slider-container review-wr">
	<?php foreach($reviews as $review): ?>
	<!-- Review Item -->
	<div class="note-slide columns ">	
		<div class="review-item tile">
			
			<div class="head">
				<img src="<?php echo $this->Html->gen_path('user', $review['User']['id'], 40, null, $review['User']['image_name']); ?>" class="pull-left">
				<h3 class="title"><?php echo htmlspecialchars($review['Review']['name']); ?></h3>
			</div>

			<p class="description"><?php echo htmlspecialchars($review['Review']['review']); ?></p>
			<div class="note-actions">	
				<span class="review-spot">
					Noted: <?php echo $this->Html->link($review['Spot']['name'], array('controller' => 'spots', 'action' => 'view', $review['Spot']['id'], 'admin' => false)); ?>
				</span>
				<a class="flag-icon" href="javascript:void(0);" data-flag-review="<?php echo $review['Review']['id']; ?>">&#9873;</a>
				<?php echo $this->Html->link('View Note', array('controller' => 'reviews', 'action' => 'view', $review['Review']['id'], 'admin' => false), array('class' => 'more')); ?>
			</div>	
		</div>
	</div>	
	<!-- End Review Item -->
	<?php endforeach; ?>
</div>