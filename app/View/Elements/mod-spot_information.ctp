<div class="block block-darkgray block-glow">
	<h4><i class="icon-info"></i> Information</h4>

	<!-- If controller == deal -->
	<!-- SPOT NAME -->
	<!-- Only show this piece of content when we're on the Deals controller. Hopefully this logic will win -->
	<?php if ($this->params['controller'] == 'deals'): ?>
	<div class="spot">
		<img class="photo" src="<?php echo $this->Html->gen_path('spot', $spot['Spot']['id'], 40, null, $spot['Spot']['image_name']); ?>" width="40" height="40">
		<h3 class="name text-">
			<a href="<?php echo "{$this->webroot}spots/view/{$spot['Spot']['id']}"; ?>"><?php echo h($spot['Spot']['name']); ?></a>
		</h3>
	</div>
	<!-- END SPOT NAME -->
	<?php endif; ?>
	
	<div class="information">
		<img src="http://maps.google.com/maps/api/staticmap?center=<?php echo h($spot['Spot']['lat']); ?>,<?php echo h($spot['Spot']['lng']); ?>&amp;zoom=12&amp;size=212x212&amp;key=<?php echo GOOGLE_MAPS_API_KEY; ?>&amp;sensor=false" width="212" height="212">

		<?php if (isset($spot['Category']) && count($spot['Category'])): ?>
			<div class="section">
				<h5 class="section-name"><span>Category</span></h5>
				<i class="icon-tag-2"></i>
				<div class="section-content">
					<ul class="nav nav-inline">
						<?php foreach ($spot['Category'] as $category): ?>
							<li><a href="/?search=category&amp;category=<?php echo $category['id']; ?>"><?php echo h($category['name']); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		<?php endif; ?>

		<div class="section">
			<h5 class="section-name"><span>Address</span></h5>
			<i class="icon-location"></i>
			<div class="section-content">
				<address>
					<a href="https://maps.google.com/?q=<?php echo h($spot['Spot']['address']); ?> <?php echo h($spot['Spot']['city']); ?> <?php echo h($spot['Spot']['state']); ?> <?php echo h($spot['Spot']['zip']); ?>" target= "_blank">
						<p><?php echo h($spot['Spot']['address']); ?>
						   <?php echo h($spot['Spot']['address2']); ?><br>
						   <?php echo h($spot['Spot']['city']); ?>, 
						   <?php echo h($spot['Spot']['state']); ?>
						   <?php echo h($spot['Spot']['zip']); ?></p>
					</a>
				</address>
			</div>
		</div>

		
		<div class="section">
			<h5 class="section-name"><span>Contact</span></h5>
			<?php if ($spot['Spot']['phone']): ?>
				<i class="icon-phone"></i>
				<div class="section-content">
				<?php if (preg_match('/^\d{10}$/', $spot['Spot']['phone'])): ?>
					<p><?php echo preg_replace('/^(\d{3})(\d{3})(\d{4})$/', '($1) $2-$3', $spot['Spot']['phone']); ?></p>
				<?php else: ?>
					<p><?php echo h($spot['Spot']['phone']); ?></p>
				<?php endif; ?>
				</div>
			<?php endif; ?>
			<?php if ($spot['Spot']['email']): ?>
				<i class="icon-email"></i>
				<div class="section-content">
					<p><a href="mailto:<?php echo h($spot['Spot']['email']); ?>"><?php echo h($spot['Spot']['email']); ?></a></p>
				</div>
			<?php endif; ?>
			
		</div>

		<?php if (!empty($spot['HoursOfOperation'])): ?>
			<div class="section">
				<h5 class="section-name"><span>Schedule</span></h5>
				<i class="icon-clock-2"></i>
				<div class="section-content">
					<!-- <p>Mon&ndash;Thu, Sun <span class="pull-right">10 am &ndash; 10 pm</span></p>
					<p>Fri&ndash;Sat <span class="pull-right">10 am &ndash; 11 pm</span></p> -->
					<?php foreach ($spot['HoursOfOperation'] as $hoursOfOperation): ?>
						<p><?php echo $hoursOfOperation['short_string']; ?></p>
					<?php endforeach; ?>
				</div>
			</div>
		<?php endif; ?>
		
		<?php if ($spot['Spot']['url']): ?>
			<div class="section">
				<h5 class="section-name"><span>Website</span></h5>
				<i class="icon-link"></i>
				<div class="section-content">
					<a href="<?php echo h($spot['Spot']['url']); ?>" target="_blank"><?php echo h(preg_replace('@^(http://|https://)(.*)@', '$2', $spot['Spot']['url'])); ?></a>
				</div>
			</div>
		<?php endif; ?>
		
		<?php if ($spot['Spot']['facebook_url'] || $spot['Spot']['twitter_url'] || $spot['Spot']['instagram_url']): ?>
			<div class="section">
				<h5 class="section-name"><span>Social Media</span></h5>
				<i class="icon-link"></i>
				<div class="section-content">
					<?php if ($spot['Spot']['facebook_url']): ?>
						<a href="<?php echo h($spot['Spot']['facebook_url']); ?>" target="_blank" class="i-facebook"></a>
					<?php endif; ?>
					<?php if ($spot['Spot']['twitter_url']): ?>
						<a href="<?php echo h($spot['Spot']['twitter_url']); ?>" target="_blank" class="i-twitter"></a>
					<?php endif; ?>
					<?php if ($spot['Spot']['instagram_url']): ?>
						<a href="<?php echo h($spot['Spot']['instagram_url']); ?>" target="_blank" class="i-instagram"></a>
					<?php endif; ?>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>