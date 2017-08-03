<?php

use Dflydev\DotAccessData\Data as Dot;

class ConfigDot
{
	public static function __callStatic($name, $args)
	{
		return new Dot(Config::$name(...$args));
	}
}
