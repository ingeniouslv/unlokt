<?php
App::uses('AppController', 'Controller');
/**
 * HoursOfOperations Controller
 *
 * @property HoursOfOperation $HoursOfOperation
 */
class HoursOfOperationsController extends AppController {
	
	public function beforeFilter() {
		$this->Auth->allow(array());
		parent::beforeFilter();
	}
	
	public function manage($spot_id=null) {
		$this->HoursOfOperation->Spot->id = $spot_id;
		if(!$this->HoursOfOperation->Spot->exists()) {
			throw new NotFoundException(__('Invalid spot'));
		}
		
		if (!$this->HoursOfOperation->Spot->Manager->isManager() && !$this->Auth->user('is_super_admin')) {
			throw new NotFoundException('You do not have permission to this.');
		}
		
		$hours_of_operations = $this->HoursOfOperation->find('all', array('conditions' => array('HoursOfOperation.spot_id' => $spot_id)));
		$spot = $this->HoursOfOperation->Spot->findById($spot_id);
		$this->set(compact('hours_of_operations', 'spot'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->HoursOfOperation->id = $id;
		if (!$this->HoursOfOperation->exists()) {
			throw new NotFoundException(__('Invalid hours of operation'));
		}
		$this->set('hoursOfOperation', $this->HoursOfOperation->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add($spot_id = null) {
		$spot_id = (empty($spot_id))?$this->request->spot_id:$spot_id;
		
		
		if(!$spot = $this->HoursOfOperation->Spot->read(null, $spot_id)) {
			throw new NotFoundException(__('Invalid spot'));
		}
		
		if (!$this->HoursOfOperation->Spot->Manager->isManager() && !$this->Auth->user('is_super_admin')) {
			throw new NotFoundException('You do not have permission to this.');
		}
		
		if ($this->request->is('post')) {
			//debug($this->request->data);
			
			$hours_of_operation = array('HoursOfOperation' => array(
				'spot_id' => $this->request->data['HoursOfOperation']['spot_id'],
				'open_time' => $this->request->data['HoursOfOperation']['open_time'],
				'close_time' => $this->request->data['HoursOfOperation']['close_time'],
				'is_closed' => $this->request->data['HoursOfOperation']['is_closed'],
				'short_string' => ''
			));
			$dow = array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat');
			$dow_full = array('sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday');
			$hours_of_operation['HoursOfOperation']['short_string'] = $hours_of_operation['HoursOfOperation']['is_closed']?'Closed ':'';
			$d = $this->request->data['HoursOfOperation']['start_day'];
			if($d != $this->request->data['HoursOfOperation']['end_day']) {
				$hours_of_operation['HoursOfOperation']['short_string'] .= $dow[$d]. " - "; 
				while($d != $this->request->data['HoursOfOperation']['end_day']) {
					$hours_of_operation['HoursOfOperation'][$dow_full[$d]] = true;
					($d == 6)?$d=0:$d++;	
				} 
			}
			$hours_of_operation['HoursOfOperation'][$dow_full[$d]] = true;
			$open_time = date('g:i a', strtotime($hours_of_operation['HoursOfOperation']['open_time']));
			$end_time = date('g:i a', strtotime($hours_of_operation['HoursOfOperation']['close_time']));
			
			$hours_of_operation['HoursOfOperation']['short_string'] .= $dow[$d];
			if(!$hours_of_operation['HoursOfOperation']['is_closed']) {
				$hours_of_operation['HoursOfOperation']['short_string'] .= ' '.$open_time.' to ' .$end_time;
			}
			
			// debug($hours_of_operation);
			// die();
			// do {
				// $this->request->data['HoursOfOperation']['start_day']
			// } while($i)
			// for($i = $this->request->data['HoursOfOperation']['start_day'])
			// die();
			$this->HoursOfOperation->create();
			if ($this->HoursOfOperation->save($hours_of_operation)) {
				$this->Session->setFlash('The hours of operation has been saved', 'alert-success');
				$this->redirect(array('action' => 'manage', $this->HoursOfOperation->Spot->id));
			} else {
				$this->Session->setFlash('The hours of operation could not be saved. Please, try again.', 'alert-warning');
			}
		}
		$spot = $this->HoursOfOperation->Spot->findById($spot_id);
		$this->set(compact('spot'));
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
		$this->HoursOfOperation->id = $id;
		if (!$this->HoursOfOperation->exists()) {
			throw new NotFoundException(__('Invalid hours of operation'));
		}
		$hours_of_operation = $this->HoursOfOperation->findById($id);
		$this->HoursOfOperation->Spot->id = $hours_of_operation['HoursOfOperation']['spot_id'];
		if (!$this->HoursOfOperation->Spot->Manager->isManager() && !$this->Auth->user('is_super_admin')) {
			throw new NotFoundException('You do not have permission to this.');
		}
		
		if ($this->HoursOfOperation->delete()) {
			$this->Session->setFlash('Hours of operation deleted', 'alert-success');
			$this->redirect(array('action' => 'manage', $hours_of_operation['HoursOfOperation']['spot_id']));
		}
		$this->Session->setFlash('Hours of operation was not deleted', 'alert-error');
		$this->redirect(array('action' => 'manage', $hours_of_operation['HoursOfOperation']['spot_id']));
	}
}
