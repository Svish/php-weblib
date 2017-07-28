<?php

/**
 * Candy trait for nicer looking "sub class" chaining.
 * 
 *     Model::foo(1,2)->bar()
 * 	      =>
 * 	   (new Model\foo(1,2))->bar()
 */
trait CandyNew
{
	public static function __callStatic($name, $args)
	{
		$name = __CLASS__.'\\'.ucfirst($name);
		return new $name(...$args);
	}
}
