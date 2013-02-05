<div class="main-content page deal">
	<div class="container">
		<h1>Add Hours of Operation for <?php echo h($spot['Spot']['name']); ?></h1>

		<div class="row">
			<div class="three columns tracked-content">
				<?php echo $this->Form->create('HoursOfOperation'); ?>
				<?php echo $this->Form->hidden('spot_id', array('value' => $spot['Spot']['id'])); ?>
				<div class="control-group-row">
					<div class="six columns">
						<?php echo $this->Form->input('open_time', array('type' => 'text', 'class' => 'timepicker2 input-full', 'div' => 'control-fields', 'value' => '8:00 AM')); ?>
					</div>
					<div class="six columns">
						<?php echo $this->Form->input('close_time', array('type' => 'text', 'class' => 'timepicker input-full', 'div' => 'control-fields')); ?>
					</div>
				</div>
				<div class="control-group-row">
					<div class="six columns">
						<?php echo $this->Form->input('start_day', array('options' => array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'), 'div' => 'control-fields', 'class' => 'input-full')); ?>
					</div>
					<div class="six columns">
						<?php echo $this->Form->input('end_day', array('options' => array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'), 'div' => 'control-fields', 'class' => 'input-full')); ?>
					</div>
				</div>
				<div class="control-group-row">
					<div class="six columns">
						<?php echo $this->Form->input('is_closed', array('div' => 'control-fields', 'value' => 1, 'label' => 'Closed')); ?>
					</div>
				</div>
				<div class="btn-group">
					<?php echo $this->Form->button('Add Hours of Operation', array('class' => 'btn btn-blue', 'type' => 'submit')); ?>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
<script>
	$('.timepicker2').timepicker({defaultTime:'value'});
</script>
