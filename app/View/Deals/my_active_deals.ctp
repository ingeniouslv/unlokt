<?php
$this->set('title_for_layout', 'My Active Spot Specials');
?>
<div class="main-content page deal">
	<div class="container">
		<h1>My Active Spot Specials</h1>
	</div>
</div>

<div class="container">
	<?php echo $this->element('mod-filtered_items', array('class' => 'fixed')); ?>
</div>