<div class="note-slider-container review-wr">
	<?php foreach($reviews as $review): ?>
	<!-- Review Item -->
	<div class="note-slide columns ">	
		<div class="review-item tile">
			
			<div class="head">
				<img src="http://placehold.it/40x40" class="pull-left">
				<?php echo $this->element('piece-rating_system', array("rating_size" => "inline", 'review' => $review)); ?>
				<h3 class="title"><?php echo htmlspecialchars($review['Review']['name']); ?></h3>
			</div>

			<p class="description"><?php echo htmlspecialchars($review['Review']['review']); ?></p>
			<div class="note-actions">	
				<span class="review-spot">
					Noted: <?php echo $this->Html->link($spot['Spot']['name'], array('controller' => 'spots', 'action' => 'view', $spot['Spot']['id'], 'admin' => false)); ?>
				</span>
				<a class="flag-icon" href="javascript:void(0);" data-flag-review="<?php echo $review['Review']['id']; ?>">&#9873;</a>
				<?php echo $this->Html->link('View Note', array('controller' => 'reviews', 'action' => 'view', $review['Review']['id'], 'admin' => false), array('class' => 'more')); ?>
			</div>	
		</div>
	</div>	
	<!-- End Review Item -->
	<?php endforeach; ?>
</div>
<div class="block-actions btn-group columns">
	<a class="btn btn-blue" href="javascript:void(0);" onclick="$('#reviewModal').modal();"><i class="icon-pencil"></i>Add Note</a>
	<a class="btn" href="<?php echo $this->webroot; ?>reviews/reviews_by_spot/<?php echo $spot['Spot']['id']; ?>">Show More Notes</a>
</div>