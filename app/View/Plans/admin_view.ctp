<?php
$this->set('title_for_layout', $plan['Plan']['name']);
?>
<div class="main-content page plan">
	<div class="container">

		<div class="row">
			<div class="nine columns">
				<div class="page-header">
					<h1 class="name"><?php echo h($plan['Plan']['name']); ?></h1>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="eight columns">
				<h2>Months</h2>
				<?php echo h($plan['Plan']['months']); ?>
			</div>
			<div class="eight columns">
				<h2>Price</h2>
				<?php echo h($plan['Plan']['price']); ?>
			</div>
		</div>
		<!-- Here is where we should output the list of Spots under this plan -->
	</div>
</div>