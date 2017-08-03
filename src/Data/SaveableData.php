<?php

namespace Data;

use Valid;


/**
 * Base class for saveable data.
 * 
 *  - Validation.
 *  - Dirty tracking.
 */
abstract class SaveableData extends Data implements Entity
{
	
	public abstract function save(): bool;


	/**
	 * @return iterable Rules to validate against.
	 * @see Valid::check
	 */
	protected function validation_rules(): iterable
	{
		return [];
	}


	/**
	 * @var array Dirty data.
	 */
	private $_dirty = [];


	/**
	 * @return bool True if any values have changed; otherwise false.
	 */
	public function is_dirty(): bool
	{
		return ! empty($this->_dirty);
	}


	/**
	 * Validates the data.
	 * 
	 * @uses self::validation_rules To get ruleset.
	 * @return self For chaining.
	 */
	public function validate()
	{
		Valid::check($this, $this->validation_rules());
		return $this;
	}


	public function __set($key, $value)
	{
		// Set value
		parent::__set($key, $value);

		// Add to dirty if different
		if($value !== $this->{$key})
			$this->_dirty[$key] = $value;
	}

	
	public function __unset($key)
	{
		// Unset value
		parent::__unset($key);

		// "Unset" by setting dirty value to null
		if(isset($this->$key))
			$this->_dirty[$key] = null;
	}

}
