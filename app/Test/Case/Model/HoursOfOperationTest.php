<?php
App::uses('HoursOfOperation', 'Model');

/**
 * HoursOfOperation Test Case
 *
 */
class HoursOfOperationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.hours_of_operation',
		'app.spot',
		'app.location',
		'app.plan',
		'app.attachment',
		'app.feed',
		'app.user',
		'app.active_deal',
		'app.deal',
		'app.redemption_code',
		'app.manager',
		'app.password_reset',
		'app.review',
		'app.spot_follower',
		'app.happy_hour',
		'app.payment',
		'app.category',
		'app.categories_spot',
		'app.spot_option',
		'app.spot_options_spot'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->HoursOfOperation = ClassRegistry::init('HoursOfOperation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->HoursOfOperation);

		parent::tearDown();
	}

}
