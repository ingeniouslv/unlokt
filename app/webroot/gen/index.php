<?php
putenv('PATH='.getenv('PATH').':/opt/local/bin:/opt/ImageMagick/bin');

// the convert command gets execute without a full path
// after installing imagick add your binary path like so (using macport dir):
//  nano /etc/bashrc
//  export PATH=$PATH:/opt/local/bin
// now restart apache

// Test URL: http://xpmedia.dev/gen/?type=article&id=1&image=large.jpg&width=100&height=100
// Test URL: http://xpmedia.dev/gen/?type=article&id=2&image=large.jpg&width=100&height=100
// Test URL: http://xpmedia.dev/gen/?type=article&id=3&image=large.jpg&width=100&height=100
// Image Sample: http://xpmedia.dev/gen/article/1/large.jpg
// Image Sample: http://xpmedia.dev/gen/article/2/large.jpg
// Image Sample: http://xpmedia.dev/gen/article/3/large.jpg

// ***************************************************************
// ** Config settings
// ***************************************************************
define('DS', DIRECTORY_SEPARATOR);
$root_path = dirname($_SERVER['SCRIPT_FILENAME']);
$storage_path = $root_path.DS.'../store/data';
$config = array(

		// _GET params
		'param' => array(
				// Type: node, article, etc
				'type'		=> isset($_GET['type'])		? $_GET['type']		: '',

				// User ID
				'id'		=> isset($_GET['id'])		? (int) $_GET['id']	: '',

				// Original image in the type folder
				'image'		=> isset($_GET['image'])	? $_GET['image']	: '',

				// Width of the thumbnail to be generated
				'width'		=> isset($_GET['width'])	? $_GET['width']	: '100',

				// Height of the thumbnail to be generated
				'height'	=> isset($_GET['height'])	? $_GET['height']	: '100',
			),

		// Folder Paths
		'path' => array(
				// Only add entries to here if the path is not configured as the 'default' path below.
				'default' => $storage_path.DS.(isset($_GET['type']) ? $_GET['type'] : 'default'),
				// 'user'		=> $storage_path.DS.'user',
				// 'node'		=> $storage_path.DS.'node',
				// 'ad'		=> $storage_path.DS.'ad',
				// 'playlist' 	=> $storage_path.DS.'playlist',
				// 'deal' 		=> $storage_path.DS.'deal',
				// 'spot' 		=> $storage_path.DS.'spot',
				
				// Cache Directory
				'cache'		=> $storage_path.DS.'cache',
			),

		// Thumbnail not available images
		'image' => array(
				'unavailable'	=> $root_path.DS.'not-available.jpg',
				'error'			=> $root_path.DS.'error.jpg',
			),

		'missing' => array(
				// By default - use the default missing image if no type of missing image is defined for the type.
				'default' => $root_path.DS.'node-missing.png',
				'user' => $root_path.DS.'user-missing.png',
				'node' => $root_path.DS.'node-missing.png',
				'playlist' => $root_path.DS.'node-missing.png',
				'spot' => $root_path.DS.'node-missing.png',
				'key' => $root_path.DS.'no-image_2.gif'
			),

		// Generate thumbnail Imagick convert command path
		'command' => array(
				'create_thumbnail' => 'convert %orig% -thumbnail "%width%x%height%^" -gravity center -crop %width%x%height%+0+0 -quality 95 %new%',
			),
	);



 


// ***************************************************************
// ** Create thumbnail
// ***************************************************************

// Should create all files and folders with 777, works on lion
// this did not work for me: mkdir($file, 0777)
umask(0);

// Create crc32 hash
$hash = sprintf("%u", crc32('type='.$config['param']['type']
				.'&id='.$config['param']['id']
				.'&image='.$config['param']['image']
				.'&width='.$config['param']['width']
				.'&height='.$config['param']['height']));
 

// Original image path
$index = str_pad(substr($config['param']['id'], -3), 3, '0', STR_PAD_LEFT); // This turns '1729' into '729'
//echo $index;


$image_original = $index.DS.$config['param']['id'].DS.$config['param']['image'];



switch ($config['param']['type'])
{
	// An example of an entry for custom placement of pictures for certain 'types'
	// case 'user':
		// $image_original = $config['path']['user'].DS.$image_original;
		// break;

	default:
		$image_original = $config['path']['default'].DS.$image_original;
		break;
}

 
 
// Check for existing original image.
// If it's not found - provide a source image as the "this image is missing"
if (!is_file($image_original))
{
 
	
	// Make a new hash for a missing image
	$hash = sprintf("%u", crc32('type='.$config['param']['type']
				.'&width='.$config['param']['width']
				.'&height='.$config['param']['height']
				.'&missing'));
	$type = $config['param']['type'];
	if (!isset($config['missing'][$type])) {
		$type = 'default';
	}
	$image_original = $config['missing'][$type];
}  
 
// Create cache folder
$cache_folder = $config['path']['cache'].DS.$config['param']['type'].DS.$index.DS.$config['param']['id'];

 
 

if ( ! file_exists($cache_folder))
{
 
	@mkdir($cache_folder, 0777, true);
}

// Cache file location
$cache_file = $cache_folder.DS.$hash;

// Generate thumbnail if cache file does not exist
if ( ! file_exists($cache_file))
{
	

	
	$cmd = $config['command']['create_thumbnail'];
	
	
	$replace = array(
			'%orig%'			=> escapeshellarg($image_original),
			'%new%'				=> escapeshellarg($cache_file),
			'%width%'			=> $config['param']['width'],
			'%height%'			=> $config['param']['height'],
		);
	$cmd = strtr($cmd, $replace);
 
	shell_exec($cmd);

	// Check for new cache file
	if (file_exists($cache_file))
	{
		@chmod($cache_file, 0777);
	}
	else
	{
		// Sad... it didn't work
		header('Content-Type: image/jpeg');
		readfile($config['image']['error']);
		exit;
	}
}

// Turn on caching headers so that the server is hit as little as possible.
$expires = 86400; // Number of seconds to keep images cached.
header('Content-Type: image/jpeg');
header('Pragma: public');
header("Cache-Control: maxage=$expires");
header('Expires: '.gmdate('D, d M Y H:i:s', time()+$expires).' GMT');
// Show thumbnail
readfile($cache_file);
exit;