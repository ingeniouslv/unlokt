<?php
App::uses('AppModel', 'Model');

class Manager extends AppModel {
	
	public $belongsTo = array(
		'Spot' => array(
			'className' => 'Spot',
			'foreignKey' => 'spot_id',
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
	
	public function isManager() {
		if (!$user_id = CakeSession::read('Auth.User.id')) {
			return false;
		}
		$spot_id = $this->Spot->id ? $this->Spot->id : 0;
		if (!$spot_id) {
			throw new NotFoundException('Expecting ID on current object.');
		}
		return (bool) $this->find('first', array(
			'conditions' => array(
				'user_id' => $user_id,
				'spot_id' => $spot_id
			),
			'fields' => array('id')
		));
	} // end of isManager()
	
	public function isAdmin() {
		if (!$user_id = CakeSession::read('Auth.User.id')) {
			return false;
		}
		$spot_id = $this->id ? $this->id : $this->Spot->id;
		if (!$spot_id) {
			throw new NotFoundException('Expecting ID on current object.');
		}
		return (bool) $this->find('first', array(
			'conditions' => array(
				'user_id' => $user_id,
				'spot_id' => $spot_id,
				'is_admin' => 1
			),
			'fields' => array('id')
		));
	} // end of isAdmin()
	
	public function getSpotListByAdmin($user_id = null) {
		$user_id = $user_id ? $user_id : CakeSession::read('Auth.User.id');
		$query = "SELECT `Spot`.`name`, `Spot`.`id` FROM `spots` as `Spot`
		LEFT JOIN `managers` as `Manager` ON `Spot`.`id` = `Manager`.`spot_id`
		WHERE `Manager`.`is_admin` = 1 AND `Manager`.`user_id` = $user_id";
		$results = $this->query($query);
		$retval = array();
		foreach ($results as $result) {
			$retval["{$result['Spot']['id']}"] = $result['Spot']['name'];
		}
		return $retval;
	} // end of getSpotListByAdmin()
	
	public function getSpotListByManager($user_id = null) {
		$user_id = $user_id ? $user_id : CakeSession::read('Auth.User.id');
		$query = "SELECT `Spot`.`name`, `Spot`.`id` FROM `spots` as `Spot`
		LEFT JOIN `managers` as `Manager` ON `Spot`.`id` = `Manager`.`spot_id`
		WHERE `Manager`.`user_id` = $user_id";
		$results = $this->query($query);
		$retval = array();
		foreach ($results as $result) {
			$retval["{$result['Spot']['id']}"] = $result['Spot']['name'];
		}
		return $retval;
	} // end of getSpotListByManager()
	
	public function getManagersBySpotId($spot_id = null, $contain = array()) {
		$spot_id = $spot_id ? $spot_id : $this->spot_id;
		if (!$spot_id) {
			throw new NotFoundException('Expecting Spot ID');
		}
		$this->Behaviors->attach('Containable');
		return $this->find('all', array(
			'conditions' => array(
				'Manager.spot_id' => $spot_id
			),
			'contain' => $contain
		));
	}
	
}