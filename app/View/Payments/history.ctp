<?php
$this->set('title_for_layout', "Payment History for '".$spot['Spot']['name']."'");
?>
<div class="main-content page spot">
	<div class="container">
		<h1>Payment History</h1>

		<div class="row">
			<div class="eight columns">
				<ul class="list payment-history">
					<?php foreach($payments as $payment): ?>
					<!-- Payment History Listing -->
					<li>
						<div class="row">
							<span class="three columns"><b><?php echo date('F j, Y', strtotime($payment['Payment']['paid_date'])); ?></b></span>
							<span class="six columns">
								<b><?php echo $payment['Payment']['subscription_type']; ?> </b>
								<br>
								<?php echo date('F j, Y', strtotime($payment['Payment']['pay_period_start'])); ?> &ndash; 
								<?php echo date('F j, Y', strtotime($payment['Payment']['pay_period_end'])); ?>
							</span>
							<span class="three columns text-right">
								<b>&ndash;<?php echo $payment['Payment']['amount_paid'] > 0 ? $this->Number->currency($payment['Payment']['amount_paid']): '&ndash;'; ?> </b>
								<br><?php echo $payment['Payment']['pay_method']; ?>
							</span>
						</div>
					</li>
					<!-- End Payment History Listing -->
					<?php endforeach; ?>
				</ul>
				<p>
				<?php
				echo $this->Paginator->counter(array(
				'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
				));
				?>	</p>
			
				<div class="paging">
				<?php
					echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
					echo $this->Paginator->numbers(array('separator' => ''));
					echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
				?>
				</div>
			</div>
		</div>
	</div>
</div>
