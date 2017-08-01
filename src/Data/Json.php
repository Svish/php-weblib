<?php

namespace Data;
use File, Cache, Log;
use JsonSerializable;


/**
 * Base class for data objects based on JSON files.
 * 
 * Saves to ./namespace/type, normally ./data/type
 */
abstract class Json extends SaveableData implements Entity, JsonSerializable
{
	const EXT = '.json';

	/**
	 * Returns data for $id.
	 */
	public static final function get(...$id)
	{
		$id = reset($id);

		// Check if there's a file
		$json = File::get(self::path($id));
		if( ! $json)
			throw new \Error\NotFound($id, static::class);
		
		// Try decode it
		$json = json_decode($json, true);
		if($json === false)
			throw new \Error\Json;

		// Add id since it's not in the actual json
		$json['id'] = $id;

		// Convert to object
		return self::from($json);
	}

	protected function rules(): iterable
	{
		yield from parent::rules();
		yield 'id' => 'not_empty';
	}

	public function save(): bool
	{
		// Check if dirty
		if( ! $this->is_dirty())
		{
			Log::trace(static::class, 'has no changes to save.');
			return false;
		}

		// Validate
		$this->validate();

		// Save
		$data = json_encode($this, JSON_PRETTY_PRINT);
		$path = self::path($this->id);
		File::put($path, $data);
		Log::info("Saved $this to $path");
		return true;
	}



	public function __toString()
	{
		return parent::__toString()."({$this->id})";
	}

	/**
	 * Helper: Return absolute path to data file for $id.
	 * 
	 * Optionally with a different extension.
	 */
	protected static final function path(string $id, string $ext = null): string
	{
		return self::to_win(static::dir().$id.($ext ?: static::EXT));
	}

	protected static final function dir()
	{
		return str_replace('\\', DS, strtolower(static::class)).DS;
	}




	/**
	 * Get data for all $ids.
	 */
	public static final function all(): iterable
	{
		foreach(static::index() as $id)
			yield static::get($id);
	}


	
	/**
	 * Get all ids.
	 * 
	 * I.e. names of all json files with extension removed.
	 */
	public static final function index(): iterable
	{
		foreach(glob(self::path('*')) as $path)
		{
			$path = pathinfo($path, PATHINFO_FILENAME);
			$path = self::from_win($path);
			yield $path;
		}
	}



	public function delete(): bool
	{
		throw new Error\NotImplemented;
	}

	use \WinPathFix;
}
