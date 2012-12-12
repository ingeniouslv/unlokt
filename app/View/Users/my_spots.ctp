<?php $this->set('title_for_layout', 'My Spots'); ?>
<div class="main-content page user">
	<div class="container">
		<h1>My Spots</h1>
	</div>
</div>
<div class="container">
	<div class="row">
		<div class="nine columns">
	
			<?php echo $this->element('mod-filtered_items', array('class' => 'fixed')); ?>
			<?php echo $this->element('mod-spot_feed'); ?>
			<span id="feeds"></span>
			<span id="reviews"></span>
		</div>
	</div>
</div>