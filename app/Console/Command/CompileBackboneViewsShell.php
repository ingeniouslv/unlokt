<?php

/* Created by Zach Jones < zach@peacefulcomputing.com >
 * 
 * This script is intended to be ran [manually] when there are any updates to the view files for Backbone.
 * 
 */

class CompileBackboneViewsShell extends AppShell {
	
	public $uses = array();
	public $compile_loop_pause_time = 2; // Amount of time in seconds to wait to repeat the compilation.
	
    public function main()
    {
    	$this->out();
        $this->out("Loading {$this->name}");
		
		// Check if there's an argument being passed - if so, loop indefinitely.
		if (isset($this->args[0]) && $this->args[0]) {
			while (1) {
				$this->out('Running in while loop - compiling frequently.');
				$this->compile_views();
				sleep($this->compile_loop_pause_time);
			}
		} else {
			$this->out('Running once.');
			$this->compile_views();
		}
	} // end of main()
	
	public function compile_views() {
		$view_dir = APP.'View'.DS.'Backbone';
		$destination_file = JS.'backbone_templates.js';
		$view_array = array();
		
		if (!is_dir($view_dir)) {
			throw new Exception('Could not find Backbone View directory');
		}
		$files = scandir($view_dir);
		foreach ($files as $file) {
			// Make sure the file is a .ctp file (a view file)
			if (substr($file, -4, 4) != '.ctp') {
				continue;
			}
			$filename = substr($file, 0, -4);
			$string = file_get_contents($view_dir.DS.$file);
			$view_array[$filename] = $string;
		}
		$json_string = json_encode($view_array);
		$json_string = preg_replace('/<!--(.*?)-->/', '', $json_string);
		$json_string = str_replace('\t', '', $json_string);
		$json_string = str_replace('\n', '', $json_string);
		// Save the output to a temporary file and then move the file in place of the destination.
		// This provides atomic saving, but destroys potential symlinks.
		// Atomic saving means that the entire file will be saved, and THEN it will be MOVED over the OLD file, ensuring there's never a partially-written file being served by the webserver.
		$tmp = TMP.uniqid('', true);
		file_put_contents($tmp, "var templates=$json_string;");
		rename($tmp, $destination_file);
		$this->out('Created view file successfully.');
	}
}