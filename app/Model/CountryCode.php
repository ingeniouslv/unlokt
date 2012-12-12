<?php
App::uses('AppModel', 'Model');

class CountryCode extends AppModel {
	public $primaryKey = 'iso';
	public $displayField = 'printable_name';
	public $order = 'CountryCode.delta DESC, CountryCode.printable_name ASC';
}