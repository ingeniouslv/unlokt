<?php
App::uses('AppModel', 'Model');

class PasswordReset extends AppModel {
	
	public $belongsTo = array('User');
	
	public function clear_password_resets() {
		if (!isset($this->User->id) || !$this->User->id) {
			throw new NotFoundException('Expecting User ID');
		}
		// Find all the password resets for this user and delete them.
		$resets = $this->findAllByUserId($this->User->id);
		foreach ($resets as $reset) {
			$this->create(false); // reset model
			$this->id = $reset['PasswordReset']['id'];
			$this->delete();
		}
	}
	
	public function create_and_email_password_reset() {
		if (!isset($this->User->id) || !$this->User->id) {
			throw new NotFoundException('Expecting User ID');
		}
		// First, remove any existing password resets.
		// We don't want any old password resets to be misused by anyone.
		$this->clear_password_resets();
		// Grab the user's information.
		$user = $this->User->read(null, $this->User->id);
		// Generate hash for resetting password.
		$hash = md5(uniqid().$user['User']['id']).md5(time().$user['User']['email'].rand(0,999999999));
		// Save a new PasswordReset before sending the mail.
		$this->create(false);
		$this->save(array(
			'user_id' => $this->User->id,
			'hash' => $hash
		));
		$link = ABSOLUTE_URL."/users/reset_password/{$user['User']['id']}/$hash";
		$email = new CakeEmail('pcmail');
		$email->to($user['User']['email'])
			->subject('Password Reset')
			->template('users-password_reset')
			->viewVars(array('link' => $link, 'user' => $user))
			->send();
	} // end of create_and_email_password_reset()
}
