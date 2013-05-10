<?php

date_default_timezone_set('America/Los_Angeles');


putenv('PATH='.getenv('PATH').':/opt/local/bin');

Cache::config('default', array('engine' => 'File'));

CakePlugin::load('PaypalIpn', array('bootstrap' => array('paypal_ipn_config'), 'routes' => true));
 
Configure::write('Dispatcher.filters', array(
	'AssetDispatcher',
	'CacheDispatcher'
));

/**
 * Configures default file logging options
 */
App::uses('CakeLog', 'Log');
CakeLog::config('debug', array(
	'engine' => 'FileLog',
	'types' => array('notice', 'info', 'debug'),
	'file' => 'debug',
));
CakeLog::config('error', array(
	'engine' => 'FileLog',
	'types' => array('warning', 'error', 'critical', 'alert', 'emergency'),
	'file' => 'error',
));

CakePlugin::load('Combinator');

function ago($time){
	if (!is_numeric($time)) {
		$time = date('U', strtotime($time));
	}
	$time = time() - $time;
	if($time >= 31556926){
		$val = floor($time/31556926);
		return "$val year".($val != 1 ? "s" : null);
	}
	if ($time >= 2629743) {
		$val = floor($time/2629743);
		return "$val month".($val != 1 ? "s" : null);
	}
	if ($time >= 604800) {
		$val = floor($time/604800);
		return "$val week".($val != 1 ? "s" : null);
	}
	if($time >= 86400){
		$val = floor($time/86400);
		return "$val day".($val != 1 ? "s" : null);
	}
	if($time >= 3600){
		$val = floor($time/3600);
		return "$val hour".($val != 1 ? "s" : null);
	}
	if($time >= 60){
		$val = floor($time/60);
		return "$val minute".($val != 1 ? "s" : null);
	}
	$val = floor($time);
	if ($val == 0) {
		$val = 1;
	}
	if ($val < 0) {
		$val = 0;
	}
	return "$val second".($val != 1 ? 's' : null);
}

// store_path($type, $id) will return the full path to the storage location of whatever content type.
// Usage example: store_path('user', 32) would return /var/www/app/webroot/store/data/user/032/32/
function store_path($type, $id, $file = null) {
	return DATA_STORE.$type.DS.str_pad(substr($id, -3), 3, '0', STR_PAD_LEFT).DS.$id.DS.$file;
}

function delete_cache($type, $id) {
	shell_exec('rm -rf '.escapeshellarg(DATA_STORE.'cache'.DS.$type.DS.str_pad(substr($id, -3), 3, '0', STR_PAD_LEFT).DS.$id));
}

// This function 'convert' will execute ImageMagick's `convert` command.
// This function should be used any time a user uploads a photo;
// This function helps keep everything consistent by having stripped JPGs as the source images for everything.
function convert($source, $destination) {
 	
	$destination_dir = pathinfo($destination, PATHINFO_DIRNAME);
 
	if (!is_dir($destination_dir)) {
		@mkdir($destination_dir, 0777, true);
	}
	
	$convert = 'convert '.escapeshellarg($source).' -profile '.escapeshellarg(WWW_ROOT.'files/sRGB_v4_ICC_preference.icc').' -quality 95 '.escapeshellarg($destination);
 
 
	return shell_exec($convert);
 
 }

function formatBytes($size, $precision = 2)
{
    $base = log($size) / log(1024);
    $suffixes = array('', 'k', 'M', 'G', 'T');   

    return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
}

define('MYSQL_TIME', 'Y-m-d H:i:s');

/*
 * queryString2Array accepts a string such as "name=John%20Smith&age=29"
 * and turns it into array('name'=>'John','age'=>'29').
 * This is basically the inverse of http_build_query();
 */
function queryString2Array($string) {
	$keyvals = explode('&', $string);
	$retval = array();
	foreach ($keyvals as $line) {
		list($key, $val) = @explode('=', $line);
		$retval[$key] = @urldecode($val);
	}
	return $retval;
}
