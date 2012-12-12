<?php
App::uses('ReviewsController', 'Controller');

/**
 * ReviewsController Test Case
 *
 */
class ReviewsControllerTest extends ControllerTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.review',
		'app.user',
		'app.group',
		'app.active_deal',
		'app.attachment',
		'app.spot',
		'app.deal',
		'app.redemption_code',
		'app.active',
		'app.feed',
		'app.happy_hour',
		'app.manager',
		'app.category',
		'app.parent_category',
		'app.categories_spot',
		'app.spot_option',
		'app.spot_options_spot',
		'app.password_reset',
		'app.public_page'
	);

}
