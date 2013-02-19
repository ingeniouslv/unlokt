<?php
App::uses('AppModel', 'Model');
/**
 * Attachment Model
 *
 * @property Spot $Spot
 * @property Feed $Feed
 * @property User $User
 */
class Attachment extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';
	
	public $order = 'created DESC';


	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Spot' => array(
			'className' => 'Spot',
			'foreignKey' => 'spot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Feed' => array(
			'className' => 'Feed',
			'foreignKey' => 'feed_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function getAttachmentBySpotIds($ids, $contain = array()) {
		$this->Behaviors->attach('Containable');
		return $this->find('all', array(
			'conditions' => array(
				'Attachment.spot_id' => $ids
			),
			'limit' => 60,
			'order' => 'Attachment.created DESC',
			'contain' => $contain
		));
	}
	
	public function getGallery($spot_id = null) {
		$spot_id = $spot_id ? $spot_id : $this->Spot->id;
		if (!$spot_id) {
			throw new NotFoundException('Spot ID Required');
		}
		$results = $this->find('all', array(
			'conditions' => array(
				'spot_id' => $spot_id,
				'type' => 'image'
			),
			'order' => $this->order
		));
		$retval = array();
		foreach ($results as $result) {
			$retval[] = $result['Attachment']['id'];
		}
		return $retval;
	} // end of getGallery()
}
