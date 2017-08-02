<?php

namespace Candy;


trait Instance
{
	private static $_i;
	public static function instance()
	{
		if( ! self::$_i)
			self::$_i = new self;
		return self::$_i;
	}
}
