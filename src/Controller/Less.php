<?php

namespace Controller;

use Error\InternalNotFound;
use Error\PageNotFound;

use Less_Cache as Lessc;
use Less_Exception_Parser as LesscException;

use Cache, File, Log;


/**
 * Handles compilation and serving of LESS files as CSS.
 */
class Less extends Cached
{
	const EXT = '.less';
	const CACHE = Cache::DIR.__CLASS__.DS;
	const DIR = [
		SRC.'_less'.DS,
		__DIR__.DS.'..'.DS.'_less'.DS
	];


	private $_less;
	private $_css;



	protected function cache_valid($cached_time)
	{
		return parent::cache_valid($cached_time)
		   and $cached_time >= filemtime($this->_css);
	}



	public function before(array &$info)
	{
		$this->_less = self::DIR[0]
			. ($info['params'][1] ?? null)
			. self::EXT;

		if( ! is_readable($this->_less))
			throw new PageNotFound;

		$this->_compile();

		parent::before($info);
	}



	public function get(string $name)
	{
		header('Content-Type: text/css; charset=utf-8');
		echo file_get_contents($this->_css);
	}



	private function _compile()
	{
		try
		{
			File::mkdir(self::CACHE);
			$this->_css = self::CACHE.Lessc::Get([ $this->_less => WEBROOT ],
				[
					'compress' => true,
					'strictMath' => true,
					'cache_dir' => self::CACHE,
					'indentation' => "\t",
					'import_callback' => [$this, 'find_import'],
				]);
		}
		catch(LesscException $e)
		{
			Log::error("Compile failed\r\n", $e->getMessage());
			throw $e;
		}
	}



	public function find_import($import)
	{
		$file = $import->path->value;

		foreach(self::DIR as $dir)
		{
			$path = realpath($dir.$file.self::EXT);
			if($path !== false)
				return [$path, null];
		}

		throw new InternalNotFound($file, 'Less file');
	}
}
