<?php if (isset($spots_i_manage) && count($spots_i_manage)): ?>
<!-- #feedModal -->
<div class="modal modal-feed hide" id="feedModal">
	<div class="modal-header">
		<a class="close" data-dismiss="modal"></a>
		<h4><i class="icon-pencil"></i>Post Feed</h4>
	</div>
	<div class="modal-body">
		<?php echo $this->Form->create('Feed', array('type' => 'file', 'class' => 'form-vertical control-group', 'url' => array('controller' => 'feeds', 'action' => 'add'))); ?>
			<?php
				if (count($spots_i_manage) > 1) {
					echo $this->Form->input('spot_id', array('div' => 'control-fields', 'options' => $spots_i_manage));
				}
				echo $this->Form->input('feed', array('type' => 'textarea', 'div' => 'control-fields', 'label' => 'Message'));
				echo $this->Form->input('file.', array('type' => 'file', 'div' => 'control-fields', 'multiple', 'label' => 'Attachments (select multiple)', 'data-type' => 'file-input'));
			?>
			<div class="btn-group pull-right">
				<?php echo $this->Form->button('Post to Feed', array('type' => 'submit', 'class' => 'btn-blue')); ?>
			</div>
		<?php echo $this->Form->end(); ?>
	</div>
</div><!-- end of #feedModal -->
<?php endif; ?>

<?php if (!empty($spot['Spot']['id'])): ?>
	<div class="modal modal-feed hide" id="reviewModal">
		<div class="modal-header">
			<a class="close" data-dismiss="modal"></a>
			<h4><i class="icon-pencil"></i>Add Note</h4>
		</div>
		<div class="modal-body">
			<?php echo $this->Form->create('Review', array('class' => 'form-vertical control-group', 'controller' => 'reviews', 'action' => 'add/'. $spot['Spot']['id'])); ?>
				<?php
					echo $this->Form->input('name', array('label' => 'Title for Note', 'div' => 'control-fields'));
					echo $this->Form->input('review', array('type' => 'textarea', 'label' => 'Note',  'div' => 'control-fields'));
				?>
				<div class="btn-group pull-right">
					<?php echo $this->Form->button('Submit Note', array('type' => 'submit', 'class' => 'btn btn-red')); ?>
				</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div><!-- end of #reviewModal -->
<?php endif; ?>

<header>
	<div class="navbar">
		<?php if ($this->Auth->loggedIn()): ?>
			<div class="container">
				<ul class="nav nav-horizontal pull-right">
					<?php if (isset($spots_i_manage) && count($spots_i_manage)): ?>
						<li><a href="javascript:void(0);" class="text-yellow" onclick="$('#feedModal').modal();"><i class="icon-pencil"></i>Post to Feed</a></li>
						<li><a href="<?php echo $this->webroot; ?>spots">Spots I Manage</a></li>
					<?php endif; ?>
					<li><a href="<?php echo $this->webroot; ?>users/account" title="My Profile">My Profile</a></li>
					<?php if ($this->Auth->user('is_super_admin')): ?>
						<li><a href="<?php echo $this->webroot; ?>admin/users" title="Administration">Administration</a></li>
					<?php endif; ?>
					<li><a href="<?php echo $this->webroot; ?>users/logout?redirect=<?php echo urlencode($this->here); ?>" title="Log out">Log out</a></li>
				</ul>
			</div>
		<?php else: ?>
			<div class="container">
				<ul class="nav nav-horizontal pull-right">
					<li><a href="<?php echo $this->webroot; ?>users/register" title="Sign Up">Sign Up</a></li>
					<li><a href="<?php echo $this->webroot; ?>users/login?redirect=<?php echo urlencode($this->here); ?>" title="Log In">Log In</a></li>
				</ul>
			</div>
		<?php endif; ?>
		
	</div>

	<div class="navbar-big">
		<div class="container">
			<a href="<?php echo $this->webroot; ?>">
				<h1 class="logo">UNLOKT &mdash; Your Key to the City</h1>
			</a>
			<div class="location dropdown dropdown-toggle" href="#" data-toggle="dropdown">
				<?php if(!empty($user) && isset($user['Location']['name'])): ?>
					<h2><i class="icon-direction"></i><?php echo $user['Location']['name']; ?></h2>
				<?php else: ?>
				<h2 id="current-location"><i class="icon-direction"></i>My Location</h2>
				<?php endif; ?>
				<span>Choose a new location</span>

				<div class="dropdown-menu pull-right">
					<?php  echo $this->Form->create('User', array('action' => 'set_location', 'class' => 'form-vertical control-group')); ?>
						<div class="control-fields">
							<?php echo $this->Form->input('location_id', array('label' => 'Choose a city', 'div' => false, 'options' => $location_options, 'id' => 'city-chooser', 'class' => 'twelve', 'data-no-sb' => '', 'empty' => '(Select Location)', 'selected' => (!empty($user['User']) ? $user['User']['location_id'] : null))); ?>
						</div>

						<div class="btn-group">
							<?php echo $this->Html->link('Locate Me', array('controller' => 'users', 'action' => 'set_location'), array('class' => 'btn btn-red')) ?>
							<button type="submit" class="btn btn-blue six">Update Location</button>
							
						</div>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</div>
	</div>
</header>