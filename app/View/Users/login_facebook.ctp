<?php
$this->set('title_for_layout', 'Login');
?>
<div id="fb-root"></div>
<script>
	// Additional JS functions here
	window.fbAsyncInit = function() {
		FB.init({
			appId      : '309486975818919', // App ID
			channelUrl : '//development.unlokt.com/channel', // Channel File
			status     : true, // check login status
			cookie     : true, // enable cookies to allow the server to access the session
			xfbml      : true  // parse XFBML
		});

		// Additional init code here
		FB.getLoginStatus(function(response) {
			if (response.status === 'connected') {
				// connected
				console.log("connected");
			} else if (response.status === 'not_authorized') {
				// not_authorized
				login();
				console.log("not_authorized");
			} else {
				// not_logged_in
				login();
				console.log("not logged into facebook");
			}
		});

 	};
  
	function login() {
		FB.login(function(response) {
			if (response.authResponse) {
				// connected
				console.log("connected");
				testAPI();
			} else {
				console.log("cancelled");
				// cancelled
			}
		}, {scope:email});
	}
	function testAPI() {
		console.log('Welcome!  Fetching your information.... ');
		FB.api('/me', function(response) {
			console.log('Good to see you, ' + response.name + '.');
		});
	}

	// Load the SDK Asynchronously
	(function(d){
		var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
		if (d.getElementById(id)) {return;}
		js = d.createElement('script'); js.id = id; js.async = true;
		js.src = "//connect.facebook.net/en_US/all.js";
		ref.parentNode.insertBefore(js, ref);
	}(document));
</script>