<section class="block mod-deal_feed">
	<h1>Spot Special Feed</h1>

	<?php /*foreach ($feed as $spot): //debug($spot); ?>
		<article class="block block-white">
			<img class="pull-left thumb" src="<?php echo $this->Html->gen_path('spot', $spot['Spot']['id'], 40, 40); ?>" alt="Business Name" title="Business Name">
			<h2 class="lead"><?php echo $spot['Spot']['name']; ?> <small><?php echo ago($spot['Feed'][0]['created']); ?> ago</small></h2>
			<p><?php echo h($spot['Feed'][0]['feed']); ?></p>
		</article>
	<?php endforeach; */ ?>
	<article class="block block-white">
		<img class="pull-left thumb" src="<?php echo $this->Html->gen_path('user', 1, 40, 40); ?>" alt="Business Name" title="Business Name">
		<h2 class="lead">Business Name <small>25 minutes ago</small></h2>
		<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet</p>
	</article>

	<article class="block block-white">
		<img class="pull-left thumb" src="<?php echo $this->Html->gen_path('user', 1, 40, 40); ?>" alt="Business Name" title="Business Name">
		<h2 class="lead">Business Name <small>25 minutes ago</small></h2>
		<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet</p>
	</article>
	
	<article class="block block-white">
		<img class="pull-left thumb" src="<?php echo $this->Html->gen_path('user', 1, 40, 40); ?>" alt="Business Name" title="Business Name">
		<h2 class="lead">Business Name <small>25 minutes ago</small></h2>
		<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet</p>
	</article>
</section>