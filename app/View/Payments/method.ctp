<?php
$this->set('title_for_layout', "Payment Method for '".$spot['Spot']['name']."'");
?>
<div class="main-content page spot">
	<div class="container">
		<h1>Payment Method for <?php echo $this->Html->link($spot['Spot']['name'], array('controller' => 'spots', 'action' => 'view', $spot['Spot']['id'])); ?></h1>

		<div class="row">
			<div class="eight columns">
				<ul class="list payment">
					<?php if($spot['Spot']['paypal_profileid']): ?>
						<!-- Begin Payment Method Listing -->
						<li>
							<label>
								
								Your current plan renews every <?php echo $spot['Plan']['name']; ?>, and will be renewed on 
								<?php echo date('m-d-Y', strtotime($spot['Spot']['payment_due_date'])); ?>.
								<!-- <span class="payment-icon visa"></span>
								<b>Visa</b> ending in <b>9477</b> expires on 06/2014 -->
							</label>
							<span class="list-actions">
								<a class="delete" title="Delete this Payment Method"></a>
							</span>
						</li>
						<!-- End Payment Method Listing -->
					<?php else: ?>
						<li>
							<label>
								Thank you for being part of UNLOKT beta.<br/> Our exclusive membership fee does not apply during the beta.<br/> We will notify you once the beta is complete. Thank you!
							</label>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<div class="btn-group">
			<?php echo $this->Html->link('Add a New Payment Method', array('action' => 'add_payment_method', $spot['Spot']['id'], 'admin' => false), array('class' => 'btn btn-blue btn-large')); ?>
			<?php echo $this->Html->link('Account History', array('action' => 'history', $spot['Spot']['id'], 'admin' => false), array('class' => 'btn btn-large')); ?>
		</div>
	</div>
</div> 