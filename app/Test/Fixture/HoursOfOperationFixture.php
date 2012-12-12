<?php
/**
 * HoursOfOperationFixture
 *
 */
class HoursOfOperationFixture extends CakeTestFixture {

/**
 * Table name
 *
 * @var string
 */
	public $table = 'hours_of_operation';

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'key' => 'primary'),
		'spot_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10),
		'short_string' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'open_time' => array('type' => 'time', 'null' => false, 'default' => null),
		'close_time' => array('type' => 'time', 'null' => false, 'default' => null),
		'sunday' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'monday' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tuesday' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'wednesday' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'thursday' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'friday' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'saturday' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
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
			'spot_id' => 1,
			'short_string' => 'Lorem ipsum dolor sit amet',
			'open_time' => '00:40:57',
			'close_time' => '00:40:57',
			'sunday' => 1,
			'monday' => 1,
			'tuesday' => 1,
			'wednesday' => 1,
			'thursday' => 1,
			'friday' => 1,
			'saturday' => 1
		),
	);

}
