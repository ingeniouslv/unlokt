<?php
/**
 * This is email configuration file.
 *
 * Use it to configure email transports of Cake.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 2.0.0
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * In this file you set up your send email details.
 *
 * @package       cake.config
 */
/**
 * Email configuration class.
 * You can specify multiple configurations for production, development and testing.
 *
 * transport => The name of a supported transport; valid options are as follows:
 *		Mail 		- Send using PHP mail function
 *		Smtp		- Send using SMTP
 *		Debug		- Do not send the email, just return the result
 *
 * You can add custom transports (or override existing transports) by adding the
 * appropriate file to app/Network/Email.  Transports should be named 'YourTransport.php',
 * where 'Your' is the name of the transport.
 *
 * from =>
 * The origin email. See CakeEmail::from() about the valid values
 *
 */
class EmailConfig {

	public $default = array(
		'transport' => 'Smtp',
		'from' => array(SITE_EMAIL_FROM_ADDR => SITE_EMAIL_FROM_NAME),
		'host' => SITE_EMAIL_SMTP_HOST,
		'port' => SITE_EMAIL_SMTP_PORT,
		'timeout' => 30,
		'username' => SITE_EMAIL_SMTP_USER,
		'password' => SITE_EMAIL_SMTP_PASS,
		'client' => null,
		'log' => false
		//'charset' => 'utf-8',
		//'headerCharset' => 'utf-8',
	);

	// This configuration is customized to save emails to database for sending.
	// This configuration should be used in all the Controllers.
	public $pcmail = array(
		'transport' => 'PCMail',
		'from' => array(SITE_EMAIL_FROM_ADDR => SITE_EMAIL_FROM_NAME),
		'emailFormat' => 'both'
	);

	public $postmark = array(
		'transport' => 'Postmark', 
		'from' => array(SITE_EMAIL_FROM_ADDR => SITE_EMAIL_FROM_NAME),
		'emailFormat' => 'both'
	);

}
