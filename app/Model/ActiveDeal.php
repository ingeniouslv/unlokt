<?php
App::uses('AppModel', 'Model');
/**
 * ActiveDeal Model
 *
 * @property Deal $Deal
 * @property User $User
 */
class ActiveDeal extends AppModel {
	
	public $order = 'ActiveDeal.created DESC';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'deal_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
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
		'completed_step' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_completed' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
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
		'Deal' => array(
			'className' => 'Deal',
			'foreignKey' => 'deal_id',
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
	
	//////////////////////////////////////////////////
	
	public function getActiveDealByDeal($id = null, $contain = array()) {
		$id = $id ? $id : $this->Deal->id;
		if (!$id) {
			throw new NotFoundException('Expecting DealID');
		}
		$this->Behaviors->attach('Containable');
		return $this->find('first', array(
			'conditions' => array(
				'ActiveDeal.id' => $id
			),
			'contain' => $contain
		));
	}
	
	//////////////////////////////////////////////////
	
	public function findCompletedCountByDealIdAndAndUserId($deal_id, $user_id) {
		return $this->find('count', array(
			'conditions' => array(
				'user_id' => $user_id,
				'deal_id' => $deal_id,
				'is_completed' => 1
			)
		));
	}
	
	//////////////////////////////////////////////////
	
	public function findCountByDealIdAndAndUserId($deal_id, $user_id) {
		return $this->find('count', array(
			'conditions' => array(
				'user_id' => $user_id,
				'deal_id' => $deal_id
			)
		));
	}
	
	//////////////////////////////////////////////////
}
