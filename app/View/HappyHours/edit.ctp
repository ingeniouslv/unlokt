<div class="main-content page spot">
	<div class="container">
		<div class="row">
			<div class="nine">
				<h1>Create Happy Hour for <a href="<?php echo $this->webroot; ?>spots/view/<?php echo $spot['Spot']['id']; ?>"><?php echo h($spot['Spot']['name']); ?></a></h1>
				<?php
					echo $this->Form->hidden('id');
					echo $this->Form->hidden('spot_id');
				?>
				<div class="control-fields">
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
			</div>
		</div>
	</div>
</div>
<div class="happyHours form">
<?php echo $this->Form->create('HappyHour'); ?>
	<fieldset>
		<legend><?php echo __('Edit Happy Hour'); ?></legend>
	
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
