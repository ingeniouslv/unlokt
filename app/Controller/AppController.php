<?php

App::uses('Controller', 'Controller');
App::uses('CakeEmail', 'Network/Email');

class AppController extends Controller {
	
	public $components = array('Session', 'Auth', 'RequestHandler', 'Api');
	public $helpers = array('Html', 'Session', 'Form', 'Auth', 'Combinator.Combinator', 'Number');
	// Load only required models on each load. Others can be loaded dynamically.
	public $uses = array('Feed', 'Location');

	// If require_ssl is set to true then beforeRender() will forward the user to SSL.
	public $require_ssl = false;
	
	//////////////////////////////////////////////////
	
	public function beforeFilter() {
		/* Git does not put the ./tmp directories */
		if (!is_dir(APP.'tmp')) {
			@mkdir(APP.'tmp/cache/persistent', 0777, true);
			@mkdir(APP.'tmp/cache/models', 0777, true);
			@mkdir(APP.'tmp/logs', 0777, true);
			@mkdir(APP.'tmp/sessions', 0777, true);
			@mkdir(APP.'tmp/tests', 0777, true);
		}
		
		// if($this->request->params['action'] == 'register' && $this->request->params['controller'] == 'users') {
			// $this->redirect('/');
		// }
		
		//Configure AuthComponent. I have no idea what this is doing ... :)
		$this->Auth->authorize = array(
			'Controller',
			'Actions' => array('actionPath' => 'controllers')
		);
		
		// BcryptForm is the Authentication plugin for AuthComponent. It utilizes bcrypt hashing which is infinitely better than md5 hashing.
		// BcryptForm is not working with 'scope' => array('User.is_active' => 1) - so I have that condition set manually inside our auth component. 
		$this->Auth->authenticate = array('BcryptForm' => array('fields' => array('username' => 'email', 'password' => 'password'), 'scope' => array('User.is_active' => 1)));
		$this->Auth->loginAction = array('controller' => 'users', 'action' => 'login', 'plugin' => false, 'admin' => false);
		$this->Auth->logoutRedirect = array('controller' => 'users', 'action' => 'login', 'plugin' => false, 'admin' => false);
		$this->Auth->loginRedirect = '/pages/splash';
		if (!$this->Auth->user()) {
			$this->Auth->loginRedirect = array('controller' => 'pages', 'action' => 'splash');
		} else {
			$this->Auth->loginRedirect = '/';
		}
		
		// Check if logged in via API
		// If API Key is passed and valid, Set session.
		if (!empty($_POST['api_key'])) {
			$this->loadModel('User');
			$this->User->cache = true;
			$cuser = $this->User->findByApiKey($_POST['api_key']);
			if (!isset($cuser)) {
				$this->Session->destroy();
				ApiComponent::error(ApiErrors::$INVALID_API_KEY);
			} else {
				$this->login_user($cuser['User']['id']);
				$this->Session->id($_POST['api_key']);
				$this->Session->write("cuser", $cuser);
			}
		}
		
		
		// Actions to perform if a User is logged in
		if ($user_id = $this->Auth->user('id')) {
			
			// Sometimes a user's account is upgraded or downgraded;
			// we must check if there's a flag to re-authorize a user
			if (Cache::read("reauthorize-user-$user_id")) {
				Cache::delete("reauthorize-user-$user_id");
				$this->login_user($user_id);
			}
			// Load any Spots which the current user might belong.
			$spots_i_manage = $this->Feed->Spot->Manager->getSpotListByManager();
			// Load any Spots which the current user is following
			$spots_i_follow = $this->Feed->Spot->SpotFollower->getSpotListByUser();
			$spot_ids_i_follow = array_keys($spots_i_follow);
			// end of actions for logged-in users
			$this->loadModel('User');
			$user = $this->User->getUser($this->Auth->user('id'), array('Location'));
		}  else {
			$spot_ids_i_follow = array();
		}
		// Permit access to remote origins, and add support for extra HTTP methods and declaration of content-type.
		// Without this, some javascript and security settings will deny connections.
		header('Access-Control-Allow-Origin: *');
		header('Access-Control-Allow-Methods: POST,GET,DELETE,PUT,OPTIONS');
		header('Access-Control-Allow-Headers: Content-Type');
		
		// Remove Autorender for API responses.
		if (isset($this->params['api'])) {
			$this->autoRender = false;
		}
		
		// If we're on an admin prefix then show the Admin layout.
		if (isset($this->request->prefix) && $this->request->prefix == 'admin') {
			if($this->Auth->user('is_super_admin')) {
				$this->layout = 'admin';
			} else if ($this->Auth->login()) {
				//redirect because the user isn't a super admin
				$this->Session->setFlash('You are not authorized to access this page 1.',  'alert-error');
				$this->redirect('/');
			}
			//if they aren't logged in, do regular redirect stuff.
		}
		
		$location_options = $this->Location->find('list', array('conditions' => array('Location.is_active' => true)));
		
		$this->set(compact('spots_i_manage', 'spots_i_follow', 'spot_ids_i_follow', 'location_options', 'user'));
		parent::beforeFilter();
	} // end of beforeFilter();
	
	//////////////////////////////////////////////////
	
	public function beforeRender() {
		// Check if SSL is required. Set $this->require_ssl on any Controller object.
		// This check must happen in beforeRender() since $this->require_ssl won't be set in beforeFilter() if set in a controller+action
		if (isset($this->require_ssl) && $this->require_ssl && (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on') && IDENTIFIER == 'production') {
			header('HTTP/1.1 301 Moved Permanently');
   			$this->redirect("https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}");
		}
		parent::beforeRender();
	} // end of beforeRender();
	
	//////////////////////////////////////////////////
	
	// Used for creating bcrypt password hashes. Use this globally for creating hashes.
	// The bcrypt methods inside BcryptFormAuthenticate are JUST FOR LOGGING IN.
	public function bcrypt_hash($password, $rounds = 12)
	{
		require_once(APP.'Lib/Misc/PasswordHash.php');
		// Check if the PasswordHash class is already loaded
		if (!isset($this->PasswordHash))
		{
			$this->PasswordHash = new PasswordHash($rounds, FALSE);
		} 
		return $this->PasswordHash->HashPassword($password);
	} // end of bcrypt_hash();
	
	//////////////////////////////////////////////////
	
	/* isAuthorized() is a native Cake function for Auth/ACL.
	 * If "isAuthorized();" returns false - then it checks ACL.
	 * If "isAuthorized();" returns true - then it assumes no ACL check needs to happen.
	 * With that being said ... isAuthorized() should always return false in production environment. 
	 */
	public function isAuthorized() {
		// return false;
		return true;
		return $this->Auth->loggedIn();
		// return false;
	} // end of isAuthorized();
	
	//////////////////////////////////////////////////
	
	// Manually login a user by `id`
	// Use this function with caution because there's no sanity checks or verification.
	public function login_user($user_id) {
		$this->loadModel('User');
		$this->User->cache = false;
		if ($user = $this->User->read(array('id', 'name', 'email', 'first_name', 'last_name', 'is_super_admin'), $user_id)) {
			$this->Auth->login($user['User']);
			return true;
		} else {
			$this->Auth->logout();
			return false;
		}
	} // end of login_user();
	
	//////////////////////////////////////////////////

	// Call this method to require a user to reauthorize on the next page load.
	// The reauthorize check can be found in AppController::beforeRender();
	// This function is useful for when a user's data/group/something has been changed and needs to be re-authorized via AuthComponent
	public function force_reauthorization($user_id) {
		// Add a key to cache which will trigger the user to be re-authorized manually.
		Cache::write("reauthorize-user-$user_id", true);	
	} // end of force_authorization();
	
	//////////////////////////////////////////////////
	
	// Paypal's Instant Payment Notifications trigger this method every time they hit the server.
	function afterPaypalNotification($txnId) {
		/* Here we receive PayPal's response after IPN.
		 * Let's check if it's successful - if so, take appropriate actions.
		 */
		// Find the Paypal transaction.
		$transaction = ClassRegistry::init('PaypalIpn.InstantPaymentNotification')->findById($txnId);
		$this->log($transaction['InstantPaymentNotification']['id'], 'paypal');
		
		// Load our Spot model.
		$this->Spot = ClassRegistry::init('Spot');
		
		// Perform conditions based upon the type of transaction from Paypal
		switch ($transaction['InstantPaymentNotification']['txn_type']) {
			// When a recurring payment is made.
			case 'recurring_payment':
				if ($transaction['InstantPaymentNotification']['payment_status'] == 'Completed') {
					// Transaction is good. Update the Spot properties and record the payment
					list($plan_id, $spot_id) = explode('x', $transaction['InstantPaymentNotification']['rp_invoice_id']);
					if (!$spot_id || !$plan_id) {
						$this->log('Spot ID or Plan ID not found in AppController::afterPaypalNotification().');
						return;
					}
					if (!$spot = $this->Spot->read(null, $spot_id) || !$plan = $this->Spot->Plan->read(null, $plan_id)) {
						$this->log('Spot or Plan not found in AppController::afterPaypalNotification().');
					}
					// Let's update some of the properties of Spot.
					$this->Spot->create(false);
					$this->Spot->id = $spot_id;
					$this->Spot->set(array(
						'plan_id' => $plan_id,
						'subscription_pending' => 0,
						'payment_due_date' => date(MYSQL_TIME, strtotime("+{$plan['Plan']['months']} months")),
						'is_premiem' => 1
					));
					$this->Spot->save();
					// Make a new Payment and save it to the database.
					$this->Spot->Payment->create(false);
					$this->Spot->Payment->set(array(
						'spot_id' => $spot_id,
						'subscription_type' => $plan['Plan']['name'],
						'amount_paid' => $transaction['InstantPaymentNotification']['mc_gross'],
						'paid_date' => date(MYSQL_TIME, strtotime($transaction['InstantPaymentNotification']['payment_date'])),
						'pay_period_start' => date(MYSQL_TIME, strtotime($transaction['InstantPaymentNotification']['payment_date'])),
						'pay_period_end' => date(MYSQL_TIME, strtotime("{$transaction['InstantPaymentNotification']['payment_date']} -1 day")),
						'pay_method' => "Paypal TXNID {$transaction['InstantPaymentNotification']['txn_id']}"
					));
					$this->Spot->Payment->save();
				}
				break;
				
			case 'something_else':
			default:
				// Do nothing for now.
				break;
		}
		
	} // end of afterPaypalNotification();
}
