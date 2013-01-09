<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=8, IE=10">
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?> &ndash; <?php echo SITE_NAME ?> &ndash; Your Key to the City
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->fetch('meta');
	?>
	<link href="http://fonts.googleapis.com/css?family=Asap:400,700|Open+Sans:400,600,600italic,700" rel="stylesheet" type="text/css">
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
			// 'libs/jHtmlArea-0.7.5.min',
			// 'libs/jHtmlArea.ColorPickerMenu-0.7.0.min',
			'backbone_templates',
			'libs/jquery-ui-1.9.1.custom.min',
			'libs/jquery.easing.1.3',
			'libs/consolelog',
			'libs/tiny_mce/jquery.tinymce'
			),
		$this->Html->get_script()
	);
	
	if (Configure::read('debug') == 2) {
		// Don't compress/cache css/js when we are in debug mode
		echo $this->Html->css($cssFiles);
		echo $this->Html->script($jsFiles);
	} else {
		echo $this->Html->css($cssFiles);
		$this->Combinator->add_libs('js', $jsFiles);
		echo $this->Combinator->scripts('js');
	}
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

	<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyC3FHBv781AL_-rjtjQmhEqbhzF-WBByZY&sensor=false"></script>
	<!--[if lte IE 9]>
	<link rel="stylesheet" type="text/css" href="/app/webroot/css/ie.css">
	<![endif]-->
</head>