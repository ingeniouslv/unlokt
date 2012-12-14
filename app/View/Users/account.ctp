<?php
$this->set('title_for_layout', 'Account Settings');
?>
<div class="main-content page user">
	<div class="container">
		<h1 class="page-header">Account</h1>

		<div class="row">
			<div class="one columns">
				<img src="<?php echo $this->Html->gen_path('user', $user['User']['id'], 80); ?>" class="profile-image" title="<?php echo h($user['User']['name']); ?>">
			</div>

			<div class="eleven columns">
				<h2><?php echo h($user['User']['name']); ?></h2>
				<p><?php echo h($user['User']['email']); ?></p>
				<?php if ($user['User']['is_active']): ?>
					<p>Active User</p>
				<?php endif; ?>
				<?php if ($user['User']['is_super_admin']): ?>
					<p>Super Administrator</p>
				<?php endif; ?>
				<?php echo $this->Html->link('Edit Account', array('action' => 'account_edit'), array('class' => 'btn')); ?>
			</div>
	</div>
	<div class="row row-fix">
		<div class="twelve columns block-slider">
			<div class="block-slider-nav">
				<a class="left" href="javascript:void(0);"></a>
				<a class="right" href="javascript:void(0);"></a>
			</div>
			<?php echo $this->element('mod-filtered_items', array('class' => 'fixed block-slider-container')); ?>
		</div>
	</div>
	<span id="reviews"></span>
	<div class="row row-fix">
		<div class="twelve note-slider">
			<div class="block-slider-nav note-slider-nav">
				<a class="left" href="javascript:void(0);"></a>
				<a class="right" href="javascript:void(0);"></a>
			</div>
			<?php echo $this->element('mod-reviews'); ?>
		</div>	
	</div>
	<script src="/js/nf-slider-call.js"></script>
	<script>
		var notenetflixviewer = new NetflixViewer({
			click_left: '.left',
			click_right: '.right',
			container: '.block-slider',
			slider: '.block-slider-container',
			item_padding: 10,
			el: $('.block-slider').parent(),
			slider_speed: 15,
			slider_distance: 6
		});
	
		var notenetflixviewer = new NetflixViewer({
			click_left: '.left',
			click_right: '.right',
			container: '.note-slider',
			slider: '.note-slider-container',
			item_padding: 10,
			el: $('.note-slider').parent(),
			slider_speed: 15,
			slider_distance: 6
		});
	</script>
	<!-- <div class="container">
		<?php //echo $this->element('mod-filtered_items', array('class' => 'fixed')); ?>
	</div> -->
</div>