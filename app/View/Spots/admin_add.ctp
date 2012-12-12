<?php
$this->set('title_for_layout', 'Add a Spot');
?>
<div class="main-content page spot">
	<div class="container">
		<h1>Create a Spot</h1>
		<div class="row">
			<div class="six columns">
				<?php echo $this->Form->create('Spot', array('class' => 'form-vertical control-group')); ?>

				<h2 class="form-section-label">Information</h2>
				<?php echo $this->Form->input('name', array('div' => 'control-fields', 'class' => 'input-full', 'label' => false, 'placeholder' => 'Name')); ?>
				
				<h2 class="form-section-label">Location</h2>
				<?php
				echo $this->Form->input('address', array('div' => 'control-fields', 'class' => 'input-full', 'label' => false, 'placeholder' => 'Address'));
				echo $this->Form->input('address2', array('div' => 'control-fields', 'class' => 'input-full', 'label' => false, 'placeholder' => 'Address 2'));
				?>
				<div class="control-group row">
					<div class="seven columns">
						<?php echo $this->Form->input('city', array('div' => 'control-fields', 'class' => 'input-full', 'label' => false, 'placeholder' => 'City')); ?>
					</div>
					<div class="two columns">
						<?php echo $this->Form->input('state', array('div' => 'control-fields', 'class' => 'input-full', 'label' => false, 'placeholder' => 'State')); ?>
					</div>
					<div class="three columns">
						<?php echo $this->Form->input('zip', array('div' => 'control-fields', 'class' => 'input-full', 'label' => false, 'placeholder' => 'ZIP / Postal')); ?>
					</div>
				</div>

				<div class="control-group row">
					<div class="six columns">
						<?php echo $this->Form->input('lat', array('div' => 'control-fields', 'label' => false, 'placeholder' => 'Latitude', 'class' => 'input-full')); ?>
					</div>
					<div class="six columns">
						<?php echo $this->Form->input('lng', array('div' => 'control-fields', 'label' => false, 'placeholder' => 'Logitude', 'class' => 'input-full')); ?>
					</div>
				</div>

				<h2 class="form-section-label">Details</h2>
				<?php
				echo $this->Form->input('phone', array('div' => 'control-fields', 'label' => false, 'placeholder' => '(702) 987-3333'));
				echo $this->Form->input('url', array('div' => 'control-fields', 'label' => 'URL', 'placeholder' => 'http://www.example.com', 'class' => 'input-full'));
				echo $this->Form->input('email', array('div' => 'control-fields', 'label' => 'Business Email', 'placeholder' => 'info@example.com', 'class' => 'input-full'));
				echo $this->Form->input('Category', array('div' => 'control-fields', 'class' => 'input-full'));
				echo $this->Form->input('SpotOption', array('div' => 'control-fields', 'label' => 'Spot Options', 'class' => 'input-full'));
				?>
				
				<h2 class="form-section-label">Profile</h2>
				<?php echo $this->Form->input('spotlight_1', array('div' => 'control-fields', 'label' => 'Spotlight', 'class' => 'spot-spotlight_1-editor', 'data-type' => 'editor')); ?>
				<?php echo $this->Form->input('description', array('div' => 'control-fields', 'class' => 'spot-description-editor', 'data-type' => 'editor')); ?>
				<?php echo $this->Form->input('spotlight_2', array('div' => 'control-fields', 'label' => 'Spotlight Mini', 'class' => 'spot-spotlight_2-editor', 'data-type' => 'editor')); ?>
				
				<h2 class="form-section-label">Super Admin Controls</h2>
					<?php echo $this->Form->input('is_active', array('div' => 'control-fields', 'label' => 'Active')); ?>
					<?php echo $this->Form->input('is_premium', array('div' => 'control-fields', 'label' => 'Premium')); ?>
			
				<div class="btn-group">
					<?php echo $this->Form->submit('Create Spot', array('div' => false, 'class' => 'btn btn-blue')); ?>
				</div>
			<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>

<!-- <div class="main-content page spot">
	<div class="container">
		<div class="row">
			<div class="seven columns">
				<h1>Create a New Spot</h1>

				<?php echo $this->Form->create('Spot', array('class' => 'form-vertical')); ?>

				<h2 class="form-section-label">Spot Name</h2>
				<?php echo $this->Form->input('name', array('label' => false, 'div' => 'control-group', 'class' => 'twelve')); ?>

				<h2 class="form-section-label">Spot Location</h2>
				<?php echo $this->Form->input('address', array('label' => false, 'div' => 'control-group', 'class' => 'twelve', 'placeholder' => 'Address')); ?>
				<?php echo $this->Form->input('address2', array('label' => false, 'div' => 'control-group', 'class' => 'twelve', 'placeholder' => 'Address 2')); ?>

				<div class="control-group">
					<div class="row">
						<div class="four columns">
							<?php echo $this->Form->input('city', array('label' => false, 'div' => false, 'class' => 'twelve', 'placeholder' => 'City')); ?>
						</div>
						<div class="four columns">
							<?php echo $this->Form->input('state', array('label' => false, 'div' => false, 'class' => 'twelve', 'placeholder' => 'State')); ?>
						</div>
						<div class="four columns">
							<?php echo $this->Form->input('zip', array('label' => false, 'div' => false, 'class' => 'twelve', 'placeholder' => 'ZIP / Postal Code')); ?>
						</div>
					</div>
				</div>

				<div class="control-group">
					<div class="row">
						<div class="six columns">
							<?php echo $this->Form->input('lat', array('label' => false, 'div' => false, 'class' => 'twelve', 'placeholder' => 'Latitude')); ?>
						</div>
						<div class="six columns">
							<?php echo $this->Form->input('lng', array('label' => false, 'div' => false, 'class' => 'twelve', 'placeholder' => 'Longitude')); ?>
						</div>
					</div>
				</div>
				
				<div class="btn-group">
					<?php echo $this->Form->submit('Create Spot', array('class' => 'btn btn-blue')); ?>
				</div>
				
				<?php echo $this->Form->end(); ?>
			</div>
		</div>

	</div>
</div> -->