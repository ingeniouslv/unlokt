<?php
$this->set('title_for_layout', 'Spot Special Statistics');
?>
<div class="main-content page deal">
	<div class="container">
		<h1>Statistics for Spot Special &quot;<?php echo h($deal['Deal']['name']); ?>&quot;</h1>
		<?php foreach ($deal['Deal'] as $key => $val): ?>
			<?php echo h($key); ?>: <?php echo h($val); ?><br>
		<?php endforeach; ?>
	</div>
</div>