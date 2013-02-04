<?php
$this->set('title_for_layout', h($location['Location']['name']));
?>

<div class="main-content page">
	<div class="container">
		<h1 class="page-header"><?php echo $location['Location']['name'] ?></h1>
		<h2> Latitude </h2>
		<?php echo $location['Location']['lat'];?>
		<h2> Longitude </h2>
		<?php echo $location['Location']['lng'];?>
		<h2> Active </h2>
		<?php echo ($location['Location']['is_active'])?'Yes':'No';?>
	</div>
</div>
