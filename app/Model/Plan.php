<?php
App::uses('AppModel', 'Model');
/**
 * Plan Model
 *
 * @property Spot $Spot
 */
class Plan extends AppModel {

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
		'months' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Months required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'trial_months' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Trial Months required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'price' => array(
			'numeric' => array(
				'rule' => array('decimal', 2),
				'message' => 'Price required (#.## format)'
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Spot' => array(
			'className' => 'Spot',
			'foreignKey' => 'plan_id',
			'dependent' => false,
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
	
	public function getPublicPlans() {
		return $this->find('all', array(
			'conditions' => array(
				'is_public' => 1
			)
		));
	}

	public function getPlanByCode($code) {
		// We are performing 'all' lookup because we want data returned to be in the same nested array format.
		return $this->find('all', array(
			'conditions' => array(
				'code' => $code
			),
			'limit' => 1
		));
	} // end of getPlanByCode()

}
