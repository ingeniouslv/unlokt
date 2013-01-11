<?php
$this->set('title_for_layout', 'Account Settings');
?>
<div class="main-content page-new user">
	<div class="container">
		<div class="page-header">
			<h1 class="name">My Profile</h1>
		</div>
		<div class="row">
			<div class="one columns">
				<img src="<?php echo $this->Html->gen_path('user', $user['User']['id'], 80); ?>" class="profile-image" title="<?php echo h($user['User']['name']); ?>">
			</div>

			<div class="eleven columns user-details">
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
		<span id="reviews"></span>
		
	</div>	
</div>
<div class="container">
	<div class="row">
		<div class="seven columns">
			<?php echo $this->element('mod-filtered_items', array('class' => 'fixed block-slider-container')); ?>
		</div>
		<div class="five columns">
			<div class="note-slider">
				<div class="block-slider-nav note-slider-nav">
					<a class="left" href="javascript:void(0);"></a>
					<a class="right" href="javascript:void(0);"></a>
				</div>
				<?php echo $this->element('mod-reviews'); ?>
			</div>
		</div>		
	</div>
</div>		
<script src="/js/nf-slider-call.js"></script>
<script>
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

	//add a hover effect to the tile image
		$('.tile').hover(
			function() {
				$(this).children('.tile-footer').children('.block-actions').slideDown(200);
			},
			function() {
				$(this).children('.tile-footer').children('.block-actions').slideUp(200);
			}
		);
		
		//initially hide the buttons
		$('.tile-footer .block-actions').hide();

</script>
<!-- <div class="container">
	<?php //echo $this->element('mod-filtered_items', array('class' => 'fixed')); ?>
</div> -->
