<?php

/**
 * Cache helper.
 * 
 * TODO: Tests.
 */
class Cache
{
	const DIR = ROOT.'.cache'.DS;
	
	protected $id;
	protected $dir;
	protected $valid = [];


	/**
	 * Creates a new cache instance.
	 *
	 * @param id Identifier for this cache
	 * @param cache_validators 
	 *			TTL seconds => int
	 *			Files to check modified => array
	 *			Custom => callable(int $mtime, string $key): bool
	 */
	public function __construct(string $id, ...$cache_validators)
	{
		// Set cache directory
		$this->id = $id;
		$this->dir = static::dir($id);

		// Unless first is null, add default file validator
		if(null !== reset($cache_validators))
			$this->valid[] = new Cache\Validator\IncludedFiles();

		// Add cache validators
		foreach($cache_validators as $v)
		{
			// int: TTL
			if(is_int($v))
				$this->valid[] = new Cache\Validator\Time($v);

			// string: Directory to watch
			elseif(is_string($v))
				$this->valid[] = new Cache\Validator\Directory($v);
			// array: List of files to check
			elseif(is_array($v))
				$this->valid[] = new Cache\Validator\Files($v);

			// callable: Callable to call
			elseif(is_callable($v))
				$this->valid[] = $v;
		}
	}

	/**
	 * Reads and unserializes data from the cache file identified by $key.
	 */
	public function get(string $key, $default = NULL)
	{
		$file = $this->path($key);

		// Try get data
		$data = $this->_get($file);

		// Return if existing and valid
        if($data !== NULL && $this->is_valid(filemtime($file), $key))
			return unserialize($data);

		// Call and store default if callable
		if(is_callable($default))
			return $this->set($key, $default);

		// Otherwise, return $default
		return $default;
	}
	private function _get(string $file)
	{
		return File::get($file);
	}

	protected function is_valid(int $mtime, string $key): bool
	{
		$valid = true;

		foreach($this->valid as $v)
			if( ! $v($mtime, $key))
			{
				Log::warn_raw(strval_any($v).": Invalidated {$this->id}[$key]}");
				$valid = false;
			}

		Log::trace($key, 'is', $valid ? 'VALID' : 'INVALID');
		return $valid;
	}



	/**
	 * Serializes and stores the $data in a cache file identified by $key.
	 */
	public function set(string $key, $data)
	{
		if(is_callable($data))
			$data = $data($key);

		return $this->_set($this->path($key), $data);
	}
	private function _set(string $file, $data)
	{
		if($data instanceof Generator)
			$data = iterator_to_array($data);
		
		File::put($file, serialize($data));
		return $data;
	}



	/**
	 * Return sanitized file path for $key.
	 */
	protected function path(string $key): string
	{
		return $this->dir.self::sanitize($key);
	}

	/**
	 * Make the key filename-friendly.
	 */
	protected static function sanitize(string $key): string
	{
		return preg_replace('/[^.a-z0-9_-]+/i', '-', $key);
	}


	public static function dir(string $id): string
	{
		return static::DIR.str_replace(['\\', '/'], DS, $id).DS;
	}



	/**
	 * Delete the cache for this $id.
	 */
	public function clear()
	{
		File::rdelete($this->dir, true);
		Log::trace("Cleared {$this->id}");
	}

	/**
	 * Delete the whole cache.
	 */
	public static function clear_all()
	{
		File::rdelete(self::DIR, true);
		Log::trace("Cleared all");
	}
}
