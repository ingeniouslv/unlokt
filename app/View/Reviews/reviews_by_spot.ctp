<?php
$this->set('title_for_layout', 'Notes');
?>
<div class="main-content page review">
	<div class="container">
		<h1>Notes for <?php echo $this->Html->link($spot['Spot']['name'], array('controller' => 'spots', 'action' => 'view', $spot['Spot']['id'])); ?></h1>
		<a class="btn btn-blue" href="javascript:void(0);" onclick="$('#reviewModal').modal();"><i class="icon-pencil"></i>Add Note</a>
		<?php
		echo $this->element('mod-spot_reviews');
		?>
	</div>
</div>