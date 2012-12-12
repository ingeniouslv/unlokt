<footer>
	<div class="navbar-footer">
		<div class="container">
			<p class="copyright">&copy; 2012 <?php echo SITE_NAME; ?> &mdash; All Rights Reserved Worldwide</p>
			<ul class="nav nav-horizontal">
				<li><a href="/pages/about" title="About">about</a>|</li>
				<li><a href="/pages/jobs" title="Jobs">jobs</a>|</li>
				<li><a href="/pages/press" title="Press">press</a>|</li>
				<li><a href="/pages/business" title="Business">business</a>|</li>
				<li><a href="/pages/affiliate" title="Affiliate">affiliate</a>|</li>
				<li><a href="/pages/help" title="Help">help</a>|</li>
				<li><a href="/pages/terms-of-service" title="Terms of Service">terms</a>|</li>
				<li><a href="/pages/privacy_policy" title="Privacy">privacy</a> |</li>
				<li><a href="/spots/recommend_a_spot" title="Recommend  Spot">recommend a spot</a></li>
			</ul>
		</div>
	</div>
</footer>

<script>
$(function() {
	//$('#body-container').css('padding-bottom', $('#footer').height());
	//$('#footer').css('margin-top', - $('#footer').height());

	$(window).ready(function() {
		$('#getLocation').click(initiate_geolocation);
	});

	function initiate_geolocation() {
		navigator.geolocation.getCurrentPosition(handle_geolocation_query);
	}

	function handle_geolocation_query(position) {
		alert('Lat: ' + position.coords.latitude + ' ' +
			  'Lon: ' + position.coords.longitude);
	}
});
</script>