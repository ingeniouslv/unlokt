<?php
App::uses('AppController', 'Controller');
/**
 * SpotOptions Controller
 *
 * @property SpotOption $SpotOption
 */
class SpotOptionsController extends AppController {

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->SpotOption->recursive = 0;
		$this->set('spotOptions', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->SpotOption->id = $id;
		if (!$this->SpotOption->exists()) {
			throw new NotFoundException(__('Invalid spot option'));
		}
		$this->set('spotOption', $this->SpotOption->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->SpotOption->create();
			if ($this->SpotOption->save($this->request->data)) {
				$this->Session->setFlash('The spot option has been saved', 'alert-success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The spot option could not be saved. Please, try again.', 'alert-warning');
			}
		}
		$spots = $this->SpotOption->Spot->find('list', array('order' => array('Spot.name')));
		$this->set(compact('spots'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->SpotOption->id = $id;
		if (!$this->SpotOption->exists()) {
			throw new NotFoundException(__('Invalid spot option'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SpotOption->save($this->request->data)) {
				$this->Session->setFlash('The spot option has been saved', 'alert-success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The spot option could not be saved. Please, try again.', 'alert-warning');
			}
		} else {
			$this->request->data = $this->SpotOption->read(null, $id);
		}
		$spots = $this->SpotOption->Spot->find('list', array('order' => array('Spot.name')));
		$this->set(compact('spots'));
	}

/**
 * admin_delete method
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
		$this->SpotOption->id = $id;
		if (!$this->SpotOption->exists()) {
			throw new NotFoundException(__('Invalid spot option'));
		}
		if ($this->SpotOption->delete()) {
			$this->Session->setFlash('Spot option deleted', 'alert-success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Spot option was not deleted', 'alert-warning');
		$this->redirect(array('action' => 'index'));
	}
}
