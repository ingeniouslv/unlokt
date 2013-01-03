<?php echo $this->element('global-head'); ?>
<body>
	<div id="body-container">
		<?php if($this->Session->check('Message')): ?>
				<?php
					echo $this->Session->flash();
					echo $this->Session->flash('auth');
				?>
		<?php endif; ?>
		<div class="splash-wrap">	
			<div class="splash">
				<?php if($this->Session->check('Message')): ?>
					<?php
						echo $this->Session->flash();
						echo $this->Session->flash('auth');
					?>
				<?php endif; ?>
				<?php echo $this->fetch('content'); ?>
			</div>
			<div class="bg-top"></div>
			<div class="bg-bottom"></div>
			<div class="bg-separator"></div>
		</div>	
	</div>

</body>
</html>