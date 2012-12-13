<?php
App::uses('AppModel', 'Model');
/**
 * Review Model
 *
 * @property User $User
 * @property Spot $Spot
 */
class Review extends AppModel {
	
	public $limit = 10;

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Name required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'review' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Review required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'stars' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Stars requied',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'ip' => array(
			'notempty' => array(
				'rule' => array('ip'),
				'message' => 'IP required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Spot' => array(
			'className' => 'Spot',
			'foreignKey' => 'spot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public function getReviewBySpotIds($ids, $contain = array()) {
		$this->Behaviors->attach('Containable');
		return $this->find('all', array(
			'conditions' => array(
				'Review.spot_id' => $ids
			),
			'limit' => $this->limit,
			'order' => 'Review.created DESC',
			'contain' => $contain
		));
	}
	
	public function getReviewByUserId($ids, $contain = array()) {
		$this->Behaviors->attach('Containable');
		return $this->find('all', array(
			'conditions' => array(
				'Review.user_id' => $ids
			),
			'limit' => $this->limit,
			'order' => 'Review.created DESC',
			'contain' => $contain
		));
		
	}
}
