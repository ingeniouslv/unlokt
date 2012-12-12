<div class="main-content page spot">
	<div class="container">
		<h1>New Payment Method</h1>
		<div class="row">
			<div class="six columns">
				<?php echo $this->Form->create('CreditCard', array('url' => array( 'controller' => 'spots', 'action' => 'add_payment_method'))); ?>
					<div class="half">
						<div class="layout-row">
							<div class="half">
								<?php echo $this -> Form -> input('first_name', array('class' => 'input-full')); ?>
							</div>
							<div class="half">
								<?php echo $this -> Form -> input('last_name', array('class' => 'input-full')); ?>
							</div>
						</div>
						<?php echo $this -> Form -> input('address', array('class' => 'input-full')); ?>
						<?php echo $this -> Form -> input('address2', array('class' => 'input-full')); ?>
						<div class="layout-row">
							<div class="fourth">
								<?php echo $this -> Form -> input('city', array('class' => 'input-full')); ?>
							</div>
							<div class="fourth">
								<?php echo $this -> Form -> input('state', array('class' => 'input-full', 'label' => 'State/Province')); ?>
							</div>
							<div class="fourth">
								<?php echo $this -> Form -> input('zip', array('class' => 'input-full', 'label' => 'ZIP/Postal')); ?>
							</div>
							<div class="fourth">
								<?php echo $this -> Form -> input('country', array('type' => 'select', /*'options' => $country_codes,*/	'class' => 'select-full')); ?>
							</div>
						</div>
						<?php echo $this -> Form -> input('credit_card_number', array('class' => 'input-full')); ?>
						<div class="layout-row">
							<div class="third">
								<?php echo $this -> Form -> input('expiration_month', array('type' => 'select', 'options' => array(1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 10, 11 => 11, 12 => 12), 'class' => 'select-full'));
									$years = array();
									for ($i = 0; $i < 8; $i++) {
										$year = date('Y') + $i;
										$years[$year] = $year;
									}
								?>
							</div>
							<div class="third">
								<?php echo $this -> Form -> input('expiration_year', array('type' => 'select', 'options' => $years, 'class' => 'select-full')); ?>
							</div>
							<div class="third">
								<?php echo $this->Form->input('cvv',array('label'=>'CVV', 'class' => 'input-small')); ?>
							</div>
						</div>
					</div>
				<?php echo $this->Form->end('Submit'); ?>
			</div>
		</div>
	</div>
</div>