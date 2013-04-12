<footer>
	<div class="navbar-footer">
		<div class="container">
			<p class="copyright">&copy; 2012 <?php echo SITE_NAME; ?> &mdash; All Rights Reserved Worldwide</p>
			<ul class="nav nav-horizontal">
				<li><a href="/pages/about" title="About">about us</a>|</li>
				<li><a href="/pages/contact" title="Contact Us">contact us</a>|</li>
				<li><a href="/pages/privacy_policy" title="Privacy">privacy</a> |</li>
				<li><a href="/pages/terms-of-service" title="Terms of Service">terms</a>|</li>
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

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-39973415-1', 'unlokt.com');
  ga('send', 'pageview');

</script>