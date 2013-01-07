<?php
App::uses('AppController', 'Controller');
/**
 * HappyHours Controller
 *
 * @property HappyHour $HappyHour
 */
class HappyHoursController extends AppController {

	public function beforeFilter() {
		$this->Auth->allow(array());
		parent::beforeFilter();
	}

/**
 * index method
 *
 * @return void
 */
	public function _index() {
		// Redirect user to the 'manage' method.
		$this->redirect(array('action' => 'manage'));
		return;
		$this->HappyHour->recursive = 0;
		$this->set('happyHours', $this->paginate());
	}
	
	// manage() allows Spot Admins 
	public function manage($spot_id = null) {
		if (!$spot_id) {
			throw new NotFoundException('Spot ID Required');
		}
		$spot = $this->HappyHour->Spot->getSpot($spot_id);
		if (!isset($spot['Manager'][0]) && !$this->Auth->user('is_super_admin')) {
			throw new NotFoundException('You do not have permission to manage this Spot');
		}
		$happyHours = $this->HappyHour->getHappyHourParents($spot_id);
		
		$this->set(compact('happyHours', 'spot'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function _view($id = null) {
		$this->HappyHour->id = $id;
		if (!$this->HappyHour->exists()) {
			throw new NotFoundException(__('Invalid happy hour'));
		}
		$this->set('happyHour', $this->HappyHour->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($spot_id) {
		if (!$spot_id) {
			throw new NotFoundException('Spot ID Required');
		}
		$spot = $this->HappyHour->Spot->getSpot($spot_id);
		if (!isset($spot['Manager'][0]) && !$this->Auth->user('is_super_admin')) {
			throw new NotFoundException('You do not have permission to manage this Spot');
		}
		// If the user is submitting HappyHour data, then check and parse and stuff.
		if ($this->request->is('post')) {
			//change given times to military time
			$this->request->data['HappyHour']['start'] = date('H:i', strtotime($this->request->data['HappyHour']['start']));
			$this->request->data['HappyHour']['end'] = date('H:i', strtotime($this->request->data['HappyHour']['end']));
			$this->request->data['HappyHour']['spot_id'] = $spot_id;
			$this->HappyHour->create();
			$this->HappyHour->set($this->request->data);
			if ($this->HappyHour->save($this->request->data)) {
				// We saved the parent happy hour ... now make child records.
				$parent_happy_hour_id = $this->HappyHour->id;
				// Check if the HappyHour extends to the next day
				if ($this->request->data['HappyHour']['start'] > $this->request->data['HappyHour']['end']) {
					// Create two child records because the HappyHour extends into the next day.
					// Reset the HappyHour object so we don't accidentally overwrite the old parent HappyHour.
					$this->HappyHour->create(false);
					$this->HappyHour->set($this->request->data);
					$this->HappyHour->set(array('end' => '23:59:59', 'parent_happy_hour_id' => $parent_happy_hour_id));
					$this->HappyHour->save();
					// Reset the HappyHour object so we don't accidentally overwrite the previous HappyHour sibling.
					$this->HappyHour->create(false);
					$this->HappyHour->set($this->request->data);
					$this->HappyHour->set(array('start' => '00:00:00', 'parent_happy_hour_id' => $parent_happy_hour_id, 'day_of_week' => ($this->request->data['HappyHour']['day_of_week'] + 1)%7));
					$this->HappyHour->save();
				} else {
					// Create one child record because the HappyHour falls within a single day.
					// Reset the HappyHour object so we don't accidentally overwrite the old parent HappyHour.
					$this->HappyHour->create($this->request->data);
					$this->HappyHour->set('parent_happy_hour_id', $parent_happy_hour_id);
					$this->HappyHour->save();
				}
				
				$this->Session->setFlash('The happy hour has been saved', 'alert-success');
				$this->redirect(array('action' => 'manage', $spot_id));
			} else {
				$this->Session->setFlash('The happy hour could not be saved. Please, try again.', 'alert-warning');
			}
		}
		$this->set(compact('spot'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function _edit($id = null) {
		$this->HappyHour->id = $id;
		if (!$this->HappyHour->exists()) {
			throw new NotFoundException(__('Invalid happy hour'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->HappyHour->save($this->request->data)) {
				$this->Session->setFlash('The happy hour has been saved', 'alert-success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The happy hour could not be saved. Please, try again.', 'alert-warning');
			}
		} else {
			$this->request->data = $this->HappyHour->read(null, $id);
		}
		$spots = $this->HappyHour->Spot->find('list');
		$parentHappyHours = $this->HappyHour->ParentHappyHour->find('list');
		$this->set(compact('spots', 'parentHappyHours'));
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
		$this->HappyHour->id = $id;
		if (!$happy_hour = $this->HappyHour->read(null, $id)) {
			throw new NotFoundException(__('Invalid happy hour'));
		}
		if (!$spot = $this->HappyHour->Spot->getSpot($happy_hour['HappyHour']['spot_id'])) {
			throw new NotFoundException('Spot not found');
		}
		if (!$spot['Manager'][0]) {
			throw new NotFoundException('You do not have permission to manage this Spot');
		}
		if ($this->HappyHour->delete()) {
			$this->Session->setFlash('Happy hour deleted', 'alert-success');
			$this->redirect(array('action' => 'manage', $spot['Spot']['id']));
		}
		$this->Session->setFlash('Happy hour was not deleted', 'alert-error');
		$this->redirect(array('action' => 'manage', $spot['Spot']['id']));
	}
}
