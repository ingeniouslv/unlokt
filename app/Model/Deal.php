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
	
	public function getActiveDealsByUserId($id = null, $contain) {
		if(empty($id)) $id=$this->Auth->user('id');
		$this->Behaviors->attach('Containable');
		$joins = array(
			array(
				'table' => 'active_deals',
				'alias' => 'ActiveDeal',
				'type' => 'INNER',
				'conditions' => array(
					'ActiveDeal.deal_id = Deal.id',
					'ActiveDeal.user_id' => $id
				)
			)
		);
		
		$deals = $this->find('all', 
			array(
				'joins' => $joins,
				'contain' => $contain,
				'group' => array('Deal.id'),
				'conditions' => array(
					'Deal.is_active' => 1
				)
			)
		);
		usort($deals, array('Deal', '_sortBySpotName'));
		return $deals;
	}
	
	private function _sortBySpotName($a, $b) {
		return strcmp($a['Spot']['name'], $b['Spot']['name']);
	}
	
	/*
	 * Used by the Search on the Home Page
	 */
	public function getDealBySpotIds($ids, $contain = array(), $skipTheseIds = array()) {
		$this->Behaviors->attach('Containable');
		
		//default start date to today
		$current_start_date = isset($this->current_start_date) ? $this->current_start_date : date('Y-m-d');
		//default end date to today
		$current_end_date = isset($this->current_end_date) ? $this->current_end_date : date('Y-m-d');
		//default start time to now
		$current_start_time = isset($this->current_start_time) ? $this->current_start_time : date('H:i');
		//default time to within 3 hours
		$current_end_time = isset($this->current_end_time) ? $this->current_end_time : date('H:i', strtotime('+3 hour'));
		//numerical representation of day of the week
		$cdow = isset($this->current_day_of_week) ? $this->current_day_of_week : array(date('l') => 1);
		$current_day_of_week = array();
		$i = 0;
		
		//check if given days are within a deal's start and end date.
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
			"UNIX_TIMESTAMP(concat(start_date, ' ', start_time)) <=" => strtotime($current_end_date . ' ' . $current_end_time),
			"UNIX_TIMESTAMP(concat(end_date, ' ', end_time)) >" => $current_start_date,
			'OR' => $current_day_of_week
		);
		//only want events
		if(!empty($this->events_only)) $conditions['Deal.keys'] = 0;
		//only want specials
		if(!empty($this->specials_only)) $conditions['Deal.keys'] = 1;
		//want rewards and specials
		if(!empty($this->rewards_and_specials_only)) $conditions['Deal.keys >'] = 0;
		//want events and specials
		if(!empty($this->events_and_specials_only)) $conditions['Deal.keys <'] = 2;
		//print_r($conditions);
		
		//allow skipping of specific ids (helps the search work by ignoring specific ids that still match to a desired spot)
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

	//sorts the deals alphabetically using either deal name or spot name (in case of happy hours)
	public function sortDeals($a, $b) {
		$val1 = array_key_exists('Deal',$a)?$a['Deal']['name']:$a['Spot']['name'];
		$val2 = array_key_exists('Deal',$b)?$b['Deal']['name']:$b['Spot']['name'];
		return strcmp($val1, $val2);
	}
	
	//sorts the deals alphabetically using either deal name or spot name (in case of happy hours)
	public function sortDealsBySpotViews($a, $b) {
		return $a['Spot']['views'] < $b['Spot']['views'];
	}
	
	//sorts the deals alphabetically using either deal name or spot name (in case of happy hours)
	public function sortDealsByRandomDelta($a, $b) {
		return $a['Spot']['random_delta'] > $b['Spot']['random_delta'];
	}
	

}
