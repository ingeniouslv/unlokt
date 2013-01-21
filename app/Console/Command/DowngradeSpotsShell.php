<?php

/* Created by Zach Jones < zach@peacefulcomputing.com >
 * 
 * This script is intended to be ran [manually] when there are any updates to the view files for Backbone.
 * 
 */

class DowngradeSpotsShell extends AppShell {
	
	public $uses = array('Spot');
	
    public function main()
    {
    	$week_past_due_date = date('Y-m-d', strtotime('-1 week'));
    	//$spot_ids = $this->Spot->find('list', array('fields' => array('id'), 'conditions' => array('payment_due_date <=' => $week_past_due_date)));

		//print_r($spot_ids);
		$this->Spot->updateAll(array('Spot.is_premium' => false), array('Spot.payment_due_date <=' => $week_past_due_date));
	} // end of main()
}