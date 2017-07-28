<?php

/**
 * Loads config files.
 */
class Config
{
	const DIR = ROOT.'config'.DIRECTORY_SEPARATOR;

	public static $loaded = [];
	public static function __callStatic($name, $args)
	{
		if( ! array_key_exists($name, self::$loaded))
			self::$loaded[$name] = self::_get($name);
		return self::$loaded[$name];
	}


	private static function _get(string $name)
	{
		$files = glob(self::DIR."{.,}$name.{inc,ini}", GLOB_BRACE);
		if( ! $files)
			throw new Exception("Config for '$name' not found.");

		return self::_load($files[0]);
	}


	private static function _load(string $path)
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
