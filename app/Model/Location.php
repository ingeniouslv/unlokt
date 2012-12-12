<?php
App::uses('AppModel', 'Model');

class Location extends AppModel {
	
	public $order = 'Location.name';
	
	public $hasMany = array(
		'Spot' => array(
			'className' => 'Spot',
			'foreignKey' => 'location_id',
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
	
	public function getGeolocation() {
		$geoCode = json_decode(file_get_contents("http://api.ipinfodb.com/v3/ip-city/?key=489616c03186904b5367bc8c32505e56568a7313a45f99104a1137ded14d4baa&format=json&ip={$_SERVER['REMOTE_ADDR']}"), true);
		$coords = array('lat' => $geoCode['latitude'], 'lng' => $geoCode['longitude']);
		return $coords;
	}
	
	
}