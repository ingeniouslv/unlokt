Choose details for new deal
<?php
$this->set('title_for_layout', 'Spot Special Wizard - Step 2');
echo $this->Form->create('Deal', array('class' => 'control-group form-vertical'));
echo $this->Form->input('name');
echo $this->Form->input('description');
echo $this->Form->input('sku');
echo $this->Form->input('keys');
echo $this->Form->input('redemption_credit');
echo $this->Form->input('limit_per_customer');
echo $this->Form->input('is_public');
echo $this->Form->input('is_active');
echo $this->Form->hidden('spot_id');
?>