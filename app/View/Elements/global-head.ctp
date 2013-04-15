<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=8, IE=10">
	<meta name="google-site-verification" content="VSfnVUf-ocuHDWZczFq1OHVRnIW7jzsmHIQ2b_J0KQU" />
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?> &ndash; <?php echo SITE_NAME ?> &ndash; Your Key to the City
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');
	?>
	<link href="//fonts.googleapis.com/css?family=Asap:400,700|Open+Sans:400,600,600italic,700" rel="stylesheet" type="text/css">
	<script src="//bits.wikimedia.org/geoiplookup"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

	<?php
	// $cssFiles = array('default.dev.css');
	$cssFiles = array('app.css');
	$jsFiles = array_merge(
		array(
			'libs/json2',
			'libs/voxel-fileinput',
			'libs/xdate',
			'libs/bootstrap-timepicker',
			'libs/bootstrap-datepicker',
			'libs/underscore-min.js',
			'backbone-min.js',
			'unlokt.bb.global.js',
			'bootstrap-alert.js',
			'bootstrap-modal.js',
			'bootstrap-dropdown.js',
			'global.js',
			'com.unlokt.map.js',
			'bootstrap-tab',
			'libs/jquery.masonry',
			'backbone_templates',
			'libs/jquery-ui-1.9.1.custom.min',
			'libs/jquery.easing.1.3',
			'libs/consolelog',
			'libs/tiny_mce/jquery.tinymce'
		),
		$this->Html->get_script()
	);
	echo $this->Html->css($cssFiles);
	echo $this->Html->script($jsFiles);
	?>

	<script type="text/javascript">
		var unlokt = new com.unlokt({
			base_url: '<?php echo ABSOLUTE_URL; ?>',
			here: "<?php echo h($this->here); ?>",
			webroot: "<?php echo h($this->webroot); ?>"
		});
		// Set an 'auth' object depending on whether or not someone is logged in.
		var auth = <?php echo ($this->Auth->user() ? json_encode($this->Auth->user()) : 'null'); ?>;
	</script>

	<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAPS_API_KEY; ?>&sensor=false"></script>

	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-39973415-1', 'unlokt.com');
	  ga('send', 'pageview');

	</script>

	<!--[if lte IE 9]>
	<link rel="stylesheet" type="text/css" href="/app/webroot/css/ie.css">
	<![endif]-->
</head>