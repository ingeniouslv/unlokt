<?php
App::uses('AppModel', 'Model');
/**
 * Feed Model
 *
 * @property Spot $Spot
 * @property Attachment $Attachment
 */
class Feed extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'spot_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'feed' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Feed required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

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
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Attachment' => array(
			'className' => 'Attachment',
			'foreignKey' => 'feed_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);
	
	public function getFeedBySpotIds($ids, $contain = array()) {
		$this->Behaviors->attach('Containable');
		return $this->find('all', array(
			'conditions' => array(
				'Feed.spot_id' => $ids
			),
			'limit' => $this->limit,
			'order' => 'Feed.created DESC',
			'contain' => $contain
		));
	}

}
