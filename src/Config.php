<?php

use Error\InternalNotFound;

/**
 * Loads config files.
 * 
 * TODO: Cache when parsed?
 */
class Config
{
	const DIR = 'config'.DS;
	const GLOB = '{.,}%s.{ini,json,inc,txt}';


	public static $loaded = [];
	public static function __callStatic($name, $args)
	{
		if( ! array_key_exists($name, self::$loaded))
			self::$loaded[$name] = self::_get($name, $args);
		return self::$loaded[$name];
	}


	private static function _get(string $name, array $args)
	{
		$glob = self::DIR.sprintf(self::GLOB, $name);
		$files = glob($glob, GLOB_BRACE);
		if( ! $files)
			throw new InternalNotFound($name, 'config file');

		return self::_load($files[0], $args);
	}


	private static function _load(string $path, array $args)
	{
		switch(pathinfo($path, PATHINFO_EXTENSION))
		{
			case 'ini':
				return parse_ini_file($path, true, $args[0] ?? INI_SCANNER_RAW);
			
			case 'json':
				return json_decode(file_get_contents($path));
				
			case 'inc':
				return include $path;

			case 'txt':
				return file_get_contents($path);
		}
	}
}
