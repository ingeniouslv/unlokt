<?php
$this->set('title_for_layout', "Editing Note");
?>
<div class="main-content page review">
	<div class="container">
		
		<?php echo $this->Form->create('Review'); ?>
		<h1>Update Note</h1>
		<div class="row">
			<div class="six columns">
				<?php
					echo $this->Form->hidden('id');
					echo $this->Form->hidden('user_id');
					echo $this->Form->hidden('spot_id');
					echo $this->Form->input('name', array('label' => 'Title for Note', 'div' => 'control-fields'));
					echo $this->Form->input('review', array('div' => 'control-fields'));
					echo $this->Form->input('stars', array('type' => 'select', 'div' => 'control-fields', 'options' => array(''=>'-Select-',1=>1,2=>2,3=>3,4=>4,5=>5)));
				?>
				
				<div class="btn-group">
					<?php echo $this->Form->submit('Update Note', array('div' => false, 'class' => 'btn btn-blue')); ?>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
