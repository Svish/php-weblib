<?php

/**
 * Base class for data objects.
 */
class Data implements JsonSerializable
{
	private $_data = [];

	public function __construct(array $data = null)
	{
		if($data)
			$this->set($data);
	}



	public function set(array $data): self
	{
		foreach($data as $key => $value)
			$this->{$key} = $value;
		
		return $this;
	}


	public function __toString()
	{
		return get_class($this);
	}


	public function __get($key)
	{
		return $this->_data[$key] ?? null;
	}

	public function __set($key, $value)
	{
		$this->_data[$key] = $value;
	}	

	public function __isset($key)
	{
		return $this->{$key} !== null;
	}
	
	public function __unset($key)
	{
		unset($this->_data[$key]);
	}

	public function __call($method, $args)
	{
		if(is_callable($this->_data[$method] ?? false))
			return call_user_func_array($this->_data[$method], $args);
		else
			throw new \Error\NotImplemented(static::class.'->'.$method);
	}



	/**
	 * JSON serialization.
	 */
	const SERIALIZE = false;
	public function jsonSerialize()
	{
		$keys = static::SERIALIZE;

		// Sanity check...
		if( ! is_bool($keys) && ! is_array($keys))
			throw new \Error\Oops("$this::SERIALIZE must be array of keys to serialize, or boolean (true=all, false=none)");
		
		// None (default)
		if($keys === false || $keys == [])
			return [];

		// Get json data
		$_data = $this->toArray();

		// All
		if($keys === true)
			return $_data;

		// Only whitelisted
		return array_whitelist($_data, static::SERIALIZE);
	}

	protected function data(): iterable
	{
		return $this->_data;
	}

	public function toArray(): array
	{
		return ['__type' => get_class($this)]
			+ $this->_data;
	}

	public static function from(array $data)
	{
		$class = array_remove($data, '__type');

		return Reflect::pre_construct($class ?? static::class,
			function ($obj) use ($data)
			{
				$obj->_data = $data;
			});
	}
}
