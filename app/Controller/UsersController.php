<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public function beforeFilter() {
		$this->Auth->allow(array(
			'api_login',
			'api_register',
			'api_facebook_login_check',
			'channel',
			'logout',
			'test2',
			'login',
			'login_facebook',
			'register',
			'reset',
			'reset_password'
		));
		parent::beforeFilter();
	}

/**
 * index method
 *
 * @return void
 */
	public function admin_index() {
		$this->User->recursive = 0;
		$this->paginate = array('order' => array('User.last_name' => 'asc', 'User.first_name' => 'asc'));
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			// Attempt to validate and save user.
			$this->User->create();
			$this->User->set($this->request->data);
			$this->User->set('password', $this->bcrypt_hash($this->request->data['User']['password']));

			if (!$this->request->data['User']['password'] || strcmp($this->request->data['User']['password'], $this->request->data['User']['password2']) !== 0) {
				$this->User->invalidate('password', 'Password required');
				$this->User->invalidate('password2', 'Password Confirmation required');
				$this->request->data['User']['password'] = '';
				$this->request->data['User']['password2'] = '';
			}
			if ($this->User->validates()) {
				// Good
				$this->User->save();
				$this->Session->setFlash('User has been added.', 'alert-success');
				$this->redirect(array('action' => 'index'));
			} else {
				// Clear passwords before sending user back to the browser.
				$this->request->data['User']['password'] = '';
				$this->request->data['User']['password2'] = '';
				$this->Session->setFlash('Please check the form and try again. Do not forget to re-enter your password.', 'alert-warning');
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			// Attempt to validate and save user.
			$this->User->create();
			$this->User->set($this->request->data);
			$this->User->set('password', $this->bcrypt_hash($this->request->data['User']['password']));
			
			// Check if there has been an update to password and it matches.
			if (isset($this->request->data['User']['password']) && !empty($this->request->data['User']['password'])) {
				
				if (strcmp($this->request->data['User']['password'], $this->request->data['User']['password2']) === 0) {
					$this->User->set('password', $this->bcrypt_hash($this->request->data['User']['password']));
					// Clear the passwords regardless.
					$this->request->data['User']['password'] = '';
					$this->request->data['User']['password2'] = '';
				} else {
					$this->request->data['User']['password'] = '';
					$this->request->data['User']['password2'] = '';
					$this->User->invalidate('password', 'Passwords did not match.');
					$this->User->invalidate('password2', 'Passwords did not match.');
				}
			} else {
				// No password was typed by the user.
				// Remove both passwords from POST data (so they don't get sent back to the view).
				// Unset the password field from the User model so it doesn't get saved as a blank password.
				$this->request->data['User']['password'] = '';
				$this->request->data['User']['password2'] = '';
				unset($this->User->data['User']['password']);
			}
			if ($this->User->validates()) {
				// Good
				$this->User->save();
				$this->redirect(array('action' => 'index'));
			} else {
				// Clear passwords before sending user back to the browser.
				$this->request->data['User']['password'] = '';
				$this->request->data['User']['password2'] = '';
				$this->Session->setFlash('Please check the form and try again. Do not forget to re-enter your password.', 'alert-warning');
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
			$this->request->data['User']['password'] = '';
			$this->request->data['User']['password2'] = '';
		}
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash('User deleted', 'alert-success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('User was not deleted', 'alert-warning');
		$this->redirect(array('action' => 'index'));
	}
	
	/**
	 * Allows administrators to login as a user without needing their password.
	 */
	public function admin_impersonate($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
		$this->login_user($this->User->id);
		$this->redirect('/');
	}
	
	
	public function email_notifications( $on_off = 0 ) {
		

		//set notifcation var
		
		if ($on_off) {
			
			$flash = "Notifcations have been turned on.";
			$on_off = 1;
			
		} else {
			
			
			$flash = "Notifcations have been turned off.";
			$on_off = 0;
			
		}
	 
		//save the notifcition field on user
	 
		$this->User->id = $this->Auth->user('id');
		$saved = $this->User->saveField('email_notifications',  $on_off);
		 
		
		
		if ($this->request->is('ajax')) {
			
			die($saved?'GOOD':'The email notifcations could not be disabled. Please, try again.');
			
			
		} else {
			
			$this->Session->setFlash($flash,'alert-success');
			$this->redirect('/users/account');
			
		}
		//return success ok
		
		
		 
		
	}
	
	

	public function facebook_notifications( $on_off = 0 ) {
		

		//set notifcation var
		
		if ($on_off) {
			
			$flash = "Facebook notifcations have been turned on.";
			$on_off = 1;
			
		} else {
			
			
			$flash = "Facebook notifcations have been turned off.";
			$on_off = 0;
			
		}
	 
		//save the notifcition field on user
	 
		$this->User->id = $this->Auth->user('id');
		$saved = $this->User->saveField('facebook_notifications',  $on_off);
		 
		
		
		if ($this->request->is('ajax')) {
			
			die($saved?'GOOD':'Facebook notifcations could not be disabled. Please, try again.');
			
			
		} else {
			
			$this->Session->setFlash($flash,'alert-success');
			$this->redirect('/users/account');
			
		}
		//return success ok
		
		
		 
		
	}
	
	
	
	public function login() {
		//set up session redirect to work on create user
		$redirect = $this->Session->read('referer');
		if(empty($redirect)) {
			$this->Session->write('referer', $this->Auth->redirect());
		}
		
		$this->layout = 'splash';
		//$this->require_ssl = false;
		if ($this->request->is('post')) {
			$user = $this->User->findByEmail($this->data['User']['email']);
			$is_facebook_only = ($user && !empty($user['User']['is_facebook_only']))?true:false;
			if($is_facebook_only) {
				$this->Session->setFlash('This account must use facebook to login', 'alert-warning');
			} else if ($this->Auth->login()) {
				$redirect = $this->Auth->redirect();
				//clear the referer url in the session because it isn't going to get used.
				$this->Session->delete('referer');
				if($redirect == '/') {
					$managers = $this->User->Manager->findAllByUserId($this->Auth->user('id'));
					
					if(count($managers) == 1) {
						//if the user is the manager of only one spot, bring them to that spot page after logging in.
						$this->redirect(array('controller' => 'spots', 'action' => 'view', $managers[0]['Manager']['spot_id']));
					} else if(count($managers) > 1) {
						//if the user manages more than one spot, bring them to the manage spots page after logging in
						$this->redirect(array('controller' => 'spots', 'action' => 'index'));
					} else {
						// Redirect the user. If there's $_GET['redirect'] then direct them there - else redirect to normal action.
						$this->redirect($this->Auth->redirect(isset($_GET['redirect']) ? $_GET['redirect'] : null));
					}
				} else {
					//take the user where they were trying to go in the first place
					$this->redirect($redirect);
				}
			} else {
				$this->request->data['User']['password'] = '';
				$this->Session->setFlash('Email and Password do not match.', 'alert-error');
			}
		}
	}
	
	public function logout() {
		
		$this->autoRender = false;
		$logout_url = $this->Auth->logout();
		$this->_logout_facebook();
		$this->redirect(isset($_GET['redirect']) ? $_GET['redirect'] : $logout_url);
	
	}
	
	public function reset() {
		if ($this->request->is('post')) {
			// Check if the specified email exists and is active.
			$user = $this->User->findByEmail($this->request->data['User']['email']);
			if ($user && $user['User']['is_active']) {
				// A user by the specified email is found. Let's send them an email.
				$this->Session->setFlash('A password reset email has been sent.', 'alert-success');
				$this->User->id = $user['User']['id'];
				$this->User->PasswordReset->create_and_email_password_reset();
				$this->redirect($this->webroot);
			// Check if the specified email exists but is inactive for any reason.
			} elseif (isset($user['User']['is_active']) && !$user['User']['is_active']) {
				throw new NotFoundException('The specified email was found, but the account is inactive.', 'alert-error');
			} else {
				$this->Session->setFlash('Email address &quot;'.h($this->request->data['User']['email']).'&quot; not found.', 'alert-error');
			}
			$this->request->data['User']['email'] = '';
		}
	} // end of reset()
	
	public function reset_password($user_id = null, $hash = null) {
		if (!$user_id || !$hash) {
			throw new NotFoundException('User ID and Hash required.');
		}
		if (!$reset = $this->User->PasswordReset->findByUserIdAndHash($user_id, $hash)) {
			throw new NotFoundException('Password reset request was not found. Has this reset request already been used?');
		}
		$user = $this->User->read(null, $user_id);
		
		if ($this->request->is('post')) {
			if (isset($this->request->data['User']['password']) && $this->request->data['User']['password'] && strcmp($this->request->data['User']['password'], $this->request->data['User']['password2']) === 0) {
				// Passwords were set and matched.
				// Let's generate a new password, save password, delete reset request, login user, take to home screen.
				$this->User->create(false); // Reset user model
				$this->User->id = $user['User']['id'];
				$this->User->set('password', $this->bcrypt_hash($this->request->data['User']['password']));
				$this->User->save();
				// Delete the old hash so that it can't be used for another password reset.
				$this->User->PasswordReset->create(false);
				$this->User->PasswordReset->id = $reset['PasswordReset']['id'];
				$this->User->PasswordReset->delete();
				// Login the user automatically.
				$this->login_user($user['User']['id']);
				// Redirect user to homepage with a message.
				$this->Session->setFlash('Your password has been reset and you have been automatically signed in.', 'alert-success');
				$this->redirect($this->webroot);
			} elseif (isset($this->request->data['User']['password']) && $this->request->data['User']['password'] && strcmp($this->request->data['User']['password'], $this->request->data['User']['password2']) !== 0) {
				$this->User->invalidate('password2', 'Passwords must match');
			} else {
				$this->User->invalidate('password', 'Password required');
				$this->User->invalidate('password2', 'Passwords must match');
			}
			$this->Session->setFlash('Your password was not reset. Please check the form and try again.', 'alert-warning');
			$this->request->data['User']['password'] = '';
			$this->request->data['User']['password2'] = '';
		}
		
		$this->set(compact('user'));
	} // end of reset_password()
	
	// Public user can register for Unlokt here.
	public function register() {
		
		
	
		
		App::uses('CakeEmail', 'Network/Email');
		$referer = $this->Session->read('referer');
		
		if ($this->request->is('post')) {
			// Attempt to validate and save user.
			$this->User->create();
			$this->User->set($this->request->data);
			$this->User->set('password', $this->bcrypt_hash($this->request->data['User']['password']));
			// Ensure the passwords match
			if (!$this->request->data['User']['password'] || strcmp($this->request->data['User']['password'], $this->request->data['User']['password2']) !== 0) {
				$this->User->invalidate('password', 'Password required');
				$this->User->invalidate('password2', 'Password Confirmation required');
			}
			// Ensure the emails match
			if (empty($this->request->data['User']['email']) || strcmp($this->request->data['User']['email'], $this->request->data['User']['email2']) !== 0) {
				$this->User->invalidate('email', 'Email must match');
				$this->User->invalidate('email2', 'Email must match');
			}
			
			//check if email exists
			$exists = $this->User->findByEmail($this->request->data['User']['email']);
		 
			if ($exists)
				$this->User->invalidate('email', 'Oops... Email exists please try to login');
				
			if ($this->User->validates()) {
				// Good
				$this->User->save();
				$this->login_user($this->User->id);
				$email = new CakeEmail('pcmail');
				$email->to($this->request->data['User']['email'])
					->subject('Welcome to '.SITE_NAME)
					->template('users-register')
					->viewVars(array(
						'name' => "{$this->request->data['User']['first_name']} {$this->request->data['User']['last_name']}",
						'email' => $this->request->data['User']['email']
					))
					->emailFormat('both')
					->send();
				if ($referer) {
					$this->Session->delete('referer');
					$this->redirect($referer);
				} else {
					$this->redirect('/');
				}
				
			} else {
				// Clear passwords before sending user back to the browser.
				$this->request->data['User']['password'] = '';
				$this->request->data['User']['password2'] = '';
				$this->Session->setFlash('Please check the form and try again. Do not forget to re-enter your password.', 'alert-warning');
			}
		}

		$this->set(compact('referer'));
		
	}

	/**
	 * Use this action to display all spots, feeds, and deals that the user is following.
	 */
	public function my_spots() {
		$this->User->id = $this->Auth->user('id');
		if(!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		
		$spot_ids = $this->User->SpotFollower->Spot->getMySpotIds($this->Auth->user('id'));
		$spots = $this->User->SpotFollower->Spot->find('all', array('conditions' => array('Spot.id' => $spot_ids)));
		
		$deals = $this->User->SpotFollower->Spot->Deal->getDealBySpotIds($spot_ids);
		$feeds = $this->User->SpotFollower->Spot->Feed->getFeedBySpotIds($spot_ids, array('Spot'));
		$user = $this->User->getUser(null, array('SpotFollower' => array('Spot' => array('Feed', 'Deal'))));
		$this->set(compact('user', 'feeds', 'spots', 'deals'));
	}
	
	
	
	public function love_special_share($special_id = null ) {
		
		$this->autorender = false;
		$this->User->ActiveDeal->Deal->id = $special_id ;
 
		
		if(!$this->User->ActiveDeal->Deal->exists()) {				
			
			throw new NotFoundException(__('Invalid special'));
		
		
		}
 
		$user = $this->User->read(null, $this->Auth->user('id') );
 
		
		//post to facebook
		$this->User->SpotFollower->Spot->recursive = -1;
		$special = $this->User->ActiveDeal->Deal->read(null, $special_id);
		$this->Facebook = $this->Components->load('Facebook') ;
		
		if (!$user['User']['facebook_id'] )
			$this->redirect("/special/view/" . $special_id );
			
		$facebook['user_id'] = $this->Auth->user('id')  ;
		$facebook['message'] = "Has endorsed " . $special['Deal']['name']  ;
		$facebook['url'] =  ABSOLUTE_URL . "/special/view/" . $special_id  ;
		$facebook['image'] = ABSOLUTE_URL . "/gen/deal/" . $special_id . "/200x200/default.jpg";
 

		//$this->Facebook->post( $facebook ) ;
			
		$this->redirect("/special/view/" . $special_id );
		 
		
	}
	
	
	public function endorse_spot_share($spot_id = null ) {
		
		
		$this->autorender = false;
		$this->User->SpotFollower->Spot->id = $spot_id ;
		
		
			
		if(!$this->User->SpotFollower->Spot->exists()) {				
			
			throw new NotFoundException(__('Invalid Spot'));
		
		
		}
		
		
		$user = $this->User->read(null, $this->Auth->user('id') );
		 
		
		//post to facebook
		$this->User->SpotFollower->Spot->recursive = -1;
		$spot = $this->User->SpotFollower->Spot->read( null, $spot_id );
		$this->Facebook = $this->Components->load('Facebook') ;
		
		if (!$user['User']['facebook_id'])
			$this->redirect("/spots/view/" . $spot_id );
			
		$facebook['user_id'] = $this->Auth->user('id')  ;
		$facebook['message'] = "Has endorsed " . $spot['Spot']['name']  ;
		$facebook['url'] =  ABSOLUTE_URL . "/spots/view/" . $spot_id  ;
		$facebook['image'] = ABSOLUTE_URL . "/gen/spot/" . $spot_id . "/200x200/" . $spot['Spot']['image_name'];
		 
			
		$this->Facebook->post( $facebook ) ;
		$this->set('spot', $spot);
			
		$this->redirect("/spots/view/" . $spot_id );
		
	}
	
	
	/**
	 * Call this method to create a relationship between the current logged in user and the given spot.
	 * If a duplicate relationship already exists, nothing will be done.
	 */
	public function endorse_spot($spot_id = null, $mobile = null) {
		
		$this->autorender = false;
		$this->User->SpotFollower->Spot->id = $spot_id;
		
		if(!$this->User->SpotFollower->Spot->exists()) {
			throw new NotFoundException(__('Invalid spot'));
		}
		
		$user_id = $this->Auth->user('id');
		
		
		$spot = $this->User->SpotFollower->Spot->read(null, $spot_id);
	 
		
		$this->loadModel('Like');
		$type_id = $this->Like->getTypeId("Spot") ;
		$has_endorsed = $this->Like->findByUserIdAndTargetIdAndTypeId(
			$user_id, $spot_id, $type_id);
		
		if(!$has_endorsed) {
		 
 
			$spot_endorsed_data = array( 
				'Like' => array(
					'target_id' => $spot_id,
					'user_id' => $user_id,
					'type_id' => $type_id
				)
			);
			
			$saved = $this->Like->add($spot_endorsed_data);
		 
			
			if ($mobile){
				ApiComponent::success(ApiSuccessMessages::$GENERIC_SUCESS, 'GOOD');
				die();
			} elseif($this->request->is('ajax')) {
				die($saved?'GOOD':'The spot could not be endorsed. Please, try again.');
			} else {
				if($saved) {
					$this->Session->setFlash(__('You have endorsed the spot.'), 'alert-success');
				} else {
					$this->Session->setFlash(__('The spot could not be endorsed. Please, try again.'), 'alert-warning');
				}
			}
			
		} else {
			
			$this->redirect("/spots/view/" . $spot_id );
			
		}
		
		
		//does this user use facebook??
		
		//
		$this->set('spot', $spot);
	}
	
	
	
	public function love_special($special_id = null, $mobile = null) {
		
		$this->autorender = false;
		$this->User->ActiveDeal->Deal->id = $special_id ;
 
		
		if(!$this->User->ActiveDeal->Deal->exists()) {
			throw new NotFoundException(__('Invalid special'));
		}
		
		$user_id = $this->Auth->user('id');
	 
		$this->loadModel('Like');
		$type_id = $this->Like->getTypeId("Deal") ;
		$has_loved = $this->Like->findByUserIdAndTargetIdAndTypeId(
			$user_id, $special_id, $type_id);
			
			
		$special = $this->User->ActiveDeal->Deal->read(null, $special_id);
		
		if(!$has_loved) {
			 
			
			$love_data = array( 
				'Like' => array(
					'target_id' => $special_id,
					'user_id' => $user_id,
					'type_id' => $type_id
				)
			);
			
			$saved = $this->Like->add($love_data);
		 
			
			if ($mobile){
				ApiComponent::success(ApiSuccessMessages::$GENERIC_SUCESS, 'GOOD');
				die();
			} elseif($this->request->is('ajax')) {
				die($saved?'GOOD':'The special could not be loved. Please, try again.');
			} else {
				if($saved) {
					$this->Session->setFlash(__('You have loved this special.'), 'alert-success');
				} else {
					$this->Session->setFlash(__('The special could not be loved. Please, try again.'), 'alert-warning');
				}
			}
			
		} else {
			
			$this->redirect("/special/view/" . $special_id );
			
		}
		
		
		
	//	$this->redirect($this->request->referer());
		$this->set('special', $special );
	}
	
 
	
	
	/**
	 * Call this method to create a relationship between the current logged in user and the given spot.
	 * If a duplicate relationship already exists, nothing will be done.
	 */
	public function follow_spot($spot_id = null, $mobile = null) {
		$this->autorender = false;
		$this->User->SpotFollower->Spot->id = $spot_id;
		
	 
		
		if(!$this->User->SpotFollower->Spot->exists()) {
			throw new NotFoundException(__('Invalid spot'));
		}
		
		$spot = $this->User->SpotFollower->Spot->read(null, $spot_id);
		
		$user_id = $this->Auth->user('id');
		
		//Grab list 
		$spot_followers = $this->User->SpotFollower->findByUserIdAndSpotId($user_id, $spot_id);
		
		if(!$spot_followers) {
			$spot_follower_data = array( 
				'SpotFollower' => array(
					'spot_id' => $spot_id,
					'user_id' => $user_id
				)
			);
			
			

			
			$saved = $this->User->SpotFollower->save($spot_follower_data);
			
			
			
			
			$this->loadModel('Like');
			$type_id = $this->Like->getTypeId("Spot") ;
		
			$has_endorsed = $this->Like->findByUserIdAndTargetIdAndTypeId(
			$user_id, $spot_id, $type_id);
		
			if(!$has_endorsed) {
		 
		 
				$type_id = $this->Like->getTypeId("Spot") ;
				
				$spot_endorsed_data = array( 
					'Like' => array(
						'target_id' => $spot_id,
						'user_id' => $user_id,
						'type_id' => $type_id
					)
				);
			
			$endorsed = $this->Like->add($spot_endorsed_data);
			
			}
			
			if ($mobile){
				ApiComponent::success(ApiSuccessMessages::$GENERIC_SUCESS, 'GOOD');
				die();
			} elseif($this->request->is('ajax')) {
				die($saved?'GOOD':'The spot could not be followed. Please, try again.');
			} else {
				if($saved) {
					$this->Session->setFlash(__('You are now following the spot.'), 'alert-success');
				} else {
					$this->Session->setFlash(__('The spot could not be followed. Please, try again.'), 'alert-warning');
				}
			}
			
		}
		
		$this->set('spot', $spot);
		
		#$this->redirect($this->request->referer());
	}
	/**
	 * Call this action to remove the relationship between a user and a model.
	 */
	public function unfollow_spot($spot_id = null, $mobile = null) {
		$this->autorender = false;
		$this->User->SpotFollower->Spot->id = $spot_id;
		if(!$this->User->SpotFollower->Spot->exists()) {
			throw new NotFoundException(__('Invalid spot'));
		}
		$conditions = array('SpotFollower.spot_id' => $spot_id, 'SpotFollower.user_id' => $this->Auth->user('id'));
		$deleted = $this->User->SpotFollower->deleteAll($conditions);
		if ($mobile){
			ApiComponent::success(ApiSuccessMessages::$GENERIC_SUCESS, 'GOOD');
			die();
		} elseif($this->request->is('ajax')) {
			die($deleted?'GOOD':'The spot could not be unfollowed. Please, try again.');
		} else {
			if($deleted) {
				$this->Session->setFlash(__('You are no longer following the spot.'), 'alert-success');
			} else {
				$this->Session->setFlash(__('The spot could not be unfollowed. Please, try again.'), 'alert-warning');
			}
		}
		
		$this->redirect('/spots/view/' . $spot_id );
	}
	
	
	/**
	 * Call this action to remove the relationship between a user and a model.
	 */
	public function unendorse_spot($spot_id = null, $mobile = null) {
		
		$this->autorender = false;
		
		$this->User->SpotFollower->Spot->id = $spot_id;
		if(!$this->User->SpotFollower->Spot->exists()) {
			throw new NotFoundException(__('Invalid spot'));
		}

	  
	
		$this->loadModel('Like');
		
		$data = array( 
				'Like' => array(
					'target_id' => $spot_id,
					'user_id' => $this->Auth->user('id'),
					'type_id' => 1 // SPOT
				)
			);
			
			
		$deleted = $this->Like->remove( $data );	
 
		if ($mobile){
			ApiComponent::success(ApiSuccessMessages::$GENERIC_SUCESS, 'GOOD');
			die();
		} elseif($this->request->is('ajax')) {
			die($deleted?'GOOD':'The spot could not be unendorsed. Please, try again.');
		} else {
			if($deleted) {
				$this->Session->setFlash(__('You are no longer endorsing the spot.'), 'alert-success');
			} else {
				$this->Session->setFlash(__('The spot could not be unendorsed. Please, try again.'), 'alert-warning');
			}
		}
		
		$this->redirect($this->request->referer());
	}
	
	
	//unlove deal
	public function unlove_special($deal_id = null, $mobile = null) {
		
		$this->autorender = false;
		
		 $this->User->ActiveDeal->Deal->id = $deal_id ;
 
	
		if(!$this->User->ActiveDeal->Deal->exists()) {
			throw new NotFoundException(__('Invalid spot'));
		}

	
		$this->loadModel('Like');
		
		$data = array( 
				'Like' => array(
					'target_id' => $deal_id,
					'user_id' => $this->Auth->user('id'),
					'type_id' => 2 // DEAL
				)
			);
			
	 
			
		
		$deleted = $this->Like->remove( $data );	
 
		
		if ($mobile){
			ApiComponent::success(ApiSuccessMessages::$GENERIC_SUCESS, 'GOOD');
			die();
		} elseif($this->request->is('ajax')) {
			die($deleted?'GOOD':'The special could not be unloved. Please, try again.');
		} else {
			if($deleted) {
				$this->Session->setFlash(__('You are no longer loving this special.'), 'alert-success');
			} else {
				$this->Session->setFlash(__('This special could not be unloved. Please, try again.'), 'alert-warning');
			}
		}
		
		$this->redirect($this->request->referer());
	}
	
	
	// API Functions
	public function api_login() {
		// Do Login
		if ($this->request->is('post')) {
			if ( ($this->request->data['User']['email'] == '')|| ($this->request->data['User']['password'] == '')){
				ApiComponent::error(ApiErrors::$MISSING_REQUIRED_PARAMATERS);
				return;
			}
			
			if ($this->Auth->login()) {
				$this->User->id = $this->Auth->user('id');
				$userData = $this->User->read();
				//$userData['User']['api_key']
				if(empty($userData['User']['api_key'])) {
					if ($this->User->generate_api_key($this->Auth->user('id'), $this->Session->id())){
						//refresh user with freshly generated API Key
						$userData = $this->User->read();
					} else {
						ApiComponent::error(ApiErrors::$INVALID_LOGIN);
					}
				} 
				// Succeed login and has api_key. Trim data and only pass api data. 
					$data['name'] =$userData['User']['name'];
					$data['email'] =$userData['User']['email'];
					$data['api_key'] =$userData['User']['api_key'];
					$data['show_welcome'] =$userData['User']['show_welcome'];
					ApiComponent::success(ApiSuccessMessages::$USER_LOGGED_IN, $data);
				
			} else {
				ApiComponent::error(ApiErrors::$INVALID_LOGIN);
			}
		} else {
			ApiComponent::error(ApiErrors::$MISSING_REQUIRED_PARAMATERS);
		}
	}

	// When a user has authenticated on Facebook, check here to see if the login exists and is valid.
	public function api_facebook_login_check() {
		if ($this->request->is('post') && !empty($_POST['token']) && !empty($_POST['email'])) {
			// Verify that the FB access token is valid and matches
			$facebook_token_response = json_decode(@file_get_contents("https://graph.facebook.com/me?access_token={$_POST['token']}"), true);
			if (empty($facebook_token_response) || !empty($facebook_token_response['error'])) {
				ApiComponent::error(ApiErrors::$MISMATCH_FACEBOOK_CREDENTIALS);
			}
			// Match the user-supplied email vs. facebook-supplied email
			$facebook_email = str_replace('\u0040', '@', $facebook_token_response['email']);
			$user_email = $_POST['email'];
			if (strcmp($facebook_email, $user_email) !== 0) {
				ApiComponent::error(ApiErrors::$MISMATCH_FACEBOOK_CREDENTIALS);
			}
			// We have a valid facebook token. This indicates the user's identity can be trusted as the user.
			// Check for existing account.
			$unlokt_user = $this->User->findByEmail($user_email);
			
			if (!$unlokt_user) {
				//if user is not in the system, create user
				$unlokt_user = array('User'=>array(
					'email' => $facebook_token_response['email'],
					'first_name' => $facebook_token_response['first_name'],
					'last_name' => $facebook_token_response['last_name'],
					'is_active' => true,
					'gender' => $facebook_token_response['gender'],
					'is_facebook_only' => true,
					'facebook_id' => $facebook_token_response['id']
				));
				$this->User->create();
				$unlokt_user = $this->User->save($unlokt_user);
				// Save the user's facebook photo
				$uniqid = uniqid().time();
				@copy("https://graph.facebook.com/{$user->id}/picture?type=large", TMP.DS.$uniqid);
				@convert(TMP.DS.$uniqid, store_path('user', $this->User->id, 'default.jpg'));
				@unlink(TMP.DS.$uniqid);
			} else if (!$unlokt_user['User']['is_facebook_only']) {
				$this->User->id = $unlokt_user['User']['id'];
				$user_update = array('User' => array(
					'id' => $unlokt_user['User']['id'],
					'first_name' => $facebook_token_response['first_name'],
					'last_name' => $facebook_token_response['last_name'],
					'gender' => $facebook_token_response['gender'],
					'is_facebook_only' => true,
					'facebook_id' => $facebook_token_response['id']
				));
				$this->User->save($user_update);
			}
			
			//user has no api key, so generate one
			if(empty($unlokt_user['User']['api_key'])) {
				$this->User->generate_api_key($unlokt_user['User']['id'], $this->Session->id());
				$this->login_user($this->User->id);
				$unlokt_user = $this->User->read();
			}
			
			// User was either found or created.  Respond with the api_key
			ApiComponent::success(ApiSuccessMessages::$GENERIC_SUCESS, array('api_key' => $unlokt_user['User']['api_key'], 'show_welcome' => $unlokt_user['User']['show_welcome']));
		} else {
			ApiComponent::error(ApiErrors::$MISSING_REQUIRED_PARAMATERS);
		}
	} // api_facebook_login_check()
	
	public function api_logout(){
		$this->Session->destroy(); 
		ApiComponent::success(ApiSuccessMessages::$USER_LOGGED_OUT);
	}
	
	
	public function api_register() {
		if ($this->request->is('post')) {
			// Attempt to validate and save user.
			$user = $this->User->findByEmail($this->request->data['User']['email']);
			if (!empty($user)) {
				ApiComponent::error(ApiErrors::$EMAIL_IN_USE);
			}
			
			$this->User->set($this->request->data);
			// If the user isn't a facebook-only user then require password.
			if (empty($this->request->data['User']['is_facebook_only'])) {
				$this->User->set('password', $this->bcrypt_hash($this->request->data['User']['password']));
				if (!$this->request->data['User']['password'] || strcmp($this->request->data['User']['password'], $this->request->data['User']['password2']) !== 0) {
					//Password missing
					ApiComponent::error(ApiErrors::$MISSING_REQUIRED_PARAMATERS);
				}
			}
			
			if ($this->User->validates()) {
				// Sucess
				$this->User->save();
				$this->User->generate_api_key($this->User->id, $this->Session->id());
				$this->login_user($this->User->id);
				$userData = $this->User->read();
				$data['name'] = $userData['User']['name'];
				$data['email'] = $userData['User']['email'];
				$data['api_key'] = $userData['User']['api_key'];
				$data['show_welcome'] = $userData['User']['show_welcome'];
				// Copy over the facebook picure if it's a facebook user.
				if (!empty($this->request->data['User']['is_facebook_only']) && !empty($this->request->data['User']['facebook_id'])) {
					$uniqid = uniqid().time();
					@copy("https://graph.facebook.com/{$this->request->data['User']['facebook_id']}/picture?type=large", TMP.DS.$uniqid);
					@convert(TMP.DS.$uniqid, store_path('user', $this->User->id, 'default.jpg'));
					@unlink(TMP.DS.$uniqid);
				}
				ApiComponent::success(ApiSuccessMessages::$USER_REGISTERED, $data);
				
			} else {
				ApiComponent::error(ApiErrors::$MISSING_REQUIRED_PARAMATERS);
			}
			
		} else {
			ApiComponent::error(ApiErrors::$NO_DATA_PASSED);
		}
		
	} // end of api_register()
	
	
	public function api_my_spot_ids() {
		$spot_ids = $this->User->SpotFollower->Spot->getMySpotIds($this->Auth->user('id'));
		ApiComponent::success(ApiSuccessMessages::$GENERIC_SUCESS, array_keys($spot_ids));
	}
	
	public function api_my_spots() {
		$this->User->id = $this->Auth->user('id');
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		
		$spot_ids = $this->User->SpotFollower->Spot->getMySpotIds($this->Auth->user('id'));
		$dow = array(
			'sunday' => 1,
			'monday' => 1,
			'tuesday' => 1,
			'wednesday' => 1,
			'thursday' => 1,
			'friday' => 1,
			'saturday' => 1
		);
		
		$spotsfeed = array();
		$this->User->SpotFollower->Spot->Deal->limit = 100;
		$this->User->SpotFollower->Spot->Deal->current_start_time = '00:00:00';
		$this->User->SpotFollower->Spot->Deal->current_end_time = '23:59:59';
		$this->User->SpotFollower->Spot->Deal->current_day_of_week = $dow;
		
		$this->User->SpotFollower->Spot->HappyHour->limit = 100;
		$this->User->SpotFollower->Spot->HappyHour->current_start_time = '00:00:00';
		$this->User->SpotFollower->Spot->HappyHour->current_end_time = '23:59:59';
		$this->User->SpotFollower->Spot->HappyHour->current_day_of_week = $dow;
		$this->User->SpotFollower->Spot->HappyHour->order = 'HappyHour.day_of_week ASC';
		
		$happyHours = $this->User->SpotFollower->Spot->HappyHour->getCurrentHappyHourParentsBySpot($spot_ids, array('Spot', 'ParentHappyHour'));
		$spotsfeed['deals'] = $this->User->SpotFollower->Spot->Deal->getDealBySpotIds($spot_ids, array('Spot'));
		$spotsfeed['feeds'] = $this->User->SpotFollower->Spot->Feed->getFeedBySpotIds($spot_ids, array('Spot','Attachment'));
		// Grab the current HappyHours
		// $this->User->SpotFollower->Spot->HappyHour->order = 'HappyHour.day_of_week ASC';
		// $happyHours = $this->User->SpotFollower->Spot->HappyHour->getCurrentHappyHourBySpot($spot_ids, array('Spot', 'ParentHappyHour'));
		$spotsfeed['deals'] = array_merge($spotsfeed['deals'], $happyHours);
		
		usort($spotsfeed['deals'], array('Deal', 'sortDealsByRandomDelta'));
		
		ApiComponent::success(ApiSuccessMessages::$GENERIC_SUCESS, $spotsfeed);
	} // end of api_my_spots

	
	public function api_account() {
		$user_id = $this->Auth->user('id');
		$mydeals = array();
		$mydeals['user'] = $this->User->getUser($user_id, array('Review' => array('Spot')/*, 'ActiveDeal'*/));
		$mydeals['deals'] = $this->User->ActiveDeal->Deal->getActiveDealsByUserId($user_id, array('Spot'));
		ApiComponent::success(ApiSuccessMessages::$GENERIC_SUCESS, $mydeals);
	} // end of account()
	
	public function api_save_profile() {
		if (!$this->request->is('post')) {
			ApiComponent::error(ApiErrors::$MISSING_REQUIRED_PARAMATERS);
		}
		if (empty($this->request->data['User']['password']) && empty($this->request->data['User']['password2'])) {
			unset($this->request->data['User']['password']);
		} elseif (strcmp($this->request->data['User']['password'], $this->request->data['User']['password2']) !== 0) {
			ApiComponent::error(ApiErrors::$MISMATCH_PASSWORDS);
		} else {
			$this->request->data['User']['password'] = $this->bcrypt_hash($this->request->data['User']['password']);
		}
		$this->User->create(false);
		$this->User->set($this->request->data);
		$this->User->set('id', $this->Auth->user('id'));
		$this->User->save();
		ApiComponent::success(ApiSuccessMessages::$GENERIC_SUCESS, array());
	} // end of api_save_profile
	
	public function api_hide_welcome() {
		if($this->request->is('post')) {
			$this->User->set(array('User' => array('show_welcome' => false)));
			if($this->User->save()) {
				ApiComponent::success(ApiSuccessMessages::$GENERIC_SUCESS, array());
			} else {
				ApiComponent::error(ApiErrors::$MISSING_REQUIRED_PARAMATERS);
			}
		} else {
			ApiComponent::error(ApiErrors::$NO_DATA_PASSED);
		}
	}
	
	public function account() {
		$user_id = $this->Auth->user('id');
		$user = $this->User->getUser($user_id, array('Review', 'ActiveDeal'));
		$reviews = $this->User->Review->getReviewByUserId($user_id, array('Spot', 'User'));
		$deals = $this->User->ActiveDeal->Deal->getActiveDealsByUserId($user_id, array('Spot'));
		$this->set(compact('user', 'reviews', 'deals'));
	} // end of account()
	
	public function account_edit() {
		$user = $this->User->read(null, $this->Auth->user('id'));
		
		if ($this->request->is('post') || $this->request->is('put')) {
			$this->User->create(false);
			$this->User->set($this->request->data);
			$this->User->id = $this->Auth->user('id');
			// Check if there has been an update to password and it matches.
			if (isset($this->request->data['User']['password']) && !empty($this->request->data['User']['password'])) {
				if (strcmp($this->request->data['User']['password'], $this->request->data['User']['password2']) === 0) {
					$this->User->set('password', $this->bcrypt_hash($this->request->data['User']['password']));
					// Clear the passwords regardless.
					$this->request->data['User']['password'] = '';
					$this->request->data['User']['password2'] = '';
				} else {
					$this->request->data['User']['password'] = '';
					$this->request->data['User']['password2'] = '';
					$this->User->invalidate('password', 'Passwords did not match.');
					$this->User->invalidate('password2', 'Passwords did not match.');
				}
			} else {
				// No password was typed by the user.
				// Remove both passwords from POST data (so they don't get sent back to the view).
				// Unset the password field from the User model so it doesn't get saved as a blank password.
				$this->request->data['User']['password'] = '';
				$this->request->data['User']['password2'] = '';
				unset($this->User->data['User']['password']);
			}
			// If the data on the User model is valid then save it.
			if ($this->User->validates()) {
				
				// Check if a picture is being uploaded.
				if (isset($_FILES['file']) && is_array($_FILES['file']) && !$_FILES['file']['error']) {
					$filename = $user['User']['id'] . '_' . time() . '_' . rand(0,1000000);
					$filename = md5($filename).".jpg";
					$this->User->set('image_name', $filename);
					
					convert($_FILES['file']['tmp_name'], store_path('user', $this->Auth->user('id'), $filename));
					delete_cache('user', $this->Auth->user('id'));
				}
				
				$this->User->save();
				$this->force_reauthorization($this->Auth->user('id'));
				$this->Session->setFlash('Your account settings have been saved.', 'alert-success');
				$this->redirect(array('action' => 'account'));
			} else {
				// If the validation failed & there is a password, be sure to notify the user to re-enter password.
				if (isset($this->User->data['User']['password'])) {
					$this->Session->setFlash('Please check the form and try again. Do not forget to re-enter your password.', 'alert-warning');
				} else {
					$this->Session->setFlash('Please check the form and try again.', 'alert-warning');
				}
			}
		// No POST data - send the $user object to the view.
		} else {
			// Remove the password from the $user object before sending the data to the view.
			unset($user['User']['password']);
			$this->request->data = $user;
		}
		$this->loadModel('Location');
		$locations = $this->Location->find('list');
		$this->set(compact('locations'));
	} // end of account_edit()
	
	/**
	 * Delete the account of the currently logged in user
	 */
	public function account_delete() {
		$this->autoLayout = false;
		$this->User->id = $this->Auth->user('id');
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash('Account deleted', 'alert-success');
			//logout the user after delete
			$this->redirect(array('action' => 'logout'));
		}
		
		$this->Session->setFlash('User was not deleted', 'alert-warning');
		$this->redirect(array('action' => 'account_edit'));
	}

	public function set_location() {
		$location_id = isset($this->request->data['User']['location_id'])?$this->request->data['User']['location_id']:null;
		
		$this->loadModel('Location');
		$this->Location->id = $location_id;
		
		if($location_id != null && !$this->User->Location->exists()) {
			throw new NotFoundException('Invalid location');
		}
		
		$this->User->id = $this->Auth->user('id');
		
		if($this->User->saveField('location_id', $location_id)) {
			$this->Session->setFlash('Location changed.', 'alert-success');
		} else {
			$this->Session->setFlash('Location could not be changed. Please try again.', 'alert-warning');
		}
		
		$this->redirect($this->request->referer());
	}
	
	
	public function test2() { 
		
 
		echo 'load the component<br>';
		
		$this->Facebook = $this->Components->load('Facebook');
		
		echo 'after<br>';
		//$this->Facebook->login();
		$this->Facebook->post("bbfbbb", $this->Auth->user('id'));
		
		echo 'after test post<br>';
		exit();
		
		
		
	}
	public function login_facebook() {
		
		$app_id = FACEBOOK_APPID ;
		$app_secret = FACEBOOK_SECRET ;
		
		$my_url = "http://unlokt.com/users/login_facebook";
		
		/*
		 * YOUR_REDIRECT_URI?
		    error_reason=user_denied
		   &error=access_denied
		   &error_description=The+user+denied+your+request.
		   &state=YOUR_STATE_VALUE
		 */
		
		// debug($_SESSION);
		// debug($_REQUEST);
		$code = empty($_REQUEST["code"])?'':$_REQUEST['code'];
	
		if(empty($code)) {
			// Redirect to Login Dialog
			$_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
			$dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
				. $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
				. "&client_secret=" . $app_secret . "&code=" . $code
				. $_SESSION['state']. "&scope=publish_stream,email";
	  
			header("Location: $dialog_url");
			exit();
			#echo "REDIRECT PROBLEM";
			return;
	   }
	   
	   if($_SESSION['state']) {
			// state variable matches
			$token_url = "https://graph.facebook.com/oauth/access_token?" 
				. "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
				. "&client_secret=" . $app_secret . "&code=" . $code;
			$response = file_get_contents($token_url);
			$params = null;
			parse_str($response, $params);
			$_SESSION['access_token'] = $params['access_token'];
			
			$graph_url = "https://graph.facebook.com/me?access_token=" 
				. $params['access_token'];
			
			$user = json_decode(file_get_contents($graph_url));
			
			// debug($user);
			// echo("Hello " . $user->name);
			// echo($user->email);
			//look up user
			$unlokt_user = $this->User->findByEmail($user->email);
			//debug($unlokt_user);
			if (!$unlokt_user) {
				//debug('create unlokt user');
				//if user is not in the system, create user
				$unlokt_user = array('User'=>array(
					'email' => $user->email,
					'first_name' => $user->first_name,
					'last_name' => $user->last_name,
					'is_active' => true,
					'gender' => $user->gender,
					'is_facebook_only' => true,
					'facebook_id' => $user->id
				));
				$this->User->create();
				$unlokt_user = $this->User->save($unlokt_user);
				// Save the user's facebook photo
				$uniqid = uniqid().time();
				@copy("https://graph.facebook.com/{$user->id}/picture?type=large", TMP.DS.$uniqid);
				@convert(TMP.DS.$uniqid, store_path('user', $this->User->id, 'default.jpg'));
				@unlink(TMP.DS.$uniqid);
			} else {
				//debug('update unlokt user');
				$this->User->id = $unlokt_user['User']['id'];
				$user_update = array('User' => array(
					'id' => $unlokt_user['User']['id'],
					'first_name' => $user->first_name,
					'last_name' => $user->last_name,
					'gender' => $user->gender,
					'is_facebook_only' => true,
					'facebook_id' => $user->id,
					'facebook_token' =>  $params['access_token']
				));
				
				$this->log($params['access_token']);
				$this->User->save($user_update);
			}
			//if user is in the system log them in
			$this->login_user($unlokt_user['User']['id']);
			
			//bring them to the home page
			$this->redirect('/');
	   }
	}

	private function _logout_facebook() {
		$app_id = "309486975818919";
		$app_secret = "258dc70e86af80006ddb40407767f9fc";
		//$my_url = "YOUR_LOGOUT_URL";

		$token = empty($_SESSION['access_token'])?false:$_SESSION['access_token'];
		
		if($token) {
			$graph_url = "https://graph.facebook.com/me/permissions?method=delete&access_token=" 
				. $token;

			$result = json_decode(file_get_contents($graph_url));
			if($result) {
				$this->Session->destroy();
				//user now logged out
 			}
		}
	}
	
	public function channel() {
		$this->autoLayout = false;
		echo "<script src=\"//connect.facebook.net/en_US/all.js\"></script>";
		die();
	}
}
