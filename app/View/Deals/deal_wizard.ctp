<?php
$this->set('title_for_layout', 'Spot Special Wizard - Step 1');
echo $this->Form->create('Deal', array('class' => 'control-group form-vertical'));
?>

<h2>Choose the Spot for this new Special</h2>
<?php echo $this->Form->input('spot_id', array('label' => false)); ?>

<h2>Fixed Period or Recurring Special?</h2>
<div>
	<label for="fixed">Fixed</label>
	<input type="radio" name="time" id="fixed">
	<div id="radio-fixed">
		Fixed time selection goes here
	</div>
</div>
<div>
	<label for="reoccurring">Reoccurring</label>
	<input type="radio" name="time" id="reoccurring">
	<div id="radio-reoccurring">
		reoccurring time selection goes here
	</div>
</div>

<h2>Special Details</h2>
<?php
echo $this->Form->input('name');
echo $this->Form->input('description');
echo $this->Form->input('long_description');
echo $this->Form->input('fine_print');
echo $this->Form->input('keys');
echo $this->Form->input('sku');
echo $this->Form->input('limit_per_customer');
?>

<?php
echo $this->Form->submit('Next Step');
echo $this->Form->end();
?>