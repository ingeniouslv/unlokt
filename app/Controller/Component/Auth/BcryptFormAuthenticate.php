<?php
App::uses('FormAuthenticate', 'Controller/Component/Auth');
require_once(APP.'Lib/Misc/PasswordHash.php');

class BcryptFormAuthenticate extends FormAuthenticate {
	
	// Blank $uses in order to avoid a notice about models or something.
	public $uses = array();
	
	private $PasswordHash;

	public function __construct($collection, $settings) {
		
		// Accept the settings and merge them into the default settings.
		$this->settings = Set::merge($this->settings, $settings);
		
		// Start a new PasswordHash class.
		//		FIRST PARAMETER is 0 because this Authenticate method is for checking hashes only. (see: the way bcrypt works)
		//		FALSE for the second parameter in order to strengthen the hashing (FALSE makes the hash non-portable). Dunno? Same as above.
		//
		//		The method for creating hashes can be found in AppController.php, function bcrypt_hash($password, $rounds = 12);
		$this->PasswordHash = new PasswordHash(0, FALSE);
	}
	
	public function authenticate(CakeRequest $request, CakeResponse $response) {
		// retrieve the target model name; load appropriate model.
		$userModel = $this->settings['userModel'];
		$this->$userModel = ClassRegistry::init($userModel);

		// No corresponding POST data was found - BAD LOGIN
		if (!isset($request->data[$userModel])) {
			return false;
		}

		$field_username = $this->settings['fields']['username'];
		$field_password = $this->settings['fields']['password'];
	
		$username = $request->data[$userModel][$field_username];
		$password = $request->data[$userModel][$field_password];

		// Setup the array of conditions for finding the user.
		// Adds "User.email = 'test@example.com'" to default find conditions.
		// We don't want the password included as a condition since it's an indeterminable hash
		$conditions = array_merge(array(
			"$userModel.$field_username" => $username
			), $this->settings['scope']);
		
		// Search for user record. Don't include password because we need to match it using bcrypt hash matching.
		$user = $this->$userModel->find('first', array(
			'conditions' => $conditions
			));
			
		// No user was found - BAD LOGIN - return false
		if (!$user) {
			return false;
		}
		// See if the `password` from the database matches the requested login password.
		if ($this->PasswordHash->CheckPassword($password, $user[$userModel][$field_password])) {
			// Only return certain fields from the user object
			// Return a user object (per CakePHPs documentation)
			return array(
				'id' => $user['User']['id'],
				'name' => $user['User']['name'],
				'email' => $user['User']['email'],
				'first_name' => $user['User']['first_name'],
				'last_name' => $user['User']['last_name'],
				'is_super_admin' => $user['User']['is_super_admin']
			);
		} else {
			// Return false because the supplied password didn't match the password on file.
			return false;
		}

	}
}