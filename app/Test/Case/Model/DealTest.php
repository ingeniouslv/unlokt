<?php
App::uses('Deal', 'Model');

/**
 * Deal Test Case
 *
 */
class DealTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.deal',
		'app.spot',
		'app.attachment',
		'app.feed',
		'app.user',
		'app.group',
		'app.active_deal',
		'app.manager',
		'app.password_reset',
		'app.review',
		'app.happy_hour',
		'app.category',
		'app.parent_category',
		'app.categories_spot',
		'app.spot_option',
		'app.spot_options_spot',
		'app.redemption_code',
		'app.active'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Deal = ClassRegistry::init('Deal');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Deal);

		parent::tearDown();
	}

}
