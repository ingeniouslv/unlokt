<?php
$this->set('title_for_layout', h("{$deal['Deal']['name']} @ {$spot['Spot']['name']}"));
?>

<div class="main-content page deal">
	<div class="container">
		<div class="row">
			<div class="nine columns">
				<div class="row">
					<div class="four columns">
						<img src="<?php echo $this->Html->gen_path('deal', $deal['Deal']['id'], 232); ?>" width="232" height="232">
					</div>

					<div class="eight columns">
						
						<div class="deal-meta">
							<h5 class="deal-type">
								<!-- If deal == deal -->
								<?php if ($deal['Deal']['keys'] == 0): ?>
									<i class="icon-coupon"></i> Event
								<?php elseif ($deal['Deal']['keys'] == 1): ?>
									<i class="icon-coupon"></i> Spot Special
								<?php else: ?>
									<i class="icon-tag-2"></i> Spot Special
								<?php endif; ?>
							</h5>
						</div>

						<div class="page-header">
							<h1 class="name"><?php echo h($deal['Deal']['name']); ?></h1>
							<h3><?php echo h($deal['Deal']['description']); ?></h3>
						</div>

						<?php if ($deal_completed_count): ?>
							You have completed this Spot Special <?php echo $deal_completed_count; ?> time<?php echo $deal_completed_count == 1 ? '' : 's'; ?>
						<?php endif; ?>
						<div class="block block-white">
							<div class="keys">
								<?php if (!isset($activeDeal) || !$activeDeal): ?>
									<?php
									echo str_repeat('<i class="icon-key"></i>', $deal['Deal']['keys']);
									?>
									<span>You need <?php echo $deal['Deal']['keys']; ?> keys</span>
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
							<?php if (!$deal['Deal']['limit_per_customer'] || $deal_completed_count < $deal['Deal']['limit_per_customer']): ?>
								<div class="pull-right">
									<span class="keys-total large"><?php echo $deal['Deal']['keys']; ?></span>
									<?php echo $this->Html->link('Redeem', 'javascript:void(0);', array('class' => 'btn btn-red btn-jumbo', 'id' => 'redeemButton')); ?>
								</div>
							<?php else: ?>
								<!-- <div class="pull-right">
									<span class="keys-total large"><?php echo $deal['Deal']['keys']; ?></span>
									ALL REDEEMED OUT
								</div> -->
							<?php endif; ?>
						
						
							<?php if (isset($activeDeal['ActiveDeal']['is_completed']) && $activeDeal['ActiveDeal']['is_completed']): ?>
								<div class="text-center">
									<h2>Hurray! You've Unlokt this Spot Special</h2> <?php echo date('F jS, Y g:i A', strtotime($activeDeal['ActiveDeal']['completed_date'])); ?>.
								</div>
								<div class="redeem-code twelve">
								 	<span>Spot Owner Enter this Code:</span>
									<code>
										<?php echo h($deal['Deal']['sku']); ?>
									</code>
								</div>
							<?php endif; ?>
						</div>

						<div class="content-group">
							<p class="lead">The Spot Special</p>
							<p><?php echo h($deal['Deal']['long_description']); ?></p>
						</div>

						<div class="content-group">
							<p class="lead">Fine Print</p>
							<p><?php echo h($deal['Deal']['fine_print']); ?></p>
						</div>
						<?php if($is_manager): ?>
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
			<?php echo $this->element('mod-filtered_items', array('class' => 'fixed')); ?>
			<?php //echo $this->element('mod-spot_feed'); ?>
			<?php //echo $this->element('mod-spot_reviews'); ?>
		</div>
	</div>
</div>

<script>
	// Trigger the Deal tiles to stagger so beautifully.
	$('#staggered').masonry({
		itemSelector : '.staggered-item'
	});
</script>

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
			<button class="btn btn-red btn-jumbo twelve" id="executeRedeem">Redeem</button>
		</div>
	</div>
</div>

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
		$.get(unlokt.settings.webroot + 'deals/redeem_with_code/' + deal_id + '/' + code, function(data) {
			if (data == 'GOODCODE') {
				// I guess refresh the page since this is good. The new page refresh will show any progress or notifications.
				location.reload();
			} else if (data == 'BADCODE') {
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