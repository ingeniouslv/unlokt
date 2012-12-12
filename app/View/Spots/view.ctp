<?php
$this->set('title_for_layout', h($spot['Spot']['name']));
?>
<?php if ($this->Auth->loggedIn() && !empty($managerOfCurrentSpot)): ?>
	<div class="navbar-admin">
		<div class="container">
			<div class="btn-group">
				<a class="btn btn-dark" href="<?php echo $this->webroot; ?>spots/edit/<?php echo $spot['Spot']['id']; ?>">Manage this Spot</a>
				<a class="btn btn-dark" href="<?php echo $this->webroot; ?>deals/manage/<?php echo $spot['Spot']['id']; ?>">Manage Specials for this Spot</a>
				<?php echo $this->Html->link('Manage Hours of Operation for this spot', array('controller'=>'hours_of_operations', 'action'=>'manage', $spot['Spot']['id']), array('class' => 'btn btn-dark')); ?>
				<?php echo $this->Html->link('Manage Managers for this Spot', array('controller'=>'managers', 'action'=>'by_spot', $spot['Spot']['id']), array('class' => 'btn btn-dark')); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<div class="main-content page spot">
	<div class="container">
		<div class="row">
			<div class="nine columns">
				<!-- Spot Header -->
				<div class="page-header">
					<div class="social pull-right">
						<?php
							if(count($spot['SpotFollower'])) {
								echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-heartkey')).'Unfollow Spot', array('controller' => 'users', 'action' => 'unfollow_spot', $spot['Spot']['id'], 'admin' => false), array( 'class' => 'btn btn-large follow', 'escape' => false));
							} else {
								echo $this->Html->link($this->Html->tag('i', '', array('class' => 'icon-heartkey')).'Follow Spot', array('controller' => 'users', 'action' => 'follow_spot', $spot['Spot']['id'], 'admin' => false), array( 'class' => 'btn btn-large btn-red follow', 'escape' => false));
							}
							
						?>
					</div>

					<img class="photo" src="<?php echo $this->Html->gen_path('spot', $spot['Spot']['id'], 200); ?>" width="200" height="200">
					<h1 class="name"><?php echo h($spot['Spot']['name']); ?></h1>
					<?php
					// Don't show the reviews if there are not any ratings yet.
					if ($spot['Spot']['rating_count']):
						echo $this->element('piece-rating_system');
					endif; ?>
					<div class="row">
						<?php if ($spot['Spot']['spotlight_1']): ?>
							<h4>
								<span class="icon-wrapper"><i class="icon-spotlight">&#128266;</i></span>
								Spotlight Box
							</h4>
							<div class="spot-custom-content large">
								
								<div class="spotlight-highlight-wrapper">
									<div class="spotlight-highlight">
										<?php echo $spot['Spot']['spotlight_1']; ?>
									</div>
								</div>	
								<!-- <img src="http://dummyimage.com/476x210"> -->
							</div>
						<?php endif; ?>
					</div>

				</div>
				<!-- End Spot Header -->

				<!-- Spot Content -->
				<div class="row">
					<div class="eight columns">
						<h4>About the Spot</h4>
						<div class="spot-description block-white block">
							<?php echo $spot['Spot']['description']; ?>
						</div>
					</div>

					<div class="four columns">
						<?php if ($spot['Spot']['spotlight_2']): ?>
							<h4>Spotlight Pic</h4>
							<div class="block block-white spot-custom-content small">
								<?php echo $spot['Spot']['spotlight_2']; ?>
								<!-- <img src="http://dummyimage.com/223x100"> -->
							</div>
						<?php endif; ?>

						<?php if ($happy_hour_data): ?>
						<div class="block block-white happy-hour">
							<?php echo $this->element('piece-happy_hour', array("happy_hour_size" => "large")); ?>
						</div>
						<?php endif; ?>

						<!-- Show SpotOption if not empty -->
						<?php if (count($spot['SpotOption'])): ?>
							<h4>Spot Features</h4>
							<div class="block block-white">	
								<ul class="spot-options">
									<?php foreach ($spot['SpotOption'] as $spotOption): ?>
										<li><i class="<?php echo h($spotOption['css_class']); ?>"></i><?php echo h($spotOption['name']); ?></li>
									<?php endforeach; ?>
								</ul>
							</div>	
						<?php endif; ?>
					</div>
				</div>
				<!-- End Spot Content -->

			</div>

			<div class="three columns bleed-over-content">
				<?php if (count($attachments)): ?>
					<div class="block block-white block-glow">
						<h4><i class="icon-picture"></i> Gallery</h4>
						<div class="gallery">
							<?php foreach ($attachments as $attachment): ?>
								<a class="gallery-image" data-attachment-id="<?php echo $attachment['Attachment']['id']; ?>" href="javascript:void(0);" title="<?php echo h($attachment['Attachment']['name']); ?>"><img src="<?php echo $this->Html->gen_path('attachment', $attachment['Attachment']['id'], 100); ?>" alt="<?php echo h($attachment['Attachment']['name']); ?>"></a>
							<?php endforeach; ?>
						</div>
						<a class="more" id="more-pics" href="javascript:void(0);">More Pics ›</a>
					</div>
				<?php endif; ?>

				<?php echo $this->element('mod-spot_information'); ?>
			</div>
		</div>
	</div>
</div>
<?php
$this->Html->add_script(array(
	'backbone/review'
));
?>
<div class="container">
	<div class="row">
		<div class="nine columns">
			<div class="row row-fix">
				<div class="twelve columns block-slider">
					<div class="block-slider-nav">
						<a class="left" href="javascript:void(0);"></a>
						<a class="right" href="javascript:void(0);"></a>
					</div>
					<?php echo $this->element('mod-filtered_items', array('class' => 'fixed block-slider-container')); ?>
				</div>
			</div>
			<a name="feeds"></a>
				<?php
				echo $this->element('mod-spot_feed');
				?>
			<span id="reviews"></span>
			<div class="row row-fix">
				<div class="twelve note-slider">
					<div class="block-slider-nav note-slider-nav">
						<a class="left" href="javascript:void(0);"></a>
						<a class="right" href="javascript:void(0);"></a>
					</div>
					<?php echo $this->element('mod-spot_reviews'); ?>
				</div>	
			</div>
		</div>
	</div>
</div>

<script src="/js/nf-slider-call.js"></script>

<script>
	
	// Add trigger for opening gallery
	$('.gallery-image').click(function() {
		var attachment_id = $(this).data('attachment-id');
		start_gallery(<?php echo $spot['Spot']['id']; ?>, attachment_id);
	});
	// Add trigger for opening gallery
	$('body').on('click', '.feed-item [data-attachment-id]', function() {
		var attachment_id = $(this).data('attachment-id');
		start_gallery(<?php echo $spot['Spot']['id']; ?>, attachment_id);
	});
	
	// Add a trigger for clicking "More Pics"
	$('#more-pics').click(function() {
		start_gallery(<?php echo $spot['Spot']['id']; ?>);
	});

	//
	var notenetflixviewer = new NetflixViewer({
		click_left: '.left',
		click_right: '.right',
		container: '.block-slider',
		slider: '.block-slider-container',
		item_padding: 10,
		el: $('.block-slider').parent(),
		slider_speed: 15,
		slider_distance: 6
	});

	var notenetflixviewer = new NetflixViewer({
		click_left: '.left',
		click_right: '.right',
		container: '.note-slider',
		slider: '.note-slider-container',
		item_padding: 10,
		el: $('.note-slider').parent(),
		slider_speed: 15,
		slider_distance: 6
	});
</script>
<script>
	//add a hover effect to the tile image
	$('.tile img').hover(
		function() {
			$(this).siblings('.tile-footer').children('.block-actions').show();
		},
		function() {
			$(this).siblings('.tile-footer').children('.block-actions').hide();
		}
	);

	//add same hover effect on the div that contains the buttons
	$('.tile .tile-footer').hover(
		function() {
			$(this).children('.block-actions').show();
		},
		function() {
			$(this).children('.block-actions').hide();
		}
	);

	//initially hide the buttons
	$('.tile-footer .block-actions').hide();
</script>
<?php echo $this->element('mod-gallery'); ?>