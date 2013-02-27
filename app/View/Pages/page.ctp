<?php $this->set('title_for_layout', $page['Page']['title']); ?>
<?php if ($this->Auth->user('is_super_admin')):?>
	<div class="navbar-admin">
		<div class="container">
			<div class="btn-group">
				<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $page['Page']['id'], 'admin' => true), array('class' => 'btn btn-dark')); ?>
			</div>
		</div>
	</div>
		
<?php endif; ?>
<div class="main-content page public">
	<div class="container">
		<h1 class="page-header"><?php echo $page['Page']['title'] ?></h1>
		<?php echo $page['Page']['body'];?>
	</div>
</div>