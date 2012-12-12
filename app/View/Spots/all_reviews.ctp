<!-- View Stub -->
<?php
$this->set('title_for_layout', "Notes For '".h($spot['Spot']['name']))."'";
?>
<div class="container">
	<div class="row">
		<div class="nine columns">
			<?php echo $this->element('mod-spot_reviews'); ?>
		</div>
	</div>
</div>
