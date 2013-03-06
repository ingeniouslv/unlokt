<?php
App::uses('AppModel', 'Model');
/**
 * HappyHour Model
 *
 * @property Spot $Spot
 * @property ParentHappyHour $ParentHappyHour
 */
class HappyHour extends AppModel {
	
	public $order = 'day_of_week ASC';

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
		'start' => array(
			'time' => array(
				'rule' => array('time'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'end' => array(
			'time' => array(
				'rule' => array('time'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'day_of_week' => array(
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
		),
		'ParentHappyHour' => array(
			'className' => 'HappyHour',
			'foreignKey' => 'parent_happy_hour_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $hasMany = array(
		'ChildHappyHour' => array(
			'className' => 'HappyHour',
			'foreignKey' => 'parent_happy_hour_id',
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
	
	public function getHappyHourParents($spot_id = null, $contain = array()) {
		$spot_id = $spot_id ? $spot_id : $this->Spot->id;
		$this->Behaviors->attach('Containable');
		return $this->find('all', array(
			'conditions' => array(
				'HappyHour.parent_happy_hour_id' => null,
				'HappyHour.spot_id' => $spot_id
			),
			'contain' => $contain,
			'orderBy' => array('HappyHour.day_of_week')
		));
	}
	
	public function getCurrentHappyHourBySpot($ids, $contain = array()) {
		if (!is_array($ids) && !is_numeric($ids)) {
			throw new MethodNotAllowedException('Expecting array or integer for $ids');
		}
		$current_day_of_week = isset($this->current_day_of_week) ? $this->current_day_of_week : date('w');
		$current_start_time = isset($this->current_start_time) ? $this->current_start_time : date('H:i');
		$current_end_time = isset($this->current_end_time) ? $this->current_end_time : date('H:i', strtotime("+3 hour"));
		$current_time = isset($this->current_time) ? $this->current_time : date('H:i');
		$conditions = array(
			'HappyHour.spot_id' => $ids,
			'HappyHour.day_of_week' => $current_day_of_week,
			'HappyHour.start <=' => $current_end_time,
			'HappyHour.end >' => $current_start_time,
			'HappyHour.parent_happy_hour_id NOT' => null		
		);
		
		$this->Behaviors->attach('Containable');
		return $this->find('all', array(
			'conditions' => $conditions,
			'contain' => $contain
		));
	}

	public function getCurrentHappyHourParentsBySpot($ids, $contain = array()) {
		if (!is_array($ids) && !is_numeric($ids)) {
			throw new MethodNotAllowedException('Expecting array or integer for $ids');
		}
		$current_day_of_week = isset($this->current_day_of_week) ? $this->current_day_of_week : date('w');
		$current_start_time = isset($this->current_start_time) ? $this->current_start_time : date('H:i');
		$current_end_time = isset($this->current_end_time) ? $this->current_end_time : date('H:i', strtotime("+3 hour"));
		$current_time = isset($this->current_time) ? $this->current_time : date('H:i');
		$conditions = array(
			'HappyHour.spot_id' => $ids,
			'HappyHour.day_of_week' => $current_day_of_week,
			'HappyHour.start <=' => $current_end_time,
			'HappyHour.end >' => $current_start_time,
			'HappyHour.parent_happy_hour_id' => null		
		);
		
		$this->Behaviors->attach('Containable');
		return $this->find('all', array(
			'conditions' => $conditions,
			'contain' => $contain
		));
	}
	
}
