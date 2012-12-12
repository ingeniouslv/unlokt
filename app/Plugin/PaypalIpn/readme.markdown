Conversion to Cakephp 2.0

- Add the following to your bootstrap file:
 CakePlugin::load('PaypalIpn', array('bootstrap' => array('paypal_ipn_config'), 'routes' => true));

See https://github.com/webtechnick/CakePHP-Paypal-IPN-Plugin for documentation
