<?php echo $this->element('global-head'); ?>
<body>
	<div id="body-container">
		<div class="splash-wrap">

			<?php if($this->Session->check('Message')): ?>
					<?php
						echo $this->Session->flash();
						echo $this->Session->flash('auth');
					?>
			<?php endif; ?>
			
			<div class="splash">
				<?php echo $this->fetch('content'); ?>
			</div>
			<div class="bg-top"></div>
			<div class="bg-bottom"></div>
			<div class="bg-separator"></div>
		</div>	
	</div>

</body>
</html>