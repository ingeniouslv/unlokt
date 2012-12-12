<?php

class ConstantContactComponent extends Component {
	
	public $api = null;
	public $is_loaded = false;
	
	private function load() {
		if (!$this->is_loaded) {
			if (require_once(APP.'Lib/Misc/constant_contact.php')) {
				$this->api =  new constant_contact(CONSTANT_CONTACT_USERNAME,CONSTANT_CONTACT_PASSWORD,CONSTANT_CONTACT_API_KEY,false);
				$this->is_loaded = true;
			}
		}
	}
	
	// Function for adding contact to ConstantContact.
	public function add($email, $list_id, $first_name = null, $last_name = null) {
		$this->load();
		
		// First, we must see if the email is already a contact.
		$contact_id = $this->api->search_contact_by_email($email);
		if ($contact_id) {
			// We found the customer. Let's add them to our subscription and we're done.
			$this->api->add_subscription($contact_id, $list_id);
		} else {
			// We have to add a new customer to ConstantContact.
			// Let's add the ListID so that the customer will be added.
			$lists = array($list_id);
			// We are ready to send the contact to ConstantContact
			$customer_data = array('EmailAddress'=>$email, 'FirstName'=>$first_name,'LastName'=>$last_name, 'OptInSource'=>'ACTION_BY_CUSTOMER');
			$this->api->add_contact($customer_data, $lists);
		}		
	} // end of function add();
	
	// Function for removing contact from ConstantContact.
	public function remove($email, $list_id) {
		$this->load();
		
		$contact_id = $this->api->search_contact_by_email($email);
		if (!$contact_id) {
			$this->log("Customer's email not found in ConstantContact when attempting to remove.");
			return;
		}
		$this->api->remove_subscription($contact_id, $list_id);
	} // end of function remove();
	
}