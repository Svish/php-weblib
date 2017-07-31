<?php

namespace Data;
use Data as D;

/**
 * Extends Data with auto-computed columns.
 */
abstract class Data extends D
{
	private $_handlers = [];
	private $_on = true;


	/**
	 * Get the handler of given type.
	 * 
	 *     $this->handler(Type::class);
	 * 
	 */
	protected function handler(string $type): Computed
	{
		foreach($this->_handlers as $h)
			if($h instanceof $type)
				return $h;
		throw new Exception("$this has no handler of type '$type'");
	}

	/**
	 * Set the handlers to use.
	 */
	protected function computed(Computed ...$handlers)
	{
		$this->_handlers = $handlers;
	}


	/**
	 * To temporarily disable this.
	 */
	protected final function toggle()
	{
		$this->_on = ! $this->_on;
	}


	public function __set($key, $value)
	{
		parent::__set($key, $value);

		if( ! $this->_on)
			return;
		
		foreach($this->_handlers as $handler)
			foreach($handler->set($key, $value) as $k => $v)
			{
				if($k == $key)
					parent::__set($k, $v);
				else
					$this->$k = $v;
			}
	}
	
	
	public function __unset($key)
	{
		parent::__unset($key);
		
		if($this->_on)
			foreach($this->_handlers as $handler)
				foreach($handler->unset($key) as $k)
					unset($this->$k);
	}
}
