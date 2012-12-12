<?php echo $this->element('global-head'); ?>
<body>
	<div id="body-container">
		<?php echo $this->element('site-header'); ?>
		<?php echo $this->element('admin_nav'); ?>
		<?php if($this->Session->check('Message')): ?>
			<div>
				<?php
					echo $this->Session->flash();
					echo $this->Session->flash('auth');
				?>
			</div>
		<?php endif; ?>
		
		<?php echo $this->fetch('content'); ?>
	</div>


	<?php echo $this->element('site-footer'); ?>

	<?php echo $this->element('sql_dump'); ?>
</body>
</html>