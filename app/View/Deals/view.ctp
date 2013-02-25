<?php
$this->set('title_for_layout', h("{$deal['Deal']['name']} @ {$spot['Spot']['name']}"));
?>

<div class="main-content page-new deal">
	<div class="container">
		<div class="row">
			<div class="nine columns">
				<div class="page-header">
					<div class="photo">
						<img src="<?php echo $this->Html->gen_path('deal', $deal['Deal']['id'], 200); ?>" width="200" height="200">
					</div>
					
						
					<div class="deal-meta columns">
						<h5 class="deal-type">
							<!-- If deal == deal -->
							<?php if ($deal['Deal']['keys'] == 0): ?>
								<i class="icon-calendar"></i> Event
							<?php elseif ($deal['Deal']['keys'] == 1): ?>
								<i class="icon-tag-2"></i> Spot Special
							<?php else: ?>
								<i class="icon-key"></i> Reward
							<?php endif; ?>
						</h5>
					</div>
					<button class="fb-share btn-fb">Share</button>
					<div class="row">
						<h1 class="name"><?php echo h($deal['Deal']['name']); ?></h1>
						<h3><?php echo h($deal['Deal']['description']); ?></h3>

						<?php if ($deal_completed_count): ?>
						<p>
							You have completed this Spot Special <?php echo $deal_completed_count; ?> time<?php echo $deal_completed_count == 1 ? '' : 's'; ?>
						</p>
						<?php endif; ?>
						<?php if ($deal['Deal']['keys']): ?>
							<div class="redeem">	
								<div class="block block-white">
									<?php // if($deal['Deal']['keys'] == 1 && !$activeDeal): ?>
									<?php // endif; ?>

									<?php if ($deal['Deal']['keys'] >= 1): ?>
										<div class="keys">
											<?php if (!isset($activeDeal) || !$activeDeal): ?>
												<?php
												echo str_repeat('<i class="icon-key"></i>', $deal['Deal']['keys']);
												?>
												<span>You need <?php echo $deal['Deal']['keys']; ?> key<?php echo $deal['Deal']['keys'] == 1 ? '' : 's'; ?></span>
											<?php elseif (isset($activeDeal['ActiveDeal']['is_completed']) && !$activeDeal['ActiveDeal']['is_completed']):
												$remaining_keys = ($deal['Deal']['keys'] - $activeDeal['ActiveDeal']['completed_step']);
												echo str_repeat('<i class="icon-key has-key"></i>', $activeDeal['ActiveDeal']['completed_step']);
												echo str_repeat('<i class="icon-key"></i>', $deal['Deal']['keys'] - $activeDeal['ActiveDeal']['completed_step']);
												?>
												<span>You need <?php echo $remaining_keys; ?> more key<?php echo $remaining_keys == 1 ? '' : 's'; ?></span>
											<?php elseif (isset($activeDeal['ActiveDeal']['is_completed']) && $activeDeal['ActiveDeal']['is_completed']): ?>
												<?php echo str_repeat('<i class="icon-key has-key"></i>', $deal['Deal']['keys']); ?>

											<?php endif; ?>
										</div>
									<?php endif; ?>
									<?php if (!$deal['Deal']['limit_per_customer'] || $deal_completed_count < $deal['Deal']['limit_per_customer']): ?>
										<?php if ($deal['Deal']['keys'] > 1): ?>
											<div class="redeem-activity">	
												<div class="pull-right">
													<span class="keys-total large"><?php echo $deal['Deal']['keys']; ?></span>
													<?php echo $this->Html->link('Redeem', 'javascript:void(0);', array('class' => 'btn btn-yellow btn-jumbo', 'id' => 'redeemButton')); ?>
												</div>
											</div>	
										<?php elseif ($deal['Deal']['keys'] <= 1): ?>
											<div class="redeem-activity">	
												<div class="pull-right">
													<?php echo $this->Html->link('Redeem', 'javascript:void(0);', array('class' => 'btn btn-yellow btn-jumbo', 'id' => 'redeemButton')); ?>
												</div>
											</div>	
										<?php endif; ?>
									<?php endif; ?>
									<?php if (isset($activeDeal['ActiveDeal']['is_completed']) && $activeDeal['ActiveDeal']['is_completed']): ?>
										<div class="redemption">
											<div class="text-center">
												<h2>Hurray! You've Unlokt this Spot Special</h2> <?php echo date('F jS, Y g:i A', strtotime($activeDeal['ActiveDeal']['completed_date'])); ?>.
											</div>
											<?php if (!empty($deal['Deal']['sku'])): ?>
												<div class="redeem-code twelve">
												 	<span>Spot Owner Enter this Code:</span>
													<code>
														<?php echo h($deal['Deal']['sku']); ?>
													</code>
												</div>
											<?php endif; ?>
										</div>	
									<?php endif; ?>
								</div>
							</div><!-- end of .redeem -->
						<?php endif; ?>
					</div>
				</div>
				<div class="row">
					<div class="twelve columns">
						<div class="content-group">
							<?php if (!$deal['Deal']['keys']): ?>
								<p class="lead">Event Detail</p>
							<?php else: ?>
								<p class="lead">The Spot Special</p>
							<?php endif; ?>
							<p><?php echo h($deal['Deal']['long_description']); ?></p>
						</div>
						<?php if (!empty($deal['Deal']['fine_print'])): ?>
							<div class="content-group">
								<p class="lead">Fine Print</p>
								<p><?php echo h($deal['Deal']['fine_print']); ?></p>
							</div>
						<?php endif; ?>
					</div>
				</div>
				<div class="row">
					<div class="four columns">
						<?php if($deal['Deal']['keys'] > 0 && $is_manager): ?>
							<div class="content-group">
								<p class="lead">Redemption Codes</p>
								<p>
									<ul>
										<?php foreach($deal['RedemptionCode'] as $redemption_code): ?>
											<li>Step <?php echo $redemption_code['step']. " - ". $redemption_code['code']; ?></li>
										<?php endforeach; ?>
									</ul>
								</p>
								
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="three columns bleed-over-content">
				<?php echo $this->element('mod-spot_information'); ?>
			</div>
		</div>
	</div>
</div>
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
		</div>	
	</div>
</div>
<div class="modal modal-redeem hide" id="redeemModal">
	<div class="modal-header">
		<a class="close" data-dismiss="modal"></a>
		<h4><i class="icon-key"></i>Redeem</h4>
	</div>
	<div class="modal-body">
		<label for="redemption-code">Enter redemption code for step #<?php echo (isset($activeDeal['ActiveDeal']['completed_step']) && !$activeDeal['ActiveDeal']['is_completed'] ? $activeDeal['ActiveDeal']['completed_step'] + 1 : 1); ?>:</label>
		<p class="message"><i></i></p>
		<div class="control-fields">
			<input type="text" class="twelve" id="redemption-code" placeholder="Redemption Code">
		</div>
		<div class="btn-group">
			<button class="btn btn-yellow btn-jumbo twelve" id="executeRedeem">Redeem</button>
		</div>
	</div>
</div>
<div id="fb-root"></div>
<script>
	$('.fb-share').click(function() {
		
		FB.init({
			appId      : '<?php echo $app_id; ?>', // App ID
			channelUrl : '<?php echo $channel_url; ?>', // Channel File
			status     : true, // check login status
			cookie     : true, // enable cookies to allow the server to access the session
			xfbml      : true  // parse XFBML
		});
		FB.ui({ 
			method: 'feed',
			name: '<?php echo h($deal['Deal']['name']); ?>',
			caption: '<?php echo h($deal['Deal']['description']); ?>',
			description: '<?php echo h($deal['Deal']['long_description']); ?>',
			picture: '<?php echo "http://development.unlokt.com".$this->Html->gen_path('deal', $deal['Deal']['id'], 200); ?>',
			link: 'http://development.unlokt.com/deals/view/<?php echo $deal['Deal']['id']; ?>' 
		});
	});
	
	// Load the SDK Asynchronously
	(function(d){
		var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/en_US/all.js";
			ref.parentNode.insertBefore(js, ref);
	}(document));
</script>

<script src="/js/nf-slider-call.js"></script>

<script>

	$(document).ready(function() {

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

	//////////////////////////////////////////////////
	
	$('#redeemButton').click(function() {
		unlokt.check_privileges();
		$('#redeemModal').modal();
		$('#redemption-code').focus();
	});
	
	//////////////////////////////////////////////////
	
	// Make the [enter] button in the text input box trigger the submit button.
	$('#redemption-code').keydown(function(event) {
		// Don't send this event up the DOM because it makes typing SLOW.
		event.stopPropagation();
		if (event.which == 13) {
			// Stop the [enter] key from being pressed.
			event.preventDefault();
			// Trigger the same action as if a user clicked the 'Redeem' button in the modal.
			$('#executeRedeem').click();
		}
	});
	
	//////////////////////////////////////////////////
	
	// When the submit button for the 'Redeem' box is pressed, perform this code redemption process.
	$('#executeRedeem').click(function() {
		var code = $('#redemption-code').val();
		var deal_id = <?php echo $deal['Deal']['id']; ?>;
		if (code == '' || code == null) {
			flash_error('Code required.');
			$('#redemption-code').focus();
			return;
		}
		$.getJSON(unlokt.settings.webroot + 'deals/redeem_with_code/' + deal_id + '/' + code, function(data) {
			if (data.type == 'success') {
				// I guess refresh the page since this is good. The new page refresh will show any progress or notifications.
				location.reload();
			} else if (data.type == 'error') {
				// Inform the user that the entered code was incorrect.
				flash_error('Incorrect Code. Try again.');
			} else {
				// Dunno what else to do.
				flash_error('Unexpected response from server.');
			}
		}).error(function() {
			// Dunno what else to do.
			flash_error('Invalid response from server.');
		});
	});
	
	//////////////////////////////////////////////////
	
	function flash_error(error_text) {
		$('#redeemModal .message i').html(error_text);
		$('#redemption-code').focus();
	}
	
</script>