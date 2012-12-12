<?php
App::uses('Spot', 'Model');

/**
 * Spot Test Case
 *
 */
class SpotTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.spot',
		'app.deal',
		'app.spot_admin'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Spot = ClassRegistry::init('Spot');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Spot);

		parent::tearDown();
	}

}
