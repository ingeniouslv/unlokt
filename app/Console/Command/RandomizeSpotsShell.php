<?php

/* Created by Anthony Scott < anthony@peacefulcomputing.com >
 * 
 * This script runs automatically to cause a new random order every hour.
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
			//spots with conditions that would prevent the list from saving should be removed from the list. 
			if(empty($spots[$i]['Spot']['phone'])) {
				unset($spots[$i]);
			}
		}
		$this->Spot->SaveMany($spots);
		$this->Spot->clear_cache();
	} // end of main()
}