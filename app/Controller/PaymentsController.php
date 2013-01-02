<?php
App::uses('AppController', 'Controller');
/**
 * Payments Controller
 *
 * @property Payment $Payment
 */
class PaymentsController extends AppController {

	public function beforeFilter() {
		$this->Auth->allow(array());
		parent::beforeFilter();
	}

/**
 * Shows the payment history for a given spot.
 */
	public function history($spot_id = null) {
		$this->Payment->Spot->id = $spot_id;
		if(!$this->Payment->Spot->exists()) {
			throw new NotFoundException("Invalid spot.");
		}
		$spot = $this->Payment->Spot->findById($spot_id);
		$this->paginate = array(
			'conditions' => array('Payment.spot_id' => $spot_id),
			'order' => array('Payment.id' => 'desc')
		);
		$payments = $this->paginate();
		
		$this->set(compact('spot', 'payments'));
	}
	
	public function method($spot_id = null) {
		//TODO: Method Stub for spots/payment
		$this->Payment->Spot->id = $spot_id;
		if(!$this->Payment->Spot->exists()) {
			throw new NotFoundException("Invalid spot.");
		}
		$spot = $this->Payment->Spot->GetSpot($spot_id, array('Plan'));
		$payments = $this->Payment->findBySpotId($spot_id);
		$this->set(compact('spot', 'payments'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Payment->id = $id;
		if (!$this->Payment->exists()) {
			throw new NotFoundException(__('Invalid payment'));
		}
		$this->set('payment', $this->Payment->read(null, $id));
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Payment->id = $id;
		if (!$this->Payment->exists()) {
			throw new NotFoundException(__('Invalid payment'));
		}
		if ($this->Payment->delete()) {
			$this->Session->setFlash(__('Payment deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Payment was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	public function add_payment_method($spotId, $plan_code = null) {
		$this->loadModel('Plan');
		if ($plan_code) {
			if (!$plans = $this->Plan->getPlanByCode($plan_code)) {
				$this->Session->setFlash('No plan found with that plan code. Try again.', 'alert-warning');
				$this->redirect(array('controller' => 'payments', 'action' => 'add_payment_method', $spotId));
			}
		} else {
			$plans = $this->Plan->getPublicPlans();
		}
		if (!isset($this->request->data['plan_id'])) {
			$this->request->data['plan_id'] = $plans[count($plans)-1]['Plan']['id'];
		}
		
		$this->loadModel('Spot');
		if (!$spot = $this->Spot->read(null, $spotId)) {
			throw new NotFoundException('Spot not found');
		}
		if (!$this->Spot->Manager->isAdmin() && !$this->Auth->user('is_super_admin')) {
			throw new NotFoundException('You do not have permission to do this.');
		}
		// Make sure there's not already a subscription pending:
		if ($spot['Spot']['subscription_pending']) {
			throw new NotFoundException('This Spot already has a subscription pending.');
		}
		if ($this->request->is('post')) {
			$this->loadModel('CreditCard');
			$this->CreditCard->set($this->request->data);
			if ($this->CreditCard->validates()) {
				$this->PayPalSubscribe = $this->Components->load('PayPalSubscribe');
				$result = $this->PayPalSubscribe->subscribe($spot['Spot']['id'], $this->request->data['plan_id'], $this->request->data);
				if ($result) {
					$this->Session->setFlash('Thank you. The subscription may take several hours to reflect on this Spot.', 'alert-success');
					$this->Spot->create(false);
					$this->Spot->id = $spotId;
					$this->Spot->set(array(
						'paypal_profileid' => $this->PayPalSubscribe->response['PROFILEID'],
						'subscription_pending' => 1
					));
					$this->Spot->save();
					$this->redirect(array('controller' => 'spots', 'action' => 'view', $spotId));
				} else {
					$this->Session->setFlash("Payment information returned bad response. Please check your information and try again. Messages from processor: {$this->PayPalSubscribe->response['L_LONGMESSAGE0']}.".(!empty($this->PayPalSubscribe->response['L_LONGMESSAGE1']) ? $this->PayPalSubscribe->response['L_LONGMESSAGE1'] : ''), 'alert-warning');
				} // end of PayPal success check
			} else {
				$this->Session->setFlash('Please check the form and try again.', 'alert-warning');
			}
		}

		$this->loadModel('CountryCode');
		$country_codes = $this->CountryCode->find('list');
		$this->set(compact('country_codes', 'plans', 'spot'));
	} // end of add_payment_method();

	public function add_payment_method_paypal($spot_id = null) {
		$this->loadModel('Plan');
		if (!isset($this->request->data['plan_id']) || !$plan = $this->Plan->read(null, $this->request->data['plan_id'])) {
			throw new NotFoundException('Expecting to have plan_id in POST');
		}
		$plan_id = $this->request->data['plan_id'];
		
		$this->loadModel('Spot');
		if (!$spot = $this->Spot->read(null, $spot_id)) {
			throw new NotFoundException('Spot not found');
		}
		if (!$this->Spot->Manager->isAdmin()) {
			throw new NotFoundException('You do not have permission to do this.');
		}
		$this->PayPalSubscribe = $this->Components->load('PayPalSubscribe');
		
		$return_url = ABSOLUTE_URL."{$this->webroot}payments/add_payment_method_paypal_success/$spot_id";
		$cancel_url = ABSOLUTE_URL."{$this->webroot}payments/add_payment_method/$spot_id";
		
		$profile_reference = "{$spot_id}x{$plan_id}";
		
		$sec = $this->PayPalSubscribe->SetExpressCheckout(0, $return_url, $cancel_url, "{$plan['Plan']['name']} for \${$plan['Plan']['price']}", $profile_reference);
		
		// If the SetExpressCheckout is good then save the TOKEN to the Session and forward to PayPal
		if ($sec) {
			$token = $this->PayPalSubscribe->response['TOKEN'];
			$this->Session->write('paypal_sec_token', $token);
			$this->Session->write('paypal_sec_plan_id', $plan_id);
			$this->redirect(PAYPAL_SEC_URL.$token);
		} else {
			throw new NotFoundException("Something went wrong. Here's the response from Paypal: {$this->PayPalSubscribe->response['L_LONGMESSAGE0']}");
		}
	} // end of add_payment_method_paypal();
	
	public function add_payment_method_paypal_success($spot_id = null) {
		$token = $this->Session->read('paypal_sec_token');
		$plan_id = $this->Session->read('paypal_sec_plan_id');
		
		$this->loadModel('Plan');
		$plan = $this->Plan->read(null, $plan_id);
		
		$this->PayPalSubscribe = $this->Components->load('PayPalSubscribe');
		// Set the token on the paypal object.
		$this->PayPalSubscribe->token = $token;
		$success = $this->PayPalSubscribe->subscribe($spot_id, $plan_id);
		if ($success) {
			$this->loadModel('Spot');
			$this->Spot->create(false);
			$this->Spot->id = $spot_id;
			$this->Spot->set(array(
				'paypal_profileid' => $this->PayPalSubscribe->response['PROFILEID'],
				'subscription_pending' => 1
			));
			$this->Spot->save();
			$this->Session->setFlash('Thank you. The subscription may take several hours to reflect on this Spot.', 'alert-success');
			$this->redirect(array('controller' => 'spots', 'action' => 'view', $spot_id));
		} else {
			throw new NotFoundException("Something went wrong. Here's the response from Paypal: {$this->PayPalSubscribe->response['L_LONGMESSAGE0']}");
		}
	} // end of add_payment_method_paypal_success();
}
