<?php
   /*
   * AuthHelper
   * Created by Zach Jones <zach@peacefulcomputing.com>
   * 
   * Use: provides Views with $this->Auth->user($key) method.
   * If $this->user() is called without a key then the entire User array is returned.
   */
App::uses('AppHelper', 'View/Helper');

class AuthHelper extends AppHelper {
	public function user($key = null) {
		if ($key == null) {
			return CakeSession::read('Auth.User');
		}
		return CakeSession::read("Auth.User.$key");
	}
	
	//////////////////////////////////////////////////
	
	public function loggedIn() {
		return (bool) CakeSession::read('Auth.User.id');
	}
}