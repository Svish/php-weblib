<?php

use Mustache\Engine;

/**
 * Mustache_Engine wrapper with some defaults and other stuff.
 */
class Mustache
{
	const DIR_APP = SRC.'_views'.DS;
	const DIR_LIB = __DIR__.DS.'_views'.DS;

	public static function engine(array $options = [], $template = null)
	{
		if($template)
			$partials = [
				self::DIR_APP.$template,
				self::DIR_APP,
				self::DIR_LIB,
				];

		$templates = [
			self::DIR_APP,
			self::DIR_LIB,
			];

		return new Engine($templates, $partials ?? null, $options);
	}
}
