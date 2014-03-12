<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('AppController', 'Controller');
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 */
	public $name = 'Pages';

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Page');
	
	public function beforeFilter() {
 		//$this->Auth->allow(array('display', 'site_index', 'page'));
 		$this->Auth->allow(array('display', 'page', 'about'));
		parent::beforeFilter();
	}

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @return void
 */
	public function display() {
		$path = func_get_args();

		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
	
	public function about() {
		$this->layout = 'about';
	}
	
	public function site_index() {
		$this->loadModel('Spot');
		$this->loadModel('Location');
		$this->Spot->cache = true;
		// $feed = $this->Spot->getSpotFeed();
		$categories = $this->Spot->Category->getThreadedList();
		$parent_categories = $this->Spot->Category->getParentCategories();
		$geolocation = $this->Location->getGeolocation();
		$locations = $this->Location->find('all', array('conditions' => array('Location.is_active' => true)));
		
		$this->set(compact('feed', 'categories', 'parent_categories', 'locations', 'geolocation'));
		
	}

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Page->recursive = 0;
		$this->paginate = array(
			'order' => array(
				'title' => 'asc'
			),
		);
		$pages = $this->paginate();
		
		$this->set(compact('pages'));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Page->create();
			if ($this->Page->save($this->request->data)) {
				$this->Session->setFlash('The page has been saved', 'alert-success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The page could not be saved. Please, try again.', 'alert-error');
			}
		}
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException(__('Invalid page'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Page->save($this->request->data)) {
				$this->Session->setFlash('The page has been saved', 'alert-success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The page could not be saved. Please, try again.', 'alert-warning');
			}
		} else {
			$this->request->data = $this->Page->read(null, $id);
		}
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
		$this->Page->id = $id;
		if (!$this->Page->exists()) {
			throw new NotFoundException(__('Invalid page'));
		}
		if ($this->Page->delete()) {
			$this->Session->setFlash('Page deleted', 'alert-success');
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash('Page was not deleted', 'alert-error');
		$this->redirect(array('action' => 'index'));
	}
	
	/**
	 * All /pages/* traffic is being directed here.
	 * It attempts to grab the page based on the slug given.  If two slugs are the same, it doesn't error, but it will return
	 * the first record.  This could lead to unexpected behavior from a user perspective.  There is validation preventing multiple
	 * pages from having the same slug.
	 */
	public function page($slug = NULL) {
		if(!$slug || !$page = $this->Page->findBySlugAndIsPublished($slug, 1)) {
			throw new NotFoundException('Sorry Page Does Not Exist.');
		}
		$this->set(compact('page'));
		
	}
	
	public function api_page($slug = NULL) {
		if(!$slug || !$page = $this->Page->findBySlugAndIsPublished($slug, 1)) {
			ApiComponent::error(ApiErrors::$MISSING_REQUIRED_PARAMATERS);
		}
		ApiComponent::success(ApiSuccessMessages::$GENERIC_SUCESS, $page);
	}
}

