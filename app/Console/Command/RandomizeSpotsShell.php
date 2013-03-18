<?php

/* Created by Zach Jones < zach@peacefulcomputing.com >
 * 
 * This script is intended to be ran [manually] when there are any updates to the view files for Backbone.
 * 
 */

class RandomizeSpotsShell extends AppShell {
	
	public $uses = array('Spot');
	
    public function main()
    {
    	$spots = $this->Spot->find('all');
		shuffle($spots);
		$length = count($spots);
		for($i = 0; $i < $length; $i ++) {
			$spots[$i]['Spot']['random_delta'] = $i;
			if(empty($spots[$i]['Spot']['phone'])) {
				unset($spots[$i]);
			}
		}
		print_r($spots);
		$this->Spot->SaveMany($spots);
		$this->Spot->clear_cache();
	} // end of main()
}