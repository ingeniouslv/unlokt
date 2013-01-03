<?php
$this->set('title_for_layout', $spotOption['SpotOption']['name']);
?>
<div class="main-content page spot-option">
	<div class="container">

		<div class="row">
			<div class="nine columns">
				<div class="page-header">
					<h1 class="name"><?php echo h($spotOption['SpotOption']['name']); ?></h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="eight columns">
				<h2>Name</h2>
				<?php echo h($spotOption['SpotOption']['name']); ?>
			</div>
			<div class="eight columns">
				<h2>CSS Class <span class="<?php echo h($spotOption['SpotOption']['css_class']); ?>" /></h2>
				<?php echo h($spotOption['SpotOption']['css_class']); ?>
			</div>
		</div>
		<!-- Here is where we should output the list of Spots under this spot option -->
	</div>
</div>
