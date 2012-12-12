<?php
App::uses('AppController', 'Controller');


class AttachmentsController extends AppController {
	public function beforeFilter() {
		//$this->Auth->allow(array('gallery'));
		$this->Auth->allow(array());
		parent::beforeFilter();
	}
	public function gallery($spot_id = null) {
		$this->autoRender = false;
		if (!$spot_id) {
			throw new NotFoundException('Spot ID Required');
		}
		$this->Attachment->Spot->id = $spot_id;
		$attachments = $this->Attachment->getGallery();
		echo json_encode($attachments);
	}
}