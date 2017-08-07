<?php

namespace Candy;


trait Instance
{
	private static $_i;
	public static function instance(...$ctor_args)
	{
		if( ! self::$_i)
			self::$_i = new static(...$ctor_args);
		return self::$_i;
	}
}
