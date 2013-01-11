<?php
$this->set('title_for_layout', h($spot['Spot']['name']));
?>
<?php if ($this->Auth->loggedIn() && !empty($managerOfCurrentSpot)): ?>
	<div class="navbar-admin">
		<div class="container">
			<div class="btn-group">
				
				<a class="btn btn-dark" href="<?php echo $this->webroot; ?>spots/edit/<?php echo $spot['Spot']['id']; ?>">Manage this Spot</a>
				<a class="btn btn-dark" href="<?php echo $this->webroot; ?>deals/manage/<?php echo $spot['Spot']['id']; ?>">Manage Specials</a>
				
				<?php echo $this->Html->link('Manage Managers', array('controller'=>'managers', 'action'=>'by_spot', $spot['Spot']['id']), array('class' => 'btn btn-dark')); ?>
				<?php echo $this->Html->link('Manage Payments', array('controller' => 'payments', 'action' => 'method', $spot['Spot']['id'], "admin" => false), array('class' => 'btn btn-dark')); ?>
				<?php echo $this->Html->link('Manage Hours of Operation', array('controller'=>'hours_of_operations', 'action'=>'manage', $spot['Spot']['id']), array('class' => 'btn btn-dark')); ?>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php if (isset($spots_i_manage) && count($spots_i_manage)): ?>
<!-- #feedModal -->
<div class="modal modal-feed hide" id="attachmentModal">
	<div class="modal-header">
		<a class="close" data-dismiss="modal"></a>
		<h4><i class="icon-pencil"></i>Post Feed</h4>
	</div>
	<div class="modal-body">
		<?php echo $this->Form->create('Attachment', array('type' => 'file', 'class' => 'form-vertical control-group', 'url' => array('controller' => 'attachments', 'action' => 'add'))); ?>
			<?php
				echo $this->Form->hidden('spot_id', array('value' => $spot['Spot']['id']));
				echo $this->Form->input('file.', array('type' => 'file', 'div' => 'control-fields', 'multiple', 'label' => 'Attachments (select multiple)', 'data-type' => 'file-input'));
			?>
			<div class="btn-group pull-right">
				<?php echo $this->Form->button('Post to Gallery', array('type' => 'submit', 'class' => 'btn-blue')); ?>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div><!-- end of #feedModal -->
<?php endif; ?>

<div class="main-content page-new spot">
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
					// if ($spot['Spot']['rating_count']):
						// echo $this->element('piece-rating_system');
					// endif; ?>
					<div class="row">
						<?php if ($spot['Spot']['spotlight_1']): ?>
							<h4>
								<span class="icon-wrapper"><i class="icon-spotlight">&#128266;</i></span>
								Spotlight Box
							</h4>
							<div class="block block-darkgray spot-custom-content large">
								
								<div class="spotlight-highlight-wrapper">
									<div class="spotlight-highlight">
										<?php echo $spot['Spot']['spotlight_1_parsed']; ?>
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
						<div class="spot-description block-darkgray block">
							<?php echo $spot['Spot']['description_parsed']; ?>
						</div>
					</div>

					<div class="four columns">
						<?php if ($spot['Spot']['spotlight_2']): ?>
							<h4>Spotlight Mini</h4>
							<div class="block block-darkgray spot-custom-content small">
								<?php echo $spot['Spot']['spotlight_2_parsed']; ?>
							</div>
						<?php endif; ?>

						<?php if ($happy_hour_data): ?>
						<div class="block block-darkgray happy-hour">
							<?php echo $this->element('piece-happy_hour', array("happy_hour_size" => "large")); ?>
						</div>
						<?php endif; ?>

						<!-- Show SpotOption if not empty -->
						<?php if (count($spot['SpotOption'])): ?>
							<h4>Spot Features</h4>
							<div class="block block-darkgray">	
								<ul class="spot-options">
									<?php foreach ($spot['SpotOption'] as $spotOption): ?>
										<li><i class="<?php echo h($spotOption['css_class']); ?>"></i><?php echo h($spotOption['name']); ?></li>
									<?php endforeach; ?>
								</ul>
							</div>	
						<?php endif; ?>
						<!-- Show SpotOption if not empty -->
						<?php if (count($other_spots)): ?>
							<h4>Other Locations</h4>
							<div class="block block-darkgray">	
								<ul class="other-spot">
									<?php foreach ($other_spots as $otherSpot): ?>
										<li>
											<?php 
												$address = $otherSpot['Spot']['address'] . 
													($otherSpot['Spot']['address2']?' ' . $otherSpot['Spot']['address2']:'') . 
													' ' . $otherSpot['Spot']['city'] . 
													', ' . $otherSpot['Spot']['state'] . 
													' ' . $otherSpot['Spot']['zip'];
												echo $this->Html->link(h($address), array('action' => 'view', $otherSpot['Spot']['id']));
											?>
										</li>
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
					<div class="block block-darkgray block-glow">
						<h4><i class="icon-picture"></i> Gallery</h4>
						<div class="gallery">
							<?php foreach ($attachments as $attachment): ?>
								<a class="gallery-image" data-attachment-id="<?php echo $attachment['Attachment']['id']; ?>" href="javascript:void(0);" title="<?php echo h($attachment['Attachment']['name']); ?>"><img src="<?php echo $this->Html->gen_path('attachment', $attachment['Attachment']['id'], 100); ?>" alt="<?php echo h($attachment['Attachment']['name']); ?>"></a>
							<?php endforeach; ?>
						</div>
						<a class="more" id="more-pics" href="javascript:void(0);">More Pics ›</a>
						<a id="add-pics" href="javascript:void(0);" onclick="return false;">Add Pics</a>
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
				<?php if (empty($spot['Spot']['is_premium']) && $managerOfCurrentSpot): ?>
					<div class="twelve columns block-slider">
						<div class="premium disabled">
							<p>Upgrade to Premium</p>
						</div>
						
						<?php echo $this->element('mod-disabled_filtered_items'); ?>
					</div>
				<?php elseif (!empty($spot['Spot']['is_premium'])): ?>
					<div class="twelve columns block-slider">
						<div class="block-slider-nav">
							<a class="left" href="javascript:void(0);"></a>
							<a class="right" href="javascript:void(0);"></a>
						</div>
						<?php echo $this->element('mod-filtered_items', array('class' => 'fixed block-slider-container')); ?>
					</div>
				<?php endif; ?>
				
			</div>
			<a name="feeds"></a>
				<?php
				echo $this->element('mod-spot_feed');
				?>
			<span id="reviews"></span>
			<div class="row row-fix">
				<div class="block block-darkgray nh">
					<h4><i class="icon-pencil"></i> Spot Notes</h4>
				</div>
				<div class="twelve note-slider">
					<div class="block-slider-nav note-slider-nav">
						<a class="left" href="javascript:void(0);"></a>
						<a class="right" href="javascript:void(0);"></a>
					</div>
					<?php echo $this->element('mod-spot_reviews'); ?>
				</div>	
				<div class="block-actions btn-group">
					<a class="btn btn-blue" href="javascript:void(0);" onclick="$('#reviewModal').modal();"><i class="icon-pencil"></i>Add Note</a>
					<a class="btn" href="<?php echo $this->webroot; ?>reviews/reviews_by_spot/<?php echo $spot['Spot']['id']; ?>">Show More Notes</a>
				</div>
			</div>
		</div>
	</div>
</div>

<script src="/js/nf-slider-call.js"></script>

<script>

	$(document).ready(function() {
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

		var netflixviewer = new NetflixViewer({
			click_left: '.left',
			click_right: '.right',
			container: '.block-slider',
			slider: '.block-slider-container',
			item_padding: 10,
			el: $('.block-slider').parent(),
			slider_speed: 15,
			slider_distance: 6
		});
	});

	//add a hover effect to the tile image
	$('.tile').hover(
		function() {
			$(this).children('.tile-footer').children('.block-actions').slideDown(200);
		},
		function() {
			$(this).children('.tile-footer').children('.block-actions').slideUp(200);
		}
	);
	
	//initially hide the buttons
	$('.tile-footer .block-actions').hide();
	
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
	
	// Add triger for clicking "Add Pics"
	$('#add-pics').click(function() {
		$('#attachmentModal').modal();
		return false;
	});
</script>
<?php echo $this->element('mod-gallery'); ?>