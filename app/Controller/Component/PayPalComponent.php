<?php
/* Author: Mojo The Pollo
 * This component will manage paypal subscriptions and stuff
 */
class PayPalComponent extends Component {
	
	/**
	* Get paypal subscription info 
	* @return Respose
	*/
	function get_subscription_info($user_id = null) {
		
		// We must search for the account.
		Controller::loadModel('User');
		$user = $this->User->read(null, $user_id);
		
		// At this point, we should definitely have a $user['User']
		if (!isset($user['User']['id']) || !$user['User']['id']) {
			return false;
		}

		$fields = array(
			// API Details
			'USER' => PAYPAL_API_USERNAME,
			'PWD' => PAYPAL_API_PASSWORD,
			'SIGNATURE' => PAYPAL_API_SIGNATURE,
			'VERSION' => PAYPAL_API_VERSION,
			
			// The details/properties of the transaction.
			'METHOD' => 'GetRecurringPaymentsProfileDetails',

			// Subscription ID
			'PROFILEID' => $user['User']['recurring_payment_id'],
		);
		
		$response = queryString2Array($this->connect($fields));
		// debug($response);
		return $response;
	}

	// Update the following
	// Subscriber name or address
	// Past due or outstanding amount
	// Whether to bill the outstanding amount with the next billing cycle
	// Maximum number of failed payments allowed
	// Profile description and reference
	// Number of additional billing cycles
	// Billing amount, tax amount, or shipping amount
	function update_subscription($user_id = null, $data = null) {

		// We must search for the account.
		Controller::loadModel('User');
		$user = $this->User->read(null, $user_id);
		
		// At this point, we should definitely have a $user['User']
		if (!isset($user['User']['id']) || !$user['User']['id'] || empty($data)) {
			return false;
		}

		$fields = array(
			// API Details
			'USER' => PAYPAL_API_USERNAME,
			'PWD' => PAYPAL_API_PASSWORD,
			'SIGNATURE' => PAYPAL_API_SIGNATURE,
			'VERSION' => PAYPAL_API_VERSION,
			
			// The details/properties of the transaction.
			'METHOD' => 'UpdateRecurringPaymentsProfile',

			// Subscription ID
			'PROFILEID' => $user['User']['recurring_payment_id'],
		);

		// Fields to be updated
		// 06/04/12 - Some fields cause this error in sandbox mode
		// Error (10764): This transaction cannot be processed at this time. Please try again later
		// Will do duplicate data checking in an effort to reduce this error
		$check_fields = array(
							'DESC',
							'AMT',
							'BILLINGFREQUENCY',
							'FIRSTNAME',
							'LASTNAME',
							'EMAIL',
							'STREET',
							'STREET2',
							'CITY',
							'STATE',
							'ZIP',
							'COUNTRYCODE',
						);

		foreach ($check_fields as $check_field)
		{
			if ( ! empty($data['User'][$check_field]) && $data['User'][$check_field] != $data['User'][$check_field.'_ORIG'])
			{
				$fields[$check_field] = $data['User'][$check_field];
			}
		}

		// debug($fields);

		$response = queryString2Array($this->connect($fields));
		// debug($response);
		return $response;
	}

	// Send params to paypal and return response
	function connect($fields = null)
	{
		// Initialize the cURL request.
		$ch = curl_init(PAYPAL_API_SERVER.'?'.http_build_query($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		
		return curl_exec($ch);
	}
	
	/*
	 * @param Array $purchase_data - contains all the data needed for a single credit card purchase.
	 * Expected: $purchase_data['CreditCard']['amount'] for the amount, as well as the rest of the fields as seen below.
	 */
	public function purchase($purchase_data = array()) {
		if (!isset($purchase_data['CreditCard']['amount'])) {
			throw new Exception('Error Processing Request - purchase amount not specified');
		}
		if (!isset($purchase_data['CreditCard']['credit_card_number'])) {
			throw new Exception('Error Processing Request - credit card number not specified');
		}
		
		// Determine the credit card type based upon the credit card number.
		$credit_card_type = null;
		switch (true)
		{
			case preg_match('/^4[0-9]{12}(?:[0-9]{3})?$/', $purchase_data['CreditCard']['credit_card_number']):
				$credit_card_type = 'Visa';
				break;
			case preg_match('/^5[1-5][0-9]{14}$/', $purchase_data['CreditCard']['credit_card_number']):
				$credit_card_type = 'Mastercard';
				break;
			case preg_match('/^3[47][0-9]{13}$/', $purchase_data['CreditCard']['credit_card_number']):
				$credit_card_type = 'AMEX';
				break;
			case preg_match('/^6(?:011|5[0-9]{2})[0-9]{12}$/', $purchase_data['CreditCard']['credit_card_number']):
				$credit_card_type = 'Discover';
				break;
			default:
				throw new Exception('Error Processing Request - unable to detect credit card number type');
				break;
		}
		
		$fields = array(
			// API Details
			'USER' => PAYPAL_API_USERNAME,
			'PWD' => PAYPAL_API_PASSWORD,
			'SIGNATURE' => PAYPAL_API_SIGNATURE,
			'VERSION' => PAYPAL_API_VERSION,
			
			// The details/properties of the transaction.
			'METHOD' => 'DoDirectPayment',
			'AMT' => $purchase_data['CreditCard']['amount'],
			'CURRENCYCODE' => 'USD',
			
			// The credit card / payment details.
			'ACCT' => $purchase_data['CreditCard']['credit_card_number'],
			'CREDITCARDTYPE' => $credit_card_type,
			'EXPDATE' => str_pad($purchase_data['CreditCard']['expiration_month'], 2, "0", STR_PAD_LEFT).$purchase_data['CreditCard']['expiration_year'],
			'CVV2' => $purchase_data['CreditCard']['cvv'],
			'FIRSTNAME' => $purchase_data['CreditCard']['first_name'],
			'LASTNAME' => $purchase_data['CreditCard']['last_name'],
			'STREET' => $purchase_data['CreditCard']['address'],
			'STREET2' => $purchase_data['CreditCard']['address2'],
			'CITY' => $purchase_data['CreditCard']['city'],
			'STATE' => $purchase_data['CreditCard']['state'],
			'COUNTRYCODE' => $purchase_data['CreditCard']['country'],
			'ZIP' => $purchase_data['CreditCard']['zip']
		);
		$response = queryString2Array($this->connect($fields));
		
		if (isset($response['ACK']) && ($response['ACK'] == "Success" || $response['ACK'] == "SuccessWithWarning")) {
			return true;
		} else {
			$this->log("ACK != Success.".print_r($response, true));
			return false;
		}
	} // end of purchase();
	
	public function cancel_subscription($user_id = null, $note = null) {
		if (!$user_id || !is_numeric($user_id)) {
			throw new Exception('UserID required for canceling membership');
		}

		// We must search for the account.
		Controller::loadModel('User');
		$user = $this->User->read(null, $user_id);
		if (!$user) {
			throw new Exception('User not found');
		}

		$fields = array(
			// API Details
			'USER' => PAYPAL_API_USERNAME,
			'PWD' => PAYPAL_API_PASSWORD,
			'SIGNATURE' => PAYPAL_API_SIGNATURE,
			'VERSION' => PAYPAL_API_VERSION,
			
			// The details/properties of the transaction.
			'METHOD' => 'ManageRecurringPaymentsProfileStatus',
			'ACTION' => 'Cancel',
			'PROFILEID' => $user['User']['recurring_payment_id'],
			'NOTE' => $note
		);
		$response = queryString2Array($this->connect($fields));
		
		if (isset($response['ACK']) && ($response['ACK'] == "Success" || $response['ACK'] == "SuccessWithWarning")) {
			return true;
		} else {
			$this->log("ACK != Success.".print_r($response, true));
			return false;
		}
	} // end of cancel_subscription();
	
	public function GetExpressCheckoutDetails($token) {
		
		$fields = array(
			// API Details
			'USER' => PAYPAL_API_USERNAME,
			'PWD' => PAYPAL_API_PASSWORD,
			'SIGNATURE' => PAYPAL_API_SIGNATURE,
			'VERSION' => PAYPAL_API_VERSION,
			
			// The details/properties of the transaction.
			'METHOD' => 'GetExpressCheckoutDetails',
			'TOKEN' => $token
		);
		$this->response = queryString2Array($this->connect($fields));
		return $this->response;
	}
	
	public function DoExpressCheckoutPayment($token, $payer_id, $amount) {
		$fields = array(
			// API Details
			'USER' => PAYPAL_API_USERNAME,
			'PWD' => PAYPAL_API_PASSWORD,
			'SIGNATURE' => PAYPAL_API_SIGNATURE,
			'VERSION' => PAYPAL_API_VERSION,
			
			// The details/properties of the transaction.
			'METHOD' => 'DoExpressCheckoutPayment',
			'TOKEN' => $token,
			'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
			'PAYERID' => $payer_id,
			'PAYMENTREQUEST_0_AMT' => number_format($amount, 2)
		);
		$this->response = queryString2Array($this->connect($fields));
		return $this->response;
	}
	
	/*
	public function SetExpressCheckout($amount, $return_url, $cancel_url) {
		
		$fields = array(
			// API Details
			'USER' => PAYPAL_API_USERNAME,
			'PWD' => PAYPAL_API_PASSWORD,
			'SIGNATURE' => PAYPAL_API_SIGNATURE,
			'VERSION' => PAYPAL_API_VERSION,
			
			// The details/properties of the transaction.
			'METHOD' => 'SetExpressCheckout',
			'PAYMENTREQUEST_0_AMT' => $amount,
			'RETURNURL' => $return_url,
			'CANCELURL' => $cancel_url,
			'REQCONFIRMSHIPPING' => 0, // No shipping address needed; Paypal requires this to be 0
			'NOSHIPPING' => 1, // No shipping address needed; Paypal requires this to be 1
			'ALLOWNOTE' => 0, // Don't allow the customer to write a personal note,
			'BRANDNAME' => SITE_NAME,
			'L_BILLINGTYPE0' => 'MerchantInitiatedBillingSingleAgreement'
		);
		$response = queryString2Array($this->connect($fields));
		
		return $response;
	}
	
	public function GetExpressCheckoutDetails($token) {
		
		$fields = array(
			// API Details
			'USER' => PAYPAL_API_USERNAME,
			'PWD' => PAYPAL_API_PASSWORD,
			'SIGNATURE' => PAYPAL_API_SIGNATURE,
			'VERSION' => PAYPAL_API_VERSION,
			
			// The details/properties of the transaction.
			'METHOD' => 'GetExpressCheckoutDetails',
			'TOKEN' => $token
		);
		$response = queryString2Array($this->connect($fields));
		
		return $response;
	}
	
	public function DoExpressCheckoutPayment() {
		
		$fields = array(
			// API Details
			'USER' => PAYPAL_API_USERNAME,
			'PWD' => PAYPAL_API_PASSWORD,
			'SIGNATURE' => PAYPAL_API_SIGNATURE,
			'VERSION' => PAYPAL_API_VERSION,
			
			// The details/properties of the transaction.
			'METHOD' => 'GetExpressCheckoutDetails',
			'TOKEN' => $token
		);
		$response = queryString2Array($this->connect($fields));
		
		return $response;
	}
	 * 
	 */

}