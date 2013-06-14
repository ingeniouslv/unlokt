<?php
$this->set('title_for_layout', 'Account Settings');
?>
<div class="main-content page-new user">
	<div class="container">
		<div class="page-header">
			<h1 class="name">My Profile</h1>
		</div>
		<div class="row">
			<div class="one columns"  >
				<img src="<?php echo $this->Html->gen_path('user', 
					$user['User']['id'], 80, null, $user['User']['image_name']); ?>" class="profile-image" title="<?php echo h($user['User']['name']); ?>">
			</div>

			<div class="two columns user-details">
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
			
			<div style='color:white;margin-left:30px;' class="four columns user-details"  >
			
			<h4>Notification Settings</h4>
			
				<div class='user-detail-option'  >
				<input  
				<?php  if ($user['User']['facebook_notifications']) echo ' CHECKED '; ?>
				class='enable-facebook-notifications user-detail-checkbox' type="checkbox"> <b class='user-detail-b'>Enable Facebook Posting</b> 
				<div class="checkbox-description">When you Endorse or Love a spot we will share it with your friends </div>
				</div>
			
			
			<br>
			
					<div class='user-detail-option'  >
				<input  
				<?php  if ($user['User']['email_notifications']) echo ' CHECKED '; ?>
				class='enable-email-notifications user-detail-checkbox' type="checkbox"> <b class='user-detail-b'>Enable Email Notifcations</b> 
				<div class="checkbox-description" >When you follow a spot you get notifcations letting you know about new specials and events </div>
				</div>
			 
			 <br><br>
			
		 
			
			
			</div>
			 
			<div style='color:white;margin-left:30px;' class="four columns user-details"  >
			<h4>Spots You Endorse</h4>
			
			<ul style='list-style:none;margin:0px;padding:0px;'>
			<?php 
				foreach ($endorsed_spots as $spot): ?>
				
				<li style=' padding:0px;margin:0px;'><a href='/spots/view/<?php echo $spot['Spot']['id']; ?>'><?php echo $spot['Spot']['name']; ?></a></li>
				
				<?php endforeach; ?>
				
			 </ul>
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



	$('.enable-facebook-notifications').click(function() {

		if ( $('.enable-facebook-notifications:checked').length ) {
 

			//shoot of an ajax request enabling email notifications

			$.get('/users/facebook_notifications/1', function(data) {
				  //$('.result').html(data);
				  console.log('facebook on performed.');
				});

			
			

		} else {


			//shoot of an ajax request disabling email notifications
			$.get('/users/facebook_notifications/0', function(data) {
				  //$('.result').html(data);
				  console.log('facebook off performed.');
				});

		}

	}
	);

	
	 

	$('.enable-email-notifications').click(function() {

		if ( $('.enable-email-notifications:checked').length ) {
 

			//shoot of an ajax request enabling email notifications

			$.get('/users/email_notifications/1', function(data) {
				  //$('.result').html(data);
				  console.log('Notice on performed.');
				});

			
			

		} else {


			//shoot of an ajax request disabling email notifications
			$.get('/users/email_notifications/0', function(data) {
				  //$('.result').html(data);
				  console.log('Notice off performed.');
				});

		}

	}
	);

	
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
