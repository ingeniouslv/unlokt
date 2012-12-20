<?php
$this->set('title_for_layout', "Editing Category '".h($this->data['Category']['name'])."'");
?>
<div class="main-content page category">
	<div class="container">
		<h1>Edit Category</h1>
		<div class="row">
			<div class="six columns">
				<?php echo $this->Form->create('Category', array( 'class' => array('form-vertical control-group'))); ?>
				
					<?php echo $this->Form->input('id', array('hiddenField' => true)); ?>
					
					<h2 class="form-section-label">Category Information</h2>
					<?php
						echo $this->Form->input('name', array('div' => 'control-fields', 'class' => 'input-full', 'label' => false, 'placeholder' => 'Name'));
						echo $this->Form->input('parent_id', array('empty' => 'No Parent', 'div' => 'control-fields', 'class' => 'input-full', 'options' => $parentCategories));
					?>
					<div class="btn-group">
						<a class="btn" href="">Cancel</a>
						<?php echo $this->Form->submit('Update Category', array('div' => false, 'class' => 'btn btn-blue')); ?>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
