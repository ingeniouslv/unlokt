<?php
App::uses('Model', 'Model');

/**
 * @package       app.Model
 */
class AppModel extends Model {
	
	// Default to recursive = -1;
	// That way queries must be formed properly when being created.
	public $recursive = -1;
	// No caching enabled by default.
	public $cache = false;
	// Add hard override for caching. Enable this in the event that there's no memcache available.
	private $disableCache = false;
	
	// Override the default find() method in order to add caching layer.
	function find($type = 'first', $params = array()) {
		// if caching is enabled, let's grab the cached data
		if ($this->cache && !$this->disableCache) {
			if (is_array($type)) {
				$typeString = md5(serialize($type));
			} else {
				$typeString = $type;
			}
			$tag = isset($this->name) ? '_' . $this->name : 'appmodel';
			$paramsHash = md5(serialize($params));
			$fullTag = $tag . '_' . $typeString . '_' . $paramsHash;
			
			$result = Cache::read($fullTag);
			if ($result) {
				return $result;
			}
			$result = parent::find($type, $params);
			Cache::write($fullTag, $result);
			
			return $result;
		} else {
			// caching is not enabled -- just do a regular find
			return parent::find($type, $params);
		} 
	} // end of find();
	
	public function increment($field, $increment_amount = 1) {
		if (!is_numeric($this->id)) {
			throw new Exception('Expecting ID');
		}
		return $this->updateAll(array("{$this->name}.$field" => "{$this->name}.$field + $increment_amount"), array("{$this->name}.id" => $this->id));
	} // end of increment()
	
	
	function findContain($id, $contain = array(), $conditions = array()) {
		$conditions = array_merge(
			array(
				"{$this->name}.id" => $id
			), $conditions
		);
		$this->Behaviors->attach('Containable');
		return $this->find('first', array(
			'conditions' => $conditions,
			'contain' => $contain
		));
	}
	
	function findAllContain($id, $contain = array(), $conditions = array()) {
		$conditions = array_merge(
			array(
				"{$this->name}.id" => $id
			), $conditions
		);
		$this->Behaviors->attach('Containable');
		return $this->find('all', array(
			'conditions' => $conditions,
			'contain' => $contain
		));
	}
	
	// Until we have a better cache expiry system, we must clear the cache after any save.
	// This reduces the effectiveness of the cache, but reduces headache problems from users/admins
	public function afterSave($created) {
		$this->clear_cache();
		parent::afterSave($created);
	}
	public function afterDelete() {
		$this->clear_cache();
		parent::afterDelete();
	}
	
	public function clear_cache() {
		// Only clear the cache if we're not using CLI.
		// CLI gives fatal errors with memcache. ?? Bogus right?
		if (PHP_SAPI === 'cli')
		{
			return;
		}
		Cache::clear(false, 'default');
	}
}