<!-- <div class="row"> -->
 	
 	<div class="items row <?php if (isset($class)) { echo $class; } ?>" id="<?php if (isset($id)) { echo $id; } else { echo 'staggered'; } ?>">
		<?php foreach ($deals as $deal): ?>
			<div class="block-slide <?php if (isset($item_class)) { echo $item_class; } else { echo ''; } ?> columns <?php if (isset($id)) { echo $id; } else { echo 'staggered'; } ?>-item">
				<div class="tile">
					<?php if (isset($deal['HappyHour'])): ?>
						<a href="<?php echo $this->webroot; ?>spots/view/<?php echo $deal['Spot']['id']; ?>">
							<img src="<?php echo $this->Html->gen_path('spot', $deal['Spot']['id'], 270); ?>">
						</a>	
					<?php elseif ($deal['Deal']['keys'] == 0): ?>
						<a href="<?php echo $this->webroot; ?>deals/view/<?php echo $deal['Deal']['id']; ?>">
							<img src="<?php echo $this->Html->gen_path('deal', $deal['Deal']['id'], 270); ?>">
						</a>
						
					<?php elseif ($deal['Deal']['keys'] == 1): ?>
						<a href="<?php echo $this->webroot; ?>deals/view/<?php echo $deal['Deal']['id']; ?>">
							<img src="<?php echo $this->Html->gen_path('deal', $deal['Deal']['id'], 270); ?>">
						</a>
						
					<?php else: ?>
						<a href="<?php echo $this->webroot; ?>deals/view/<?php echo $deal['Deal']['id']; ?>">
							<img src="<?php echo $this->Html->gen_path('deal', $deal['Deal']['id'], 270); ?>">
						</a>	
						
					<?php endif; ?>

					<!-- If Happy Hour is currently happening, show the times. --> 
					<?php if (isset($deal['HappyHour'])): ?>
					<div class="happy-hour">
						<?php
						$this->set('happening_until', date('g:i a', strtotime($deal['HappyHour']['end'])));
						echo $this->element('piece-happy_hour');
						?>
					</div>
					<div class="tile-footer">
						<h4><i class="icon-clock-1"></i> Happy Hour</h4>
						<h2><?php echo h($deal['Spot']['name']); ?></h2>
					</div>
					<div class="block-actions">
						<a class="btn btn-yellow" href="<?php echo $this->webroot; ?>spots/view/<?php echo $deal['Deal']['spot_id']; ?>">View Spot</a>
					</div>
					<?php else: ?>	
					<div class="tile-footer">
						<div class="tile-type">
							<?php if ($deal['Deal']['keys'] == 0): ?>
								<h4><i class="icon-calendar"></i></h4>
							<?php elseif ($deal['Deal']['keys'] == 1): ?>
								<h4><i class="icon-tag-2"></i></h4>
							<?php else: ?>
								<h4><i class="icon-key"></i></h4>
							<?php endif; ?>
							<h2><?php echo h($deal['Deal']['name']); ?></h2>
							<?php
							$displayDate = '';
							if ($deal['Deal']['keys'] == 0) {
								for ($i = 0; $i < 7; $i ++) {
									$date = strtolower(date('l', strtotime("+$i days")));
									if ($deal['Deal'][$date] == 1) {
										$displayDate = date('D j M', strtotime("+$i days"));
										break;
									}
								} ?>
								<br><span><?php echo $displayDate; ?></span>
							<?php } ?>
						</div>	
						<div class="block-actions">
							<p><?php echo h($deal['Deal']['description']); ?></p>
						
							<?php if($deal['Deal']['keys'] > 1): ?>
								<span class="keys-total pull-left"><?php echo $deal['Deal']['keys']; ?></span>
							<?php 
								endif;
								if($deal['Deal']['keys'] > 0):
							?>	
								<a class="btn btn-yellow pull-right" href="<?php echo $this->webroot; ?>deals/view/<?php echo $deal['Deal']['id']; ?>">View Special</a>
							<?php else: ?>
								<a class="btn btn-yellow pull-right" href="<?php echo $this->webroot; ?>deals/view/<?php echo $deal['Deal']['id']; ?>">View Event</a>
							<?php endif; ?>
						</div>
					</div>
					<?php endif; ?>	
				</div>
			</div>
		<?php endforeach; ?>
	</div>
<!-- </div> -->