<?php

namespace Data;
use Valid;


/**
 * Base class for data objects based on JSON files.
 */
abstract class SaveableData extends Data implements Entity
{
	public abstract function save(): bool;

	private $_dirty = [];

	public function __set($key, $value)
	{
		// Add to dirty if different
		if($value !== $this->{$key})
			$this->_dirty[$key] = $value;
		
		parent::__set($key, $value);
	}
	
	public function __unset($key)
	{
		// "Unset" by setting dirty value to null
		if(isset($this->$key))
			$this->_dirty[$key] = null;
		parent::__unset($key);
	}

	protected function rules(): iterable
	{
		return [];
	}

	public function validate()
	{
		Valid::check($this, $this->rules());
		return $this;
	}

	public function is_dirty()
	{
		return ! empty($this->_dirty);
	}
}
