<?php
$this->set('title_for_layout', "Editing Page '".$this->data['Page']['title'] ."'");
?>
<div class="main-content page">
	<div class="container">
		<h1>Edit Page</h1>
		<div class="row">
			<div class="six columns">
				<?php echo $this->Form->create('Page', array( 'class' => array('form-vertical control-group'))); ?>
				
					<?php echo $this->Form->hidden('id'); ?>
					
					<h2 class="form-section-label">Page Information</h2>
					<?php
						echo $this->Form->input('title', array('div' => 'control-fields', 'class' => 'input-full required', 'label' => false, 'placeholder' => 'Title'));
						echo $this->Form->input('slug', array('div' => 'control-fields', 'class' => 'input-full required', 'label' => false, 'placeholder' => 'Slug'));
						echo $this->Form->input('is_published', array('div' => 'control-fields', 'class' => 'input-full required', 'label' => 'Published'));
						echo $this->Form->input('body', array('div' => 'control-fields', 'class' => 'required spot-spotlight_1-editor', 'label' => false, 'placeholder' => 'Body', 'data-type' => 'editor'));
					?>
					<div class="btn-group">
						<a class="btn" href="">Cancel</a>
						<?php echo $this->Form->submit('Update Page', array('div' => false, 'class' => 'btn btn-blue')); ?>
					</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
