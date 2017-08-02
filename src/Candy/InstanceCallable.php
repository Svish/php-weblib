<?php

namespace Candy;


trait InstanceCallable
{
	use Instance;
	
	public static function __callStatic($method, $args)
	{
		return self::instance()->$method(...$args);
	}
}
