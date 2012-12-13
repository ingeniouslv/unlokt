<?php
App::uses('AppModel', 'Model');

class Deal extends AppModel {

	public $displayField = 'name';
	
	public $limit = 10;
	public $order = 'Deal.created DESC';

	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'description' => array(
			'notempty' => array(
				'rule' => array('notempty'),
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
		'start_date' => array(
			'datetime' => array(
				'rule' => array('date', 'ymd'),
				'message' => 'Start Date is Required.',
				'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'end_date' => array(
			'datetime' => array(
				'rule' => array('date', 'ymd'),
				'message' => 'End Date is Required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'start_time' => array(
			'datetime' => array(
				'rule' => array('time'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'end_time' => array(
			'datetime' => array(
				'rule' => array('time'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_active' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'is_public' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'keys' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'limit_per_customer' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'views' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'redemptions' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'completions' => array(
			'numeric' => array(
				'rule' => array('numeric'),
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
		'RedemptionCode' => array(
			'className' => 'RedemptionCode',
			'foreignKey' => 'deal_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'ActiveDeal' => array(
			'className' => 'ActiveDeal',
			'foreignKey' => 'deal_id',
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


/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'ActiveDeal' => array(
			'className' => 'ActiveDeal',
			'joinTable' => 'active_deals',
			'foreignKey' => 'deal_id',
			'associationForeignKey' => 'deal_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);
	
	public function getDeal($id = null, $contain = array()) {
		$id = $id ? $id : $this->id;
		$this->Behaviors->attach('Containable');
		return $this->find('first', array(
			'conditions' => array(
				'Deal.id' => $id
			),
			'contain' => $contain
		));
	}

	public function getDealFeed($quantity = 3) {
		$this->Behaviors->attach('Containable');
		$this->find('all', array(
			'conditions' => array(),
			'contain' => array(
				'Spot'
			),
			'limit' => $quantity
		));
	}
	
	public function getDealsBySpotIds($ids, $contain = array(), $skipTheseIds = array()) {
		$this->Behaviors->attach('Containable');
		
		$conditions = array(
			'Deal.spot_id' => $ids,
			'Deal.is_active' => 1,
			'Deal.is_public' => 1
		);
		
		//print_r($conditions);
		if (count($skipTheseIds)) {
			$conditions['Deal.id NOT'] = $skipTheseIds;
		}
		return $this->find('all', array(
			'conditions' => $conditions,
			'limit' => $this->limit,
			'order' => 'Deal.created DESC',
			'contain' => $contain
		));
	}
	
	/*
	 * Used by the Search on the Home Page
	 */
	public function getDealBySpotIds($ids, $contain = array(), $skipTheseIds = array()) {
		$this->Behaviors->attach('Containable');
		
		$current_start_date = isset($this->current_start_date) ? $this->current_start_date : date('Y-m-d');
		$current_end_date = isset($this->current_end_date) ? $this->current_end_date : date('Y-m-d');
		$current_start_time = isset($this->current_start_time) ? $this->current_start_time : date('H:i');
		$current_end_time = isset($this->current_end_time) ? $this->current_end_time : date('H:i', strtotime('+3 hour'));
		$cdow = isset($this->current_day_of_week) ? $this->current_day_of_week : array(date('l') => 1);
		$current_day_of_week = array();
		$i = 0;
		foreach($cdow as $key=>$val) {
			$current_day_of_week[] = array(
				$key=>$val,
				'? BETWEEN Deal.start_date AND Deal.end_date' => array(
					date(
						'Y-m-d',
						strtotime($current_start_date . " +" . $i . " days")
					)
				)
			);
			$i ++;
		}
		
		$conditions = array(
			'Deal.spot_id' => $ids,
			'Deal.is_active' => 1,
			'Deal.is_public' => 1,
			'Deal.start_date <=' => $current_end_date,
			'Deal.end_date >=' => $current_start_date,
			'Deal.start_time <=' => $current_end_time,
			'Deal.end_time >' => $current_start_time,
			'OR' => $current_day_of_week
		);
		if(!empty($this->events_only)) $conditions['Deal.keys'] = 0;
		
		//print_r($conditions);
		if (count($skipTheseIds)) {
			$conditions['Deal.id NOT'] = $skipTheseIds;
		}
		return $this->find('all', array(
			'conditions' => $conditions,
			'limit' => $this->limit,
			'order' => 'Deal.created DESC',
			'contain' => $contain
		));
	}

	public function getActiveDealsByUserId($user_id = null) {
		if(!$user_id)$user_id = $this->Auth->user('id');
		
		$joins = array(
			array(
				'table' => 'active_deals',
				'alias' => 'ActiveDeal',
				'type' => 'INNER',
				'conditions' => array(
					'Deal.id = ActiveDeal.deal_id',
					'ActiveDeal.user_id' => $user_id
				)
			)
		);
		
		return $this->find('all', array('joins' => $joins));
	}
	

}
