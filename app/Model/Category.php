<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property ParentCategory $ParentCategory
 * @property Spot $Spot
 */
class Category extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'ParentCategory' => array(
			'className' => 'Category',
			'foreignKey' => 'parent_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Spot' => array(
			'className' => 'Spot',
			'joinTable' => 'categories_spots',
			'foreignKey' => 'category_id',
			'associationForeignKey' => 'spot_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
			'deleteQuery' => '',
			'insertQuery' => ''
		)
	);

	/**
	 * Returns a threaded list of categories with their ids as indexes and spaced names for values.  This function works recursively
	 * to allow infinte depth of a threaded list.
	 * @var categories - threaded list you need to parse.  If empty or not given, the  full list of categories will be used.
	 * @var prefix - value that will prefix the name of the category.
	 * @var spacer - value that will be added to the prefix before each recursion.
	 */
	public function getThreadedList($categories = null, $prefix = '', $spacer = '  ') {
		//only grab all categories if a given category list is empty
		if(empty($categories)) {
			$categories = $this->find('threaded');
		}
		//sort the parent categories by alpha name
		usort($categories, array('Category', '_alphaSortCategories'));
		//initialize threaded list
		$threadedCategoryList = array();
		foreach($categories as $category) {
			//add item to list
			$threadedCategoryList[$category['Category']['id']] = $prefix.$category['Category']['name'];
			//don't call getThreadedList with an empty array.  This will result in an infinite loop.
			if(!empty($category['children'])) {
				//add the threaded children list to the current list
				$threadedCategoryList += $this->getThreadedList($category['children'], $prefix.$spacer, $spacer);
			}
		}

		return $threadedCategoryList;
	}
	
	//Comparison function for an alpha sort on the name
	private function _alphaSortCategories($a, $b) {
		return strcmp($a['Category']['name'], $b['Category']['name']);
	}
	
	//Discover the parent categories for a list of categories
	public function getParentCategories() {
		$categories = Hash::combine($this->find('all'),"{n}.Category.id","{n}");
		
		$parentCategoryList = array();
		foreach($categories as $category) {
			$parentCat = $category;
			while($parentCat['Category']['parent_id'] !== null) {
				$parentCat = $categories[$parentCat['Category']['parent_id']];
			}
			
			$parentCategoryList[$category['Category']['id']] = $parentCat['Category']['name'];
		}
		return $parentCategoryList;
	}
	
	
}
