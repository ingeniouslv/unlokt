<?php
App::uses('AppModel', 'Model');
/**
 * SpotFollower Model
 *
 * @property User $User
 * @property Spot $Spot
 */
class SpotFollower extends AppModel {


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
	
	public function getSpotListByUser($user_id = null) {
		$user_id = $user_id ? $user_id : CakeSession::read('Auth.User.id');
		$joins = array(
			array(
				'table' => 'spot_followers',
				'alias' => 'SpotFollower',
				'type' => 'INNER',
				'conditions' => array(
					'SpotFollower.spot_id = Spot.id',
					'SpotFollower.user_id' => $user_id
				)
			)
		);
		$spotList = $this->Spot->find('list', array('joins' => $joins));
		return $spotList;
	} // end of getSpotListByUser()
	
	public function deleteAll($conditions, $cascade = true, $callbacks = false) {
		$result = parent::deleteAll($conditions, $cascade, $callbacks);
		$this->clear_cache();
		return $result;
	}
}
