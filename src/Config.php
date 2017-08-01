<?php

/**
 * Loads config files.
 * 
 * TODO: Cache when parsed.
 */
class Config
{
	const DIR = ROOT.'config'.DS;

	public static $loaded = [];
	public static function __callStatic($name, $args)
	{
		if( ! array_key_exists($name, self::$loaded))
			self::$loaded[$name] = self::_get($name, $args);
		return self::$loaded[$name];
	}


	private static function _get(string $name, array $args)
	{
		$files = glob(self::DIR."{.,}$name.{inc,ini,json}", GLOB_BRACE);
		if( ! $files)
			throw new Exception("Config for '$name' not found.");

		return self::_load($files[0], $args);
	}


	private static function _load(string $path, array $args)
	{
		switch(pathinfo($path, PATHINFO_EXTENSION))
		{
			case 'ini':
				return parse_ini_file($path, true, INI_SCANNER_RAW);
			
			case 'json':
				return json_decode(file_get_contents($path));
				
			case 'inc':
				return include $path;
		}
	}
}
