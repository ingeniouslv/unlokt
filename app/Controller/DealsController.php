<?php
App::uses('AppController', 'Controller');

class DealsController extends AppController {
	public $uses = array('Deal');
	
	public function beforeFilter() {
        //$this->Auth->allow(array('view'));
        $this->Auth->allow(array());
        
        parent::beforeFilter();
    }
	
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Deal->recursive = 0;
		$this->paginate = array(
			'order' => array(
				'name' => 'asc'
			)
		);
		$this->set('deals', $this->paginate());
	}
	
	//////////////////////////////////////////////////
	
	public function view($id) {
		$app_id = "309486975818919";
		$channel_url = "http://development.unlokt.com/channel";
		
		$this->Deal->id = $id;
		
		if (!$deal = $this->Deal->getDeal($id, array('RedemptionCode'))) {
			throw new NotFoundException('Could not find ');
		}
		$contain = array('Category', 'Feed');
		$spot = $this->Deal->Spot->getSpot($deal['Deal']['spot_id'], $contain);
		
		// If logged in, see if the current user has any progress on redeeming this deal.
		if ($this->Auth->loggedIn()) {
			// $active_deal = $this->Deal->ActiveDeal->getActiveDealByDeal($id);
			$activeDeal = $this->Deal->ActiveDeal->findByDealIdAndUserId($id, $this->Auth->user('id'));
		}
		$this->Deal->Spot->id = $deal['Deal']['spot_id'];
		$is_manager = $this->Deal->Spot->Manager->isManager();
		$is_manager = ($is_manager)?$is_manager:$this->Auth->user('is_super_admin');
		$deals = $this->Deal->getDealsBySpotIds($spot['Spot']['id'], array(), array($id));
		$deal_completed_count = $this->Deal->ActiveDeal->findCompletedCountByDealIdAndAndUserId($id, $this->Auth->user('id'));
		
		$this->Deal->increment('views');
		$this->set(compact('deal', 'spot', 'activeDeal', 'deals', 'deal_completed_count', 'is_manager', 'app_id', 'channel_url'));
	}
	
	//////////////////////////////////////////////////
	
	// Manage Deals for a specified Spot
	public function manage($spot_id = null, $show_active = true) {
		if (!$spot_id) {
			throw new NotFoundException('Spot ID required');
		}
		$this->Deal->Spot->id = $spot_id;
		//Anthony Scott 10/29/2012 - Allowed this page if the user is a super admin
		if (!$this->Deal->Spot->Manager->isManager() && !$this->Auth->user('is_super_admin')) {
			throw new NotFoundException('You do not have permission to this.');
		}
		
		$spot = $this->Deal->Spot->findById($spot_id);
		
		 
		$paginate_array = array(
			'conditions' => array(
				'is_active' => $show_active
			),
			'order' => array(
				'created'
			)
		);
		$paginate_array['conditions']['spot_id'] = ($spot['Spot']['parent_spot_id'] != null)? $spot['Spot']['parent_spot_id'] :$spot_id;
		
		$this->paginate = $paginate_array;
		
		$deals = $this->paginate();
		
		$this->set(compact('spot', 'deals', 'show_active'));
		
		
		// Don't limit the amount of Deals we retreive.
		// $this->Deal->limit = 0;
		// $deals = $this->Deal->getDealBySpotIds($spot_id);
		// debug($deals);
	}
	
	//////////////////////////////////////////////////
	
	public function statistics($id = null) {
		if (!$id || !$deal = $this->Deal->read(null, $id)) {
			throw new NotFoundException('Special not found.');
		}
		// Ensure we have access.
		$this->Deal->Spot->id = $deal['Deal']['spot_id'];
		if (!$this->Deal->Spot->Manager->isManager()) {
			throw new NotFoundException('You do not have permission to this.');
		}
		$this->set(compact('deal'));
	}
	
	//////////////////////////////////////////////////
	
	public function add($spot_id) {
		$this->Deal->Spot->id = $spot_id;
		if (!$spot = $this->Deal->Spot->read(null, $spot_id)) {
			throw new NotFoundException('Spot not found.');
		}
		if (!$this->Deal->Spot->Manager->isManager()) {
			throw new NotFoundException('You do not have permission to this.');
		}
		if ($this->request->is('post')) {
			$this->Deal->create(false);
			//if all day is checked, change the start and end time to match.
			if ($this->request->data['Deal']['all_day']) {
				$this->request->data['Deal']['start_time'] = '12:00 AM';
				$this->request->data['Deal']['end_time'] = '11:59 PM';
			}
			//change time format
			$this->request->data['Deal']['start_time'] = date('H:i', strtotime($this->request->data['Deal']['start_time']));
			$this->request->data['Deal']['end_time'] = date('H:i', strtotime($this->request->data['Deal']['end_time']));
			//change the format of the start and end date
			$this->request->data['Deal']['start_date'] = date('Y-m-d', strtotime($this->request->data['Deal']['start_date']));
			$this->request->data['Deal']['end_date'] = date('Y-m-d', strtotime($this->request->data['Deal']['end_date']));
			$this->Deal->set($this->request->data);
			
			//if the spot has a parent spot, add the deal to the parent spot
			$deal_spot_id = ($spot['Spot']['parent_spot_id'] != null)? $spot['Spot']['parent_spot_id'] : $spot_id;
			$this->Deal->set(array(
				'spot_id' => $deal_spot_id,
				'is_active' => 1
			));
			// Do all the validation here.
			// Loop through however many Keys and check for all the redemption codes.
			for ($i = 1; $i <= $this->request->data['Deal']['keys']; $i ++) {
				if (!isset($this->request->data['Deal']["redemption_$i"]) || !$this->request->data['Deal']["redemption_$i"] || trim($this->request->data['Deal']["redemption_$i"]) == '') {
					$this->Deal->invalidate("redemption_$i", 'Redemption Code Required');
				}
			}
			// Check that there is a Deal.tmp_image_name, which holds a value such as
			// "a4d14252f2e1c60b3e6d990b0c672293.jpg" which indicates to copy() the image from the store_path('temp', 0).
			// If there is no tmp_image_name then fail validation because that means no image was uploaded...
			$tmp_image_file = store_path('temp', 0, @$this->request->data['Deal']['tmp_image_name']);
			if (!isset($this->request->data['Deal']['tmp_image_name']) || !$this->request->data['Deal']['tmp_image_name'] || !is_file($tmp_image_file)) {
				$this->Deal->invalidate('name', 'Image required.');
			}
			if ($this->Deal->validates()) {
				// Deal data is valid.
				$this->Deal->save();
				// Save all the redemption codes into database.
				for ($i = 1; $i <= $this->request->data['Deal']['keys']; $i ++) {
					$this->Deal->RedemptionCode->create(false);
					$this->Deal->RedemptionCode->set(array(
						'deal_id' => $this->Deal->id,
						'step' => $i,
						'code' => $this->request->data['Deal']["redemption_$i"]
					));
					$this->Deal->RedemptionCode->save();
				}
				// Copy over the tmp_image_file
				mkdir(store_path('deal', $this->Deal->id), 0777, true);
				copy($tmp_image_file, store_path('deal', $this->Deal->id, 'default.jpg'));
				$this->Session->setFlash('Special created successfully.', 'alert-success');
				$this->redirect(array('action' => 'manage', $spot_id));
				
				
			} else {
				$this->Session->setFlash('Form could not be saved. Check the form and try again.', 'alert-warning');
			}
			
		// No POST data
		} else {
			// Set some defaults for the Deal
			$this->request->data = array(
				'Deal' => array(
					'keys' => 1,
					'limit_per_customer' => 0,
					'tmp_image_name' => '',
					'name' => 'Example Title',
					'description' => 'Example Description'
				)
			);
		} // end of if (POST)
		
		// Set a variable $deals with a single Deal inside for displaying the preview of a deal tile.
		$deal = Set::merge(array('Deal' => array('description' => '', 'name' => '', 'id' => 0)), $this->request->data);
		$this->set(compact('deal', 'spot'));
	} // end of add()
	
	//////////////////////////////////////////////////
	
	// Accept a file upload and place in temporary folder.
	// Then die a javascript statement to update the preview image on the parent window since this should be an iframe.
	public function upload_preview_image() {
		$this->autoRender = false;
		if (!isset($this->request->data['file']) || !$file = $this->request->data['file']) {
			die('<script> alert("No file uploaded"); </script>');
		}
		// Do some simple error checking
		if ($file['error'] || !$file['size'] || substr($file['type'], 0, 6) != 'image/') {
			die('<script> alert("No file uploaded"); </script>');
		}
		// Create random-ish hash for temporary filename.
		$hashjpg = md5($_SERVER['REMOTE_ADDR'].time().rand(0, 99999)).'.jpg';
		// Convert over the image and place into correct directory.
		convert($file['tmp_name'], store_path('temp', 0, $hashjpg));
		die("<script> window.parent.upload_preview_image_postback('$hashjpg'); </script>");
	}
	
	//////////////////////////////////////////////////
	
	public function history() {
		//TODO: Method stub for deals/history
		$this->set('deals', $this->paginate());
	}

	//////////////////////////////////////////////////

	public function my_active_deals() {
		
		$this->paginate = array(
			'joins' => array(
				array(
					'table' => 'active_deals',
					'alias' => 'ActiveDeal',
					'type' => 'INNER',
					'conditions' => array(
						'Deal.id = ActiveDeal.deal_id',
						'ActiveDeal.user_id' => $this->Auth->user('id')
					)
				)
			)
		);
		$deals = $this->paginate();
		$this->set(compact('deals'));
	}
	
	//////////////////////////////////////////////////
	
	/**
	 * Switch the isActive on the given deal.
	 */
	public function toggle_is_active($id = NULL) {
		$this->Deal->id = $id;
		if (!$this->Deal->exists()) {
			throw new NotFoundException(__('Invalid page'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$deal = $this->Deal->read(null, $id);
			$deal['Deal']['is_active'] = !$deal['Deal']['is_active'];
			if ($this->Deal->save($deal)) {
				$this->Session->setFlash(__('The special has been saved'), 'alert-success');
				$this->redirect($this->request->referer());
			} else {
				$this->Session->setFlash(__('The special could not be saved. Please, try again.'), 'alert-warning');
			}
		} else {
			$this->request->data = $this->Deal->read(null, $id);
		}
	}
	
	//////////////////////////////////////////////////
	
	public function deal_wizard() {
		// Get a list of Manageable Spots of the current User 
		$spots = $this->Deal->Spot->Manager->getSpotListByManager();
		if (!$spots) {
			throw new NotFoundException('You do not manage any spots.');
		}
		
		// debug($this->Deal->schema());
		
		if ($this->request->is('post')) {
			$this->Deal->Spot->id = $this->request->data['Deal']['spot_id'];
			if (!$this->Deal->Spot->Manager->isManager()) {
				throw new NotFoundException('You do not have permission to edit this spot.');
			}
			$this->Deal->create(false);
			$this->Deal->set($this->request->data);
			if ($this->Deal->validates()) {
				$this->Session->write('deal_wizard', $this->request->data);
				$this->redirect(array('action' => 'deal_wizard_step_2'));
			} else {
				$this->Session->setFlash('Please check the form and try again.', 'alert-warning');
			}
		} else {
			// There is no post data - load default values and send them to the view.
			$this->Deal->create();
			$this->request->data = $this->Deal->data;
		} // end of this->request->is('post')
		$this->set(compact('spots'));
	} // end of deal_wizard
	
	//////////////////////////////////////////////////
	
	public function deal_wizard_step_2() {
		$deal = $this->Session->read('deal_wizard');
		if ($this->request->is('post')) {
			$this->Deal->Spot->id = $this->request->data['Deal']['spot_id'];
			if (!$this->Deal->Spot->Manager->isManager()) {
				throw new NotFoundException('You do not have permission to edit this spot.');
			}
		} else {
			$this->request->data = $deal;
		}
		$this->set(compact('deal'));
	} // end of deal_wizard_step_2
	
	//////////////////////////////////////////////////
	
	// A logged-in user is attempting to redeem a deal.
	public function redeem_with_code($id = null, $code = null) {
		$this->autoRender = false;
		if (!$id || !$code) {
			throw new NotFoundException('Missing require parameter(s)');
		}
		if (!$deal = $this->Deal->read(null, $id)) {
			throw new NotFoundException('Could not find Special');
		}
		$this->loadModel('RedemptionCode');
		
		// Look through ActiveDeals to see if there is an ActiveDeal and if it can be processed.
		if ($activeDeal = $this->Deal->ActiveDeal->findByDealIdAndUserIdAndIsCompleted($id, $this->Auth->user('id'), 0)) {
			// Not-complete Deal found. Let's do the next step and then save it & do the next action.
			// Grab the next RedemptionCode for this Deal, and then match it to the user's input.
			$next_step = $activeDeal['ActiveDeal']['completed_step'] + 1;
			 if (!$redemptionCode = $this->RedemptionCode->findByDealIdAndStep($id, $next_step)) {
			 	throw new Exception('Could not find a RedemptionCode for Special '.$id);
			 }
			 if (strcmp($redemptionCode['RedemptionCode']['code'], $code) !== 0) {
 				ApiComponent::error(ApiErrors::$MISSING_REQUIRED_PARAMATERS);
			 	die('');
			 }
			 // The user-inputted code for this step was correct, 
			 // so update the ActiveDeal record with appropriate information.
			 $this->Deal->ActiveDeal->create(false);
			 $this->Deal->ActiveDeal->save(array(
			 	'id' => $activeDeal['ActiveDeal']['id'],
			 	'completed_step' => $next_step,
			 	'is_completed' => ($next_step == $deal['Deal']['keys']),
			 	'completed_date' => ($next_step == $deal['Deal']['keys'] ? date(MYSQL_TIME) : null)
			 ));
			 // Update the Deal's statistics.
			 $this->Deal->id = $deal['Deal']['id'];
			 $this->Deal->increment('redemptions');
			 if ($next_step == $deal['Deal']['keys']) {
			 	$this->Deal->increment('completions');
			 }
			 $this->api_view($id);
			 die('');
			 
		} else {
			// No Deal was found - let's make sure we qualify to perform this Deal, then make it so.
			$done_count = $this->Deal->ActiveDeal->findCountByDealIdAndAndUserId($id, $this->Auth->user('id'));
			if ($deal['Deal']['limit_per_customer'] && $done_count >= $deal['Deal']['limit_per_customer']) {
				ApiComponent::error(ApiErrors::$MAX_REDEEM);
				die('');
				throw new NotFoundException('You have redeemed this Special too many times.');
			}
			// Start Deal since we are not beyond the limit. Woot.
			// Check the $code against the RedemptionCode for step 1 redemption code.
			$redemptionCode = $this->RedemptionCode->findByDealIdAndStep($id, 1);
			if (strcmp($redemptionCode['RedemptionCode']['code'], $code) !== 0) {
				ApiComponent::error(ApiErrors::$MISSING_REQUIRED_PARAMATERS);
				die('');
				//die('BADCODE');
			}
			$this->Deal->ActiveDeal->create(false);
			$this->Deal->ActiveDeal->save(array(
				'user_id' => $this->Auth->user('id'),
				'deal_id' => $id,
				'is_completed' => ($deal['Deal']['keys'] == 1),
				'completed_step' => 1,
				'completed_date' => ($deal['Deal']['keys'] == 1 ? date(MYSQL_TIME) : null)
			));
			// Update the Deal's statistics.
			 $this->Deal->id = $deal['Deal']['id'];
			 $this->Deal->increment('redemptions');
			 if ($deal['Deal']['keys'] == 1) {
			 	$this->Deal->increment('completions');
			 }
 			 $this->api_view($id);
			die('');
		}
	} // end of redeem_with_code()

	//////////////////////////////////////////////////
	
	/// API functions
	
	public function api_view($id) {
		$this->Deal->id = $id;
		
		if (!$deal = $this->Deal->getDeal($id, array('RedemptionCode'))) {
			ApiComponent::error(ApiErrors::$MISSING_REQUIRED_PARAMATERS);
			return;
		}
		$contain = array('Category', 'Feed');
		$spot = $this->Deal->Spot->getSpot($deal['Deal']['spot_id'], $contain);
		
		// If logged in, see if the current user has any progress on redeeming this deal.
		if ($this->Auth->loggedIn()) {
			// $active_deal = $this->Deal->ActiveDeal->getActiveDealByDeal($id);
			$DealView['activeDeal'] = $this->Deal->ActiveDeal->findByDealIdAndUserId($id, $this->Auth->user('id'));
		}
		$DealView['user_id']= $this->Auth->user('id');
		$DealView['deal_completed_count'] = $this->Deal->ActiveDeal->findCompletedCountByDealIdAndAndUserId($id, $this->Auth->user('id'));
		ApiComponent::success(ApiSuccessMessages::$GENERIC_SUCESS, $DealView);

	}
	
	
}