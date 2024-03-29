<?php
$this->set('title_for_layout', "Add Payment Method to '".$spot['Spot']['name']."'");
?>
<div class="main-content page spot">
	<?php echo $this->Form->create(false, array('id' => 'CreditCardAddPaymentMethodForm')); ?>
	<div class="container">
		<h1>New Payment Method for <?php echo $this->Html->link($spot['Spot']['name'], array('controller' => 'spots', 'action' => 'view', $spot['Spot']['id'])); ?></h1>
		<div>
			<h2>Pick a Plan</h2>
			<div class="three columns pull left;">
				<?php foreach ($plans as $plan): ?>
					<label>
						<input type="radio" name="plan_id" value="<?php echo $plan['Plan']['id']; ?>" <?php echo isset($this->request->data['plan_id']) && $this->request->data['plan_id'] == $plan['Plan']['id'] ? 'checked' : null; ?>> <?php echo h($plan['Plan']['name']); ?>
						-
						$<?php echo number_format($plan['Plan']['price'], 2); ?></p>
					</label>
				<?php endforeach; ?>
				<div>
					Have a code for another plan?<br>
					Enter it here.
					<?php echo $this->Form->input('CreditCard.code', array('class' => 'input-small', 'label' => false, 'placeholder' => 'Code')); ?>
					<a class="btn btn-primary" id="try-code">Try Code</a>
					<script>
						$('#try-code').click(function() {
							if ($(this).attr('disabled')) {
								return;
							}
							location.href = '<?php echo "{$this->webroot}payments/add_payment_method/{$spot['Spot']['id']}"; ?>/' + $('#CreditCardCode').val();
						});
						$('#CreditCardCode').keyup(function() {
							$('#try-code').attr('disabled', !$(this).val());
						}).keyup().keydown(function(event) {
							if (event.which == 13) {
								event.preventDefault();
								$('#try-code').click();
							}
						});
					</script>
				</div>
				<div id="code-results">
					<!-- Placeholder for display of valid code redemptions -->
				</div>
			</div>
		
			<div class="eight columns">	
				<label class="wrap credit active">	
					<input type="radio" class='payType' name="payment_type" value="credit_card" checked="true">
					<i class="payment-icon visa"></i>
					<i class="payment-icon american_express"></i>
					<i class="payment-icon mastercard"></i>
					<i class="payment-icon discover"></i>
				</label>	
				<label class="wrap paypal">	
					<input type="radio" class='payType' name="payment_type" value="paypal">
					<i class="payment-icon paypal"></i>
				</label>	
				<script>
					$('.payType').on('change', function() {
						switch($(this).val()){
							case 'credit_card':
								$('.paypal-form').hide();
								$('.credit-card-form').show();
								$('.credit').addClass("active");
								$('.paypal').removeClass("active");
								break;
							case 'paypal':
								$('.credit-card-form').hide();
								$('.paypal-form').show();
								$('.paypal').addClass("active");
								$('.credit').removeClass("active");
								break;
						}
					});
				</script>
				<div class="row credit-card-form">
					<div class="twelve columns">
							<div class="half">
								<div class="layout-row">
									<div class="row card-info">
										<div class="twelve columns">
											<div class="five pull-left">
												<?php echo $this -> Form -> input('CreditCard.credit_card_number', array('class' => 'input-full')); ?>
											</div>
											<div class="two pull-left">
												<?php echo $this->Form->input('CreditCard.cvv',array('label'=>'CVV', 'class' => 'input-full')); ?>
											</div>
											<div class="pull-left">												
												<?php echo $this -> Form -> input('CreditCard.expiration_month', array('type' => 'select', 'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12), 'class' => 'select-full', 'label' => 'Month'));
													$years = array();
													for ($i = 0; $i < 8; $i++) {
														$year = date('Y') + $i;
														$years[$year] = $year;
													}
												?>
											</div>
											<div class="pull-left">
												<?php echo $this -> Form -> input('CreditCard.expiration_year', array('type' => 'select', 'options' => $years, 'class' => 'select-full', 'label' => 'Year')); ?>
											</div>										
										</div>
									</div>
								</div>
								<div class="layout-row">
									<div class="row">	
										<div class="twelve columns">	
											<div class="five pull-left">
												<?php echo $this -> Form -> input('CreditCard.first_name', array('class' => 'input-full')); ?>
											</div>
											<div class="five pull-left">
												<?php echo $this -> Form -> input('CreditCard.last_name', array('class' => 'input-full')); ?>
											</div>
										</div>	
									</div>	
								</div>
								<div class="layout-row">
									<div class="row">	
										<div class="twelve columns">	
											<div class="five pull-left">
												<?php echo $this -> Form -> input('CreditCard.address', array('class' => 'input-full')); ?>
											</div>
											<div class="five pull-left">
												<?php echo $this -> Form -> input('CreditCard.address2', array('class' => 'input-full')); ?>
											</div>
										</div>	
									</div>	
								</div>
								<div class="layout-row">
									<div class="row">	
										<div class="twelve columns">	
											<div class="five pull-left">
												<?php echo $this -> Form -> input('CreditCard.city', array('class' => 'input-full')); ?>
											</div>
											<div class="two pull-left">
												<?php echo $this -> Form -> input('CreditCard.state', array('class' => 'input-full', 'label' => 'State/Province')); ?>
											</div>
											<div class="three pull-left">
												<?php echo $this -> Form -> input('CreditCard.zip', array('class' => 'input-full', 'label' => 'ZIP/Postal')); ?>
											</div>
										</div>	
									</div>	
								</div>
								<div class="layout-row">
									<div class="row">	
										<div class="twelve columns">	
											<div class="five pull-left">
												<?php echo $this -> Form -> input('CreditCard.country', array('type' => 'select', 'options' => $country_codes,	'class' => 'select-full')); ?>
											</div>
										</div>	
									</div>	
								</div>
								<div class="layout-row">
									<div class="row">	
										<div class="twelve columns">
											<div class="five pull-left">
												<?php echo $this -> Form -> input('CreditCard.accept_business', array(
													'label' => 'I accept the '. $this->Html->link('business agreement', array('controller' => 'pages', 'action' => 'business'), array('target' => '_blank')),
													'type' => 'checkbox',
													'div' => array('class' => 'input checkbox required')
												)); ?>
											</div>
										</div>	
									</div>	
								</div>
							</div>
						
						<?php echo $this->Form->button('Continue', array('class' => 'btn btn-blue btn-large')); ?>
					</div>
				</div>
				<div class="row paypal-form hide">
					<div class="columns">
						<h2>Pay with your Paypal account</h2>
						<p>Continue below to validate your account with Paypal.<br>If you don't have a Paypal account select "Sign Up" or "Buy as Guest"<br> on the next screen.</p>
						<div class="twelve">
							<?php echo $this -> Form -> input('CreditCard.accept_business_paypal', array(
								'label' => 'I accept the '. $this->Html->link('business agreement', array('controller' => 'pages', 'action' => 'business'), array('target' => '_blank')),
								'type' => 'checkbox',
								'div' => array('class' => 'input checkbox required')
							)); ?>
						</div>
						<button class="btn-blue btn-large btn" id="pay-with-paypal">Continue to Paypal</button>
					</div>
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
		<script>
			$('#pay-with-paypal').click(function(event) {
				event.preventDefault();
				$('#CreditCardAddPaymentMethodForm').attr('action', '<?php echo $this->webroot; ?>payments/add_payment_method_paypal/<?php echo $spot['Spot']['id']; ?>').submit();
			});
		</script>
	</div>	
</div>	