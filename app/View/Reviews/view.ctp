<?php
$this->set('title_for_layout', "Note '". h($review['Review']['name']). "'");
?>
<?php if ($this->Auth->user('is_super_admin') || $review['Review']['user_id'] == $this->Auth->user('id')): ?>
	<div class="navbar-admin">
		<div class="container">
			<div class="btn-group">
				<?php echo $this->Html->link(__('Delete'), array('action' => 'delete', $review['Review']['id'], 'admin' => false), array('class' => 'btn btn-red'), __('Are you sure you want to delete # %s?', $review['Review']['id'])); ?>
			</div>
		</div>
	</div>
<?php endif; ?>
<div class="main-content page spot review">
	<div class="container">

		<div class="row">
			<div class="nine columns">
				<div class="page-header">
					<h1 class="name"><?php echo h($review['Review']['name']); ?></h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="nine columns">
				<div class="row">
					<div class="two columns">
						<img class="twelve" src="<?php echo $this->Html->gen_path('spot', $review['Spot']['id'], 80); ?>" alt="">
					</div>
					<div class="two columns">
						<h2>Written By</h2>
						<?php echo h($review['User']['name'])?>
					</div>	
					<div class="two columns">
						<h2>Spot</h2>
					<?php echo $this->Html->link(__($review['Spot']['name']), array('controller' => 'spots', 'action' => 'view', $review['Spot']['id'])); ?>
					</div>
					<div class="three columns">
						<h2>Created</h2>
						<?php echo date(STANDARD_DATE_TIME, strtotime($review['Review']['created'])); ?>
					</div>
					<div class="ten columns">
						<h2>Note</h2>
					<?php echo h($review['Review']['review']); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>