<div class="main-content page spot">
	<div class="container">
		<h1>Payment</h1>

		<div class="row">
			<div class="eight columns">
				<ul class="list payment">
					<!-- Begin Payment Method Listing -->
					<li>
						<label>
							<span class="payment-icon visa"></span>
							<b>Visa</b> ending in <b>9477</b> expires on 06/2014
						</label>
						<span class="list-actions">
							<a class="delete" title="Delete this Payment Method"></a>
						</span>
					</li>
					<!-- End Payment Method Listing -->

					<li>
						<label>
							<span class="payment-icon mastercard"></span>
							<b>Mastercard</b> ending in <b>9477</b> expires on 06/2014
						</label>
						<span class="list-actions">
							<a class="delete" title="Delete this Payment Method"></a>
						</span>
					</li>

					<li>
						<label>
							<span class="payment-icon american_express"></span>
							<b>American Express</b> ending in <b>9477</b> expires on 06/2014
						</label>
						<span class="list-actions">
							<a class="delete" title="Delete this Payment Method"></a>
						</span>
					</li>

					<li>
						<label>
							<span class="payment-icon discover"></span>
							<b>Discover</b> ending in <b>9477</b> expires on 06/2014
						</label>
						<span class="list-actions">
							<a class="delete" title="Delete this Payment Method"></a>
						</span>
					</li>

					<li>
						<label>
							<span class="payment-icon paypal"></span>
							<b>PayPal</b> ending in <b>9477</b> expires on 06/2014
						</label>
						<span class="list-actions">
							<a class="delete" title="Delete this Payment Method"></a>
						</span>
					</li>
				</ul>
			</div>
		</div>

		<div class="btn-group">
			<a href="/spots/add_payment_method" class="btn btn-blue btn-large">Add a New Payment Method</a>
			<?php echo $this->Html->link('Account History', array('controller' => 'spots', 'action' => 'payment_history', $spot['Spot']['id']), array('class' => 'btn btn-large')); ?>
		</div>
	</div>
</div> 