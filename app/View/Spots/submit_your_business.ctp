<?php
$this->set('title_for_layout', 'Submit Your Business');
?>
<div class="main-content page spot">
	<div class="container">
		<h1>Submit Your Business</h1>
		<?php echo $this->Form->create('Spot', array('class' => 'form-vertical control-group')); ?>
			<div class="row">
				<div class="eight columns">
					<div class="half">
						<div class="layout-row">
							<div class="row">
								<div class="twelve columns">
									<div class="five pull-left">
										<?php echo $this->Form->input('name', array('label' => 'Name of Business', 'class' => 'input-full')); ?>
									</div>	
								</div>
							</div>
						</div>
						<div class="layout-row">
							<div class="row">	
								<div class="twelve columns">	
									<div class="five pull-left">
										<?php echo $this->Form->input('address', array('class' => 'input-full')); ?>
									</div>
									<div class="five pull-left">
										<?php echo $this->Form->input('address2', array('class' => 'input-full', 'label' => 'Address 2')); ?>
									</div>
								</div>	
							</div>	
						</div>
						
						<div class="layout-row">
							<div class="row">	
								<div class="twelve columns">	
									<div class="five pull-left">
										<?php echo $this->Form->input('city', array('class' => 'input-full')); ?>
									</div>
									<div class="two pull-left">
										<?php echo $this->Form->input('state', array('class' => 'input-full')); ?>
									</div>
									<div class="three pull-left">
										<?php echo $this->Form->input('zip', array('class' => 'input-full')); ?>
									</div>
								</div>	
							</div>	
						</div>
						
						<div class="layout-row">
							<div class="row">
								<div class="twelve columns">
									<div class="five pull-left">
										<?php echo $this->Form->input('email', array('class' => 'input-full', 'label' => 'Email Address')); ?>
										
									</div>
									<div class="five pull-left">
										<?php echo $this->Form->input('phone', array('class' => 'input-full', 'maxLength' => 16)); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php echo $this->Form->button('Submit Business', array('type' => 'submit', 'class' => 'btn-blue btn')); ?>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>