<?php

namespace Data;
use File, Cache, Log;
use JsonSerializable;


/**
 * Base class for data objects based on JSON files.
 */
abstract class Json extends SaveableData implements Entity, JsonSerializable
{
	const DIR = 'data'.DS;
	const EXT = '.json';



	/**
	 * Get data for this type with $id.
	 */
	public static final function get(...$id)
	{
		$id = reset($id);
		$file = self::safe(static::DIR.$id.static::EXT);

		// Check if there's a file
		$json = File::get($file);
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

	

	/**
	 * Get all data of this type.
	 */
	public static final function all(): iterable
	{
		foreach(static::index() as $id)
			yield static::get($id);
	}


	
	/**
	 * Get all ids for this type.
	 * 
	 * I.e. names of all json files with extension removed.
	 */
	public static final function index(): iterable
	{
		foreach(glob(static::DIR.'*'.static::EXT) as $path)
		{
			$path = pathinfo($path, PATHINFO_FILENAME);
			$path = self::from_win($path);
			yield $path;
		}
	}


	
	/**
	 * Delete data file for $id.
	 */
	public static function delete(...$id): bool
	{
		$id = reset($id);
		throw new Error\NotImplemented;
	}


	
	/**
	 * Save data file.
	 */
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
		$data = json_encode($this, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		$file = self::safe(static::DIR.$this->id.static::EXT);
		File::put($file, $data);
		Log::info("Saved $this to $file");
		return true;
	}



	public function __toString()
	{
		return parent::__toString()."({$this->id})";
	}



	protected function rules(): iterable
	{
		yield from parent::rules();
		yield 'id' => 'not_empty';
	}

	use \Candy\SafePath;
	use \Candy\WinPathFix;
}
