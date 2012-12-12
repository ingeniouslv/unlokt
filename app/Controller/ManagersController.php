<?php
App::uses('AppController', 'Controller');
/**
 * Managers Controller
 *
 * @property Manager $Manager
 */
class ManagersController extends AppController {

	public function beforeFilter() {
		$this->Auth->allow(array());
		parent::beforeFilter();
	}
	
	public function add($spot_id=null) {
		//spot_id is passed through post variables on submission.  Otherwise it is grabbed through action parameters.
		$spot_id = ($spot_id)?$spot_id:$this->request->data['Manager']['spot_id'];
		$this->Manager->Spot->id = $spot_id;
		if(!$this->Manager->Spot->exists()) {
			throw new NotFoundException('Invalid spot');
		}
		if (!$this->Manager->isAdmin() && !$this->Auth->user('is_super_admin')) {
			throw new NotFoundException('You do not have permission to this.');
		}
		if(array_key_exists('Manager', $this->request->data)) {
			$user = $this->Manager->User->findByEmail($this->request->data['Manager']['email']);
			if($user) {
				//user found so add them as a manager to the spot
				
				$this->Manager->create();
				$manager = array(
					'Manager' => array(
						'spot_id' => $spot_id,
						'user_id' => $user['User']['id'],
						'is_admin' => $this->request->data['Manager']['is_admin']
					)
				);
				
				if($this->Manager->save($manager)) {
					//found and saved the user as a manager on the spot
					$this->Session->setFlash('Manager Has Been Added to Spot.', 'alert-success');
					$this->redirect(array('controller' => 'spots', 'action'=>'view', $spot_id, 'admin' => false));
				} else {
					//failed to save the manager but the user was found
					$this->Session->setFlash('Manager Could Not Be Saved.', 'alert-warning');
				}
			} else {
				//couldn't find the user
				$this->Session->setFlash('Invalid Email.  No User Found.', 'alert-warning');
			}
		}
		$spot = $this->Manager->Spot->findById($spot_id);
		$this->set(compact('spot'));
		
	}

	public function by_spot($spot_id=null) {
		$this->Manager->Spot->id = $spot_id;
		if(!$this->Manager->Spot->exists()) {
			throw new NotFoundException('Invalid spot');
		}
		if (!$this->Manager->isAdmin() && !$this->Auth->user('is_super_admin')) {
			throw new NotFoundException('You do not have permission to this.');
		}
		$spot = $this->Manager->Spot->findById($spot_id);
		$managers = $this->Manager->getManagersBySpotId($spot_id, array('User'));
		$this->set(compact('managers', 'spot'));
	}
	
	public function delete($id = null, $spot_id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Manager->id = $id;
		if (!$this->Manager->exists()) {
			throw new NotFoundException(__('Invalid manager'));
		}
		$this->Manager->Spot->id = $spot_id;
		if (!$this->Manager->Spot->exists()) {
			throw new NotFoundException(__('Invalid spot'));
		}
		if ($this->Manager->delete()) {
			$this->Session->setFlash('Manager deleted', 'alert-success'); 
			$this->redirect(array('action' => 'by_spot', $spot_id));
		}
		$this->Session->setFlash('Manager was not deleted', 'alert-warning');
		$this->redirect(array('action' => 'by_spot', $spot_id));
	}

}
