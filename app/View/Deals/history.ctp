<?php
$this->set('title_for_layout', 'Spot Special History');
?>

<div class="main-content page deal">
	<div class="container">
		<h1>Spot Specials History</h1>
	</div>
</div>

<div class="container">
	<div class="row fixed">
		<?php echo $this->element('mod-filtered_items'); ?>
	</div>
</div>

<script>
	// Trigger the Deal tiles to stagger so beautifully.
	$('#staggered').masonry({
		itemSelector : '.staggered-item'
	});
	// $("#staggered").gridalicious({
	// 	width: 300,
	// 	gutter: 10,
	// 	selector: '.staggered-item'
	// });
</script>