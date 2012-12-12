<?php
App::uses('Feed', 'Model');

/**
 * Feed Test Case
 *
 */
class FeedTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.feed',
		'app.spot',
		'app.attachment',
		'app.user',
		'app.active_deal',
		'app.deal',
		'app.redemption_code',
		'app.manager',
		'app.password_reset',
		'app.review',
		'app.happy_hour',
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
		$this->Feed = ClassRegistry::init('Feed');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Feed);

		parent::tearDown();
	}

}
