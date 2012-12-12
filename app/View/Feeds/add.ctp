<?php
$this->set('title_for_layout', 'Add Feed');
?>
<div class="main-content page spot">
	<div class="container">
		<h1>Add Feed</h1>
		<?php echo $this->Form->create('Feed', array('type' => 'file', 'class' => 'form-vertical control-group')); ?>
			<?php
				if (count($spots_i_manage) > 1) {
					echo $this->Form->input('spot_id', array('div' => 'control-fields', 'options' => $spots_i_manage));
				}
				echo $this->Form->input('feed', array('type' => 'textarea', 'div' => 'control-fields', 'label' => 'Message'));
				echo $this->Form->input('file.', array('type' => 'file', 'div' => 'control-fields', 'multiple', 'label' => 'Attachments (select multiple)', 'data-type' => 'file-input'));
			?>
			<div class="btn-group">
				<?php echo $this->Form->button('Post to Feed', array('type' => 'submit', 'class' => 'btn-blue')); ?>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div>