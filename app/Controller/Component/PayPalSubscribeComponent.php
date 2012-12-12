<?php
/* Author: Zach Jones <zach@peacefulcomputing.com>
 * This component will initiate and create a subscription for Premium Members.
 */
class PayPalSubscribeComponent extends Component {
	
	public $response;
	
	public function SetExpressCheckout($amount, $return_url, $cancel_url, $description, $profile_reference) {
		
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
			'PROFILEREFERENCE' => $profile_reference,
			'L_BILLINGTYPE0' => 'RecurringPayments',
			'L_BILLINGAGREEMENTDESCRIPTION0' => $description,
			'L_PAYMENTREQUEST_0_DESC0' => $description,
		);
		$this->response = queryString2Array($this->connect($fields));
		
		if (isset($this->response['ACK']) && ($this->response['ACK'] == "Success" || $this->response['ACK'] == "SuccessWithWarning")) {
			return true;
		} else {
			return false;
		} 
		// return $this->response;
	}

	public function SetExpressCheckoutSinglePayment($amount, $return_url, $cancel_url, $description, $profile_reference) {
		
		$fields = array(
			// API Details
			'USER' => PAYPAL_API_USERNAME,
			'PWD' => PAYPAL_API_PASSWORD,
			'SIGNATURE' => PAYPAL_API_SIGNATURE,
			'VERSION' => PAYPAL_API_VERSION,
			
			// The details/properties of the transaction.
			'METHOD' => 'SetExpressCheckout',
			'PAYMENTREQUEST_0_AMT' => number_format($amount, 2),
			// 'PAYMENTREQUEST_0_ITEMAMT' => number_format($amount, 2),
			'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
			'RETURNURL' => $return_url,
			'CANCELURL' => $cancel_url,
			'REQCONFIRMSHIPPING' => 0, // No shipping address needed; Paypal requires this to be 0
			'NOSHIPPING' => 1, // No shipping address needed; Paypal requires this to be 1
			'ALLOWNOTE' => 0, // Don't allow the customer to write a personal note,
			'BRANDNAME' => SITE_NAME,
			'PROFILEREFERENCE' => $profile_reference,
			'L_BILLINGTYPE0' => 'MerchantInitiatedBillingSingleAgreement',
			'L_BILLINGAGREEMENTDESCRIPTION0' => $description,
			'L_PAYMENTREQUEST_0_DESC0' => $description,
			'L_PAYMENTREQUEST_0_AMT0' => number_format($amount, 2),
			'L_PAYMENTREQUEST_0_QTY0' => 1
		);
		$this->response = queryString2Array($this->connect($fields));
		
		if (isset($this->response['ACK']) && ($this->response['ACK'] == "Success" || $this->response['ACK'] == "SuccessWithWarning")) {
			return true;
		} else {
			return false;
		} 
		// return $this->response;
	}
	
	
	function subscribe($spot_id, $plan_id, $credit_card = array()) {
		
		Controller::loadModel('Spot');
		if (!$spot = $this->Spot->read(null, $spot_id)) {
			return false;
		}
		
		Controller::loadModel('Plan');
		if (!$plan = $this->Plan->read(null, $plan_id)) {
			return false;
		}
		
		$fields = array(
			// API Details
			'USER' => PAYPAL_API_USERNAME,
			'PWD' => PAYPAL_API_PASSWORD,
			'SIGNATURE' => PAYPAL_API_SIGNATURE,
			'VERSION' => PAYPAL_API_VERSION,
			
			// The details/properties of the transaction.
			'METHOD' => 'CreateRecurringPaymentsProfile',
			'PROFILESTARTDATE' => gmdate("Y-m-d\TH:i:s\Z"),
			'PROFILEREFERENCE' => "{$plan['Plan']['id']}x{$spot['Spot']['id']}",
			'DESC' => "{$plan['Plan']['name']} for \${$plan['Plan']['price']}",
			'BILLINGPERIOD' => 'Month',
			'BILLINGFREQUENCY' => $plan['Plan']['months'],
			'AMT' => $plan['Plan']['price'],
			'CURRENCYCODE' => 'USD'
		);
		
		// If there is Credit Card information provided then add those fields to the $fields array.
		if (count($credit_card)) {
			$fields = array_merge(array(
				// The credit card / payment details.
				'ACCT' => $credit_card['CreditCard']['credit_card_number'],
				'EXPDATE' => str_pad($credit_card['CreditCard']['expiration_month'], 2, '0', STR_PAD_LEFT).$credit_card['CreditCard']['expiration_year'],
				'CVV2' => $credit_card['CreditCard']['cvv'],
				'FIRSTNAME' => $credit_card['CreditCard']['first_name'],
				'LASTNAME' => $credit_card['CreditCard']['last_name'],
				'EMAIL' => $spot['Spot']['email'],
				'STREET' => $credit_card['CreditCard']['address'],
				'STREET2' => $credit_card['CreditCard']['address2'],
				'CITY' => $credit_card['CreditCard']['city'],
				'STATE' => $credit_card['CreditCard']['state'],
				'COUNTRYCODE' => $credit_card['CreditCard']['country'],
				'ZIP' => $credit_card['CreditCard']['zip']
			), $fields);
		} elseif (isset($this->token)) {
			$fields['TOKEN'] = $this->token;
		}

		// Initialize the cURL request.
		$ch = curl_init(PAYPAL_API_SERVER.'?'.http_build_query($fields));
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		$response = curl_exec($ch);
		// Turn the PayPal response into an array.
		$response_array = queryString2Array($response);
		$this->response = $response_array;
		if (isset($response_array['ACK']) && ($response_array['ACK'] == 'Success' || $response_array['ACK'] == 'SuccessWithWarning')) {
			return true;
		} else {
			$this->log("ACK != Success. $response");
			return false;
		}
	} // end of function subscribe();
	
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
	
}