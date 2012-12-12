<?php

class PublicPage extends AppModel {
	
	/*
	 * returns true if the $controller and $action are public; returns false if the $controller and $action are not
	 */
	public function isPublicPage($controller, $action) {
		$this->cache = true;
		$public_page = $this->find('first', array(
			'conditions' => array(
				'controller' => $controller,
				'action' => $action
			),
			'fields' => 'public'
		));
		if (isset($public_page['PublicPage']['public']) && $public_page['PublicPage']['public']) {
			return true;
		} else {
			return false;
		}
	} // end of isPublicPage();
	
} // end of class