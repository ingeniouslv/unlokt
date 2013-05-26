<?php
App::uses('AppModel', 'Model');
/**
 * Like Model
 * 
 * Used for Endorse and plans of using for 'Love It' for deals
 *
 * Type_IDs:
 * Spot = 1
 * Deal = 2
 * HappyHour = 3
 * 
 * $like['target_id'] = SPOT/DEAL/HAPPYHOUR ID
 * $like['user_id'] = user_id
 * $like['type_id'] = Like::getTypeId("Spot");
 * 
 *
 */

class Like extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'target_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Target ID required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),

		'user_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'User ID required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		), 
		
		'type_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Type ID required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		)

		
	);
	
	
	public function getTypeId( $type = null ) {
		
		if (!$type) return false;

		switch (strtolower($type)) {
			
			case "spot":
				return 1;
				break;
				
			case "deal":
				return 2;
				break;
				
			case "happyhour":
				return 3;
				break;
			
			default:
				return false;
				break;
			
			
		}
		
		
	}	
	
	public function add( $data ) {
		
		$this->create();
		
		$saved = $this->save($data);
		
		if ($saved) {
			
			//increment the model count
			if ($data['Like']['type_id'] == 1) { //we have a spot
				
				//update the spot endorse count
				App::uses('Spot', 'Model');

				$spot = new Spot();
				$spot->updateEndorseCount( $data['Like']['target_id'] );
				
			}
				
		}
		
		return $saved;
		
		
	} //end ::add()
	
	
	public function remove( $data ) {
	 
		return $this->deleteAll(array(
						'Like.target_id' => $data['Like']['target_id'] , 
						'Like.type_id' => $data['Like']['type_id'] , 
						'Like.user_id' => $data['Like']['user_id'] 
							), false);
		
		$saved = $this->save($data);
		
		if ($saved) {
			
			//increment the model count
			if ($data['Like']['type_id'] == 1) { //we have a spot
				
				//update the spot endorse count
				App::uses('Spot', 'Model');

				$spot = new Spot();
				$spot->updateEndorseCount( $data['Like']['target_id'] );
				
			}
				
		}
		
		return $saved;
		
		
	} //end ::remove()
 
 
}
