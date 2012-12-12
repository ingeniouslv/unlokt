<?php
$this->set('title_for_layout', h("Add Note for {$spot['Spot']['name']}"));
?>
<div class="main-content page spot">
	<div class="container">
		<h1><?php echo h('Add Note for'); ?> <?php echo $this->Html->link($spot['Spot']['name'], array('controller' => 'spots', 'action' => 'view', $spot['Spot']['id']))?></h1>

		<?php echo $this->Form->create('Review', array('class' => 'form-vertical control-group')); ?>
			<?php
				echo $this->Form->input('name', array('label' => 'Title for Note', 'div' => 'control-fields'));
				echo $this->Form->input('review', array('div' => 'control-fields'));
				echo $this->Form->input('stars', array('type' => 'select', 'div' => 'control-fields', 'options' => array(''=>'-Select-',1=>1,2=>2,3=>3,4=>4,5=>5)));
			?>
			<div class="btn-group">
				<?php echo $this->Form->button('Submit Note', array('type' => 'submit', 'class' => 'btn btn-red')); ?>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>