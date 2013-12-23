<?php

class HomeController extends AppController
{
    var $name = 'Home';
    var $uses = array();

	public function index() {
	    $this->set('title_for_layout', 'Welcome to UNLOKT');
	    if (!$this->Auth->user()) {
	        $this->render('error');
	    }
	}

}

?>