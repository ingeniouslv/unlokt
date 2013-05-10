<?php

define('SITE_NAME', 'Unlokt');

if (IDENTIFIER == 'production') {
	// Constants for production environment
	define('CONFIG_DEBUG_LEVEL', 0);
	define('STATIC_DOMAIN', '');
	
	// PayPal configuration
	define('PAYPAL_API_SERVER','https://api-3t.paypal.com/nvp');
	define('PAYPAL_API_USERNAME','');
	define('PAYPAL_API_PASSWORD','');
	define('PAYPAL_API_SIGNATURE','');
	define('PAYPAL_API_VERSION','88.0');
	define('PAYPAL_SEC_URL', 'https://www.paypal.com/cgi‑bin/webscr?cmd=_express-checkout&token=');
} else {
	// Constants for development environment
	define('CONFIG_DEBUG_LEVEL', 2 );
	define('STATIC_DOMAIN', '');
	
	// PayPal configuration
	define('PAYPAL_API_SERVER','https://api-3t.sandbox.paypal.com/nvp');
	define('PAYPAL_API_USERNAME','unlokt_1352851167_biz_api1.peacefulcomputing.com');
	define('PAYPAL_API_PASSWORD','1352851217');
	define('PAYPAL_API_SIGNATURE','AT3CNwywQYw.Yr-fW9UiD82gZ2qNAdEUAz6PiGFMLB.T5E8NnHvXTREh');
	define('PAYPAL_API_VERSION','88.0');
	define('PAYPAL_SEC_URL', 'https://www.sandbox.paypal.com/cgi‑bin/webscr?cmd=_express-checkout&token=');
}

if(array_key_exists('HTTP_HOST', $_SERVER))
	define('ABSOLUTE_URL', "http://{$_SERVER['HTTP_HOST']}");

define('DATA_STORE', WWW_ROOT.'store/data/');

// Email
define('SITE_EMAIL_FROM_NAME', 'Unlokt');
define('SITE_EMAIL_FROM_ADDR', 'noreply@unlokt.com');
define('SITE_EMAIL_SMTP_HOST', 'smtp.postmarkapp.com');
define('SITE_EMAIL_SMTP_PORT', 25);
define('SITE_EMAIL_SMTP_USER', '7339951f-ec28-4b81-87f0-ce3ddca29ea3'); // Make this the postmarkapp API key
define('SITE_EMAIL_SMTP_PASS', '7339951f-ec28-4b81-87f0-ce3ddca29ea3'); // Make this the postmarkapp API key
define('SITE_EMAIL_SEND_IMMEDIATELY', false); // If this is true, the email will be saved to the database [as sent] - the email will be sent immediately.
define('POSTMARK_APP_API', '7339951f-ec28-4b81-87f0-ce3ddca29ea3');

define('STANDARD_DATE', 'n/j/y');
define('STANDARD_TIME', 'g:i A');
define('STANDARD_DATE_TIME', 'n/j/y g:i A');
// This is only use for cosmetic purposes, such as
// showing a Comment's time in format: STANDARD_DATE_TIME STANDARD_TIMEZONE
define('STANDARD_TIMEZONE', 'PST');

/* ConstantContact CONFIGURATION */
define('CONSTANT_CONTACT_USERNAME', '');
define('CONSTANT_CONTACT_PASSWORD', '');
define('CONSTANT_CONTACT_API_KEY', '');
define('CONSTANT_CONTACT_CONSUMER_SECRET', '');

define('GOOGLE_MAPS_API_KEY', 'AIzaSyBMCFtH3q3r-pW_nMAXln8-SsyYC-hRFxQ');