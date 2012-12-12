<?php

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AppHelper extends Helper {
	
	public $script_files = array();
	
	// This function will generate a URL for linking images.
	// Usage example: $this->Html->gen_path('user', $profile['User']['id'], 120, 75) generates /gen/user/1/120x75/default.jpg
	// Another exampple: $this->Html->gen_path('node', $node_id, 100) generates /gen/node/23/100x100/default.jpg
	public function gen_path($type, $id, $width, $height = null, $file = 'default.jpg') {
		
		switch (true)
		{
			// ONE DIMENSION - SQUARE IMAGE
			case (is_numeric($width) && !$height):
				$height = $width;
				break;
			
			// ONE DIMENSION - SCALE SINCE 'auto' IS PRESENT as $height
			case (is_numeric($width) && !is_numeric($height) && $height == 'auto'):
				$store_path = store_path($type, $id, $file);
				if (!is_file($store_path)) {
					$height = $width;
					break;
				}
				$image_dimensions = $this->getImageDimensions($store_path);
				$height = round($image_dimensions['height'] / ($image_dimensions['width'] / $width));
				break;
			
			// PERCENTAGE DETECTED - SCALE THE PICTURE TO PERCENTAGE
			case (!is_numeric($width) && !$height && strpos($width, '%') !== FALSE):
				$store_path = store_path($type, $id, $file);
				if (!is_file($store_path)) {
					$height = 100;
					$width = 100;
					break;
				}
				$image_dimensions = $this->getImageDimensions($store_path);
				$percentage = preg_replace('/[^0-9]/', '', $width)/100;
				$width = round($image_dimensions['width'] * $percentage);
				$height = round($image_dimensions['height'] * $percentage);
				break;
		}
		// $height = ($height == null ? $width : $height);
		return STATIC_DOMAIN."{$this->webroot}gen/$type/$id/{$width}x{$height}/$file";
	}

	private function getImageDimensions($store_path)
	{
		$image_dimensions = Cache::read("dimensions-$store_path");
		if (!$image_dimensions) {
			$dimensions = getimagesize($store_path);
			$image_dimensions = array('width' => $dimensions[0], 'height' => $dimensions[1]);
			Cache::write("dimensions-$store_path", $image_dimensions);
		}
		return $image_dimensions;
	}
	
	public function add_script($files) {
		if (is_array($files)) {
			foreach ($files as $file) {
				$this->script_files[] = $file;
			}
			return;
		}
		$this->script_files[] = $files; 
	}
	
	public function get_script() {
		return $this->script_files;
	}
}