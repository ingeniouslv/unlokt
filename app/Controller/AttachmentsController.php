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
	public function add() {
		if ($this->request->is('post')) {
			$this->Attachment->create();
			// If we don't have a Spot ID then we can assume this user only manages 1 spot.
			if (!isset($this->request->data['Attachment']['spot_id'])) {
				$array_keys = array_keys($this->viewVars['spots_i_manage']);
				$this->request->data['Attachment']['spot_id'] = $array_keys[0];
			}
			// Verify that the current User has permission to post to this Spot.
			$this->Attachment->Spot->id = $this->request->data['Attachment']['spot_id'];
			if (!$this->Attachment->Spot->Manager->isManager()) {
				throw new NotFoundException('You do not have permission to do this.');
			}
			
			// Check if there is a file being uploaded.
			if (isset($this->request->data['Attachment']['file']) && is_array($this->request->data['Attachment']['file']) && count($this->request->data['Attachment']['file'])) {
				foreach ($this->request->data['Attachment']['file'] as $file) {
					// If there exists and error and it's not = 4 (no upload - normal)
					if ($file['error'] && $file['error'] != 4) {
						$this->Attachment->invalidate('file', 'There was an error with your upload.');
					}
				}
			}
			// Now that we've saved the Feed, check if we have files to save.
			if (isset($this->request->data['Attachment']['file']) && is_array($this->request->data['Attachment']['file']) && count($this->request->data['Attachment']['file'])) {
				foreach ($this->request->data['Attachment']['file'] as $file) {
					// If there exists and error and it's not = 4 (no upload - normal)
					if (substr($file['type'], 0, 6) == 'image/') {
						$this->Attachment->create(false);
						// Make this attachment belong to something ...  set the feed ID.
						$this->Attachment->set(array(
							'spot_id' => $this->request->data['Attachment']['spot_id'],
							'mime' => $file['type'],
							'type' => 'image',
							'name' => $file['name']
						));
						if ($this->Attachment->save()) {
							// Finally, save the image by performing a convert() on it.
							convert($file['tmp_name'], store_path('attachment', $this->Attachment->id, 'default.jpg'));
						} else {
							// Oh well, there's not a lot we can do right now with this un-saved attachment :(
						}
					}
				}
			} // end of checking for files to save
			$this->Session->setFlash('The attachment has been saved', 'alert-success');
			$this->redirect($this->request->referer() ? $this->request->referer() : $this->webroot);
		}
	}
	
	public function index($spot_id) {
		if(!$spot = $this->Attachment->Spot->read(null, $spot_id)) {
			throw new NotFoundException('Invalid Spot ID');
		}
		
		$attachments = $this->Attachment->findAllBySpotId($spot_id);
		$spot = $this->Attachment->Spot->findById($spot_id);
		
		$this->set(compact('attachments', 'spot'));
	}
	
	public function delete($id) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Attachment->id = $id;
		if (!$attachment = $this->Attachment->read(null, $id)) {
			throw new NotFoundException(__('Invalid attachment'));
		}
		
		
		$this->Attachment->Spot->id = $attachment['Attachment']['spot_id'];
		if (!$this->Attachment->Spot->Manager->isManager()) {
			throw new NotFoundException('You do not have permission to do this.');
		}
		
		if ($this->Attachment->delete()) {
			$this->Session->setFlash('Attachment deleted', 'alert-success');
			$this->redirect(array('action' => 'index', $attachment['Attachment']['spot_id']));
		}
		$this->Session->setFlash('Attachment was not deleted', 'alert-error');
		$this->redirect(array('action' => 'index', $attachment['Attachment']['spot_id']));
	}
}