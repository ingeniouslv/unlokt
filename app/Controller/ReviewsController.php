<?php
App::uses('AppController', 'Controller');
/**
 * Reviews Controller
 *
 * @property Review $Review
 */
class ReviewsController extends AppController {

	public function beforeFilter() {
		$this->Auth->allow(array());
		parent::beforeFilter();
	}
	
/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Review->recursive = 0;
		$this->paginate = array(
			'order' => array(
				'name' => 'asc'
			),
			'conditions' => array('is_flagged' => false)
			);
		$flagged_reviews = $this->Review->find('first' , array('fields' => array('count(*) as flagged_review_count'), 'conditions' => array('is_flagged' => true), 'group' => array('is_flagged')));
		$flagged_review_count = empty($flagged_reviews)?0:$flagged_reviews[0]['flagged_review_count'];
		
		$reviews = $this->paginate();
		$this->set(compact('reviews', 'flagged_review_count'));
	}
	
/**
 * displays all flagged reviews
 *
 * @return void
 */
	public function admin_flagged_reviews() {
		$this->Review->recursive = 0;
		$this->paginate = array(
			'order' => array(
				'name' => 'asc'
			),
			'conditions' => array('is_flagged' => true)
		);
		$this->set('reviews', $this->paginate());
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Review->recursive = 0;
		$this->set('reviews', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Review->id = $id;
		if (!$this->Review->exists()) {
			throw new NotFoundException(__('Invalid review'));
		}
		$review = $this->Review->find('first', array('conditions' => array('Review.id' => $id), 'recursive' => 1));
		$this->set('review', $review);
	}

/**
 * add method
 *
 * @return void
 */
	public function add($spot_id = null) {
		if (!$spot_id) {
			throw new NotFoundException('Spot ID Required');
		}
		if (!$spot = $this->Review->Spot->read(null, $spot_id)) {
			throw new NotFoundException('Spot not found');
		}
		if ($this->request->is('post')) {
			// Create Review object with user_id and spot_id prepopulated.
			$this->Review->create(array(
				'user_id' => $this->Auth->user('id'),
				'spot_id' => $spot_id,
				'ip' => $_SERVER['REMOTE_ADDR']
			));
			if ($this->Review->save($this->request->data)) {
				// The review was saved successfully; update the metrics on the Spot itself.
				$this->Review->Spot->id = $spot_id;
				//$this->Review->Spot->add_rating($this->request->data['Review']['stars']);
				$this->Session->setFlash('The Review has been saved', 'alert-success');
				$this->redirect(array('controller' => 'spots', 'action' => 'view', $spot_id));
			} else {
				$this->Session->setFlash('The Review could not be saved. Please, try again.', 'alert-warning');
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
	public function edit($id = null) {
		$this->Review->id = $id;
		if (!$this->Review->exists()) {
			throw new NotFoundException(__('Invalid review'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Review->save($this->request->data)) {
				$this->Session->setFlash('The review has been saved', 'alert-success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The review could not be saved. Please, try again.', 'alert-warning');
			}
		} else {
			$this->request->data = $this->Review->read(null, $id);
		}
		$users = $this->Review->User->find('list');
		$spots = $this->Review->Spot->find('list');
		$this->set(compact('users', 'spots'));
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
		$this->autoRender = false;
		
		// Query for the Review, along with the User of the review.
		if (!$review = $this->Review->findContain($id, array('User', 'Spot' /*=> array('Manager' => array('conditions' => array('Manager.user_id' => $this->Auth->user('id'))))*/)
		)) {
			throw new NotFoundException('Cannot find Review');
		}
		
		// Check if the current user owns the review or we're an admin. Otherwise, deny access to delete.
		if ($review['User']['id'] != $this->Auth->user('id') && $this->Auth->user('group_id') != GROUP_ID_ADMIN && !$this->Auth->user('is_super_admin')) {
			throw new NotFoundException('Error - you do not have permission to do delete this Review.');
		}
		
		$spot_id = $review['Spot']['id'];
		$this->Review->id = $id;
		$this->Review->delete();
		if ($this->request->is('ajax')) {
			die('OK');
		}
		$this->redirect(array('controller' => 'spots', 'action' => 'view', $spot_id));
		// if (!$this->Review->exists()) {
			// throw new NotFoundException(__('Invalid review'));
		// }
		// if ($this->Review->delete()) {
			// $this->Session->setFlash(__('Review deleted'));
			// $this->redirect(array('action' => 'index'));
		// }
		// $this->Session->setFlash(__('Review was not deleted'));
		// $this->redirect(array('action' => 'index'));
	}

	/**
	 * Set the is_flagged to true for a given review.
	 */
	public function flag_review($id = null) {
		$this->Review->id = $id;
		if (!$this->Review->exists()) {
			throw new NotFoundException('Invalid review');
		}
		$this->Review->saveField('is_flagged', true);
		if ($this->request->is('ajax')) {
			die('Review Flagged');
		}
		$this->Session->setFlash('Review Flagged', 'alert-success');
		$this->redirect($this->referer());		
	}

	// Manage Reviews for a specified Spot
	public function reviews_by_spot($spot_id = null) {
		if (!$spot_id) {
			throw new NotFoundException('Spot ID required');
		}
		
		$this->Review->Behaviors->attach('Containable');
		$this->paginate = array(
			'order' => array(
				'Review.stars' => 'desc'
			),
			'conditions' => array(
				'Review.spot_id' => $spot_id
			), 
			'contain' => array(
				'User' => array(
					'fields' => array(
						'name'
					)
				)
			)
		);
		$reviews = $this->paginate();
		$spot = $this->Review->Spot->find('first', array('conditions' => array('id' => $spot_id), 'fields' => array('name','id')));
		
		$this->set(compact('reviews', 'spot'));
	}
}
