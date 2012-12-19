<?php
$this->set('title_for_layout', "Add Happy Hour to '". h($spot['Spot']['name']). "'");
?>
<div class="main-content page spot">
	<div class="container">
		<div class="row">
			<div class="nine">
				<div class="happyHours add">
					<?php $this->set('title_for_layout', 'Add Happy Hour for '.h($spot['Spot']['name'])); ?>
					<div class="happyHours form">
						<?php echo $this->Form->create('HappyHour'); ?>
							<h1>Create Happy Hour for <a href="<?php echo $this->webroot; ?>spots/view/<?php echo $spot['Spot']['id']; ?>"><?php echo h($spot['Spot']['name']); ?></a></h1>
							
							<div class="control-fields">

								<?php echo $this->Form->input('Title', array('type' => 'text', 'div' => 'five required')); ?>

								<?php
									echo $this->Form->input('start', array('type' => 'text', 'div' => 'control-fields', 'class' => 'timepicker', 'value' => ''));
									echo $this->Form->input('end', array('type' => 'text', 'div' => 'control-fields', 'class' => 'timepicker', 'value' => ''));
								?>
							</div>
							<h2> Day of Week</h2>
							<div class="control-fields inline-radios">
								<?php echo $this->Form->radio('day_of_week', array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'), array('type' => 'radio', 'div' => 'control-fields inline-radios', 'legend' => false, 'selected' => 'Monday')); ?>
							</div>
							<div class="btn-group">
								<?php echo $this->Form->submit('Submit', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
							</div>
						<?php echo $this->Form->end(); ?>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>				