<?php
/**
 * DealFixture
 *
 */
class DealFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'description' => array('type' => 'string', 'null' => false, 'length' => 140, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'long_description' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'fine_print' => array('type' => 'text', 'null' => true, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'spot_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'start_time' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'end_time' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'is_active' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'is_public' => array('type' => 'boolean', 'null' => false, 'default' => '1'),
		'keys' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'repeat_dow_0' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sku' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 64, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'limit_per_customer' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10, 'comment' => '0 = Unlimited'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'views' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'redemptions' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'completions' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 10),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet',
			'long_description' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'fine_print' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
			'spot_id' => 1,
			'start_time' => '2012-10-16 11:42:07',
			'end_time' => '2012-10-16 11:42:08',
			'is_active' => 1,
			'is_public' => 1,
			'keys' => 1,
			'repeat_dow_0' => 1,
			'sku' => 'Lorem ipsum dolor sit amet',
			'limit_per_customer' => 1,
			'created' => '2012-10-16 11:42:08',
			'views' => 1,
			'redemptions' => 1,
			'completions' => 1
		),
	);

}
