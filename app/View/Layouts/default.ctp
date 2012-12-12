<?php echo $this->element('global-head'); ?>
<body>
	<div id="body-container">
		<?php echo $this->element('site-header'); ?>

		<?php if($this->Session->check('Message')): ?>
				<?php
					echo $this->Session->flash();
					echo $this->Session->flash('auth');
				?>
		<?php endif; ?>
		
		<?php echo $this->fetch('content'); ?>
	</div>


	<?php echo $this->element('site-footer'); ?>

	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
