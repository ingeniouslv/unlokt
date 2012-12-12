<?php
App::uses('AppController', 'Controller');
/**
 * Feeds Controller
 *
 * @property Feed $Feed
 */
class FeedsController extends AppController {

	public function beforeFilter() {
		//$this->Auth->allow(array('add', 'edit', 'index', 'delete'));
		$this->Auth->allow(array());
		parent::beforeFilter();
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Feed->recursive = 0;
		$this->set('feeds', $this->paginate());
	}

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Feed->recursive = 0;
		$this->set('feeds', $this->paginate());
		$this->set('_serialize', array('feeds'));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->Feed->id = $id;
		if (!$this->Feed->exists()) {
			throw new NotFoundException(__('Invalid feed'));
		}
		$this->set('feed', $this->Feed->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		// The list of available Spots for this method is being set in
		// AppController::beforeFilter() since the list needs to be available on all pages.
		if ($this->request->is('post')) {
			$this->Feed->create();
			// If we don't have a Spot ID then we can assume this user only manages 1 spot.
			if (!isset($this->request->data['Feed']['spot_id'])) {
				$array_keys = array_keys($this->viewVars['spots_i_manage']);
				$this->request->data['Feed']['spot_id'] = $array_keys[0];
			}
			// Verify that the current User has permission to post to this Spot.
			$this->Feed->Spot->id = $this->request->data['Feed']['spot_id'];
			if (!$this->Feed->Spot->Manager->isManager()) {
				throw new NotFoundException('You do not have permission to do this.');
			}
			$this->Feed->set($this->request->data);
			
			// Check if there is a file being uploaded.
			if (isset($this->request->data['Feed']['file']) && is_array($this->request->data['Feed']['file']) && count($this->request->data['Feed']['file'])) {
				foreach ($this->request->data['Feed']['file'] as $file) {
					// If there exists and error and it's not = 4 (no upload - normal)
					if ($file['error'] && $file['error'] != 4) {
						$this->Feed->invalidate('file', 'There was an error with your upload.');
					}
				}
			}
			
			if ($this->Feed->validates() && $this->Feed->save()) {
				// Now that we've saved the Feed, check if we have files to save.
				if (isset($this->request->data['Feed']['file']) && is_array($this->request->data['Feed']['file']) && count($this->request->data['Feed']['file'])) {
					foreach ($this->request->data['Feed']['file'] as $file) {
						// If there exists and error and it's not = 4 (no upload - normal)
						if (substr($file['type'], 0, 6) == 'image/') {
							$this->Feed->Attachment->create(false);
							// Make this attachment belong to something ...  set the feed ID.
							$this->Feed->Attachment->set(array(
								'feed_id' => $this->Feed->id,
								'spot_id' => $this->request->data['Feed']['spot_id'],
								'mime' => $file['type'],
								'type' => 'image',
								'name' => $file['name']
							));
							if ($this->Feed->Attachment->save()) {
								// Finally, save the image by performing a convert() on it.
								convert($file['tmp_name'], store_path('attachment', $this->Feed->Attachment->id, 'default.jpg'));
							} else {
								// Oh well, there's not a lot we can do right now with this un-saved attachment :(
							}
						}
					}
				} // end of checking for files to save
				$this->Session->setFlash('The feed has been saved', 'alert-success');
				$this->redirect($this->request->referer() ? $this->request->referer() : $this->webroot);
			} else {
				$this->Session->setFlash('The feed could not be saved. Please, try again.', 'alert-error');
			}
		}
		
		$this->set(compact('spots'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		die('asd');
		$this->Feed->id = $id;
		if (!$this->Feed->exists()) {
			throw new NotFoundException(__('Invalid feed'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Feed->save($this->request->data)) {
				$this->Session->setFlash(__('The feed has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The feed could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Feed->read(null, $id);
		}
		$spots = $this->Feed->Spot->find('list');
		$this->set(compact('spots'));
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
		if (!$this->request->is('post') && !$this->request->is('delete')) {
			die($this->request->method());
			throw new MethodNotAllowedException();
		}
		$this->Feed->id = $id;
		if (!$feed = $this->Feed->read(null, $id)) {
			throw new NotFoundException(__('Invalid feed'));
		}
		// Verify we have permission to delete this Feed
		$this->Feed->Spot->id = $feed['Feed']['spot_id'];
		if (!$this->Auth->user('is_super_admin') && !$this->Feed->Spot->Manager->isManager()) {
			throw new NotFoundException('You do not have permission to do this.');
		}
		if ($this->Feed->delete()) {
			if ($this->request->is('ajax')) {
				die();
			}
			$this->Session->setFlash(__('Feed deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Feed was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
