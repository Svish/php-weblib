<?php

use Mustache\NoWarningsPls as Logger;

use Mustache\CascadingFilesystemLoader as Loader;
use Mustache\FilesystemLoader as File;
use Mustache\FilesystemPartialsLoader as Partials;

/**
 * Mustache_Engine wrapper with some defaults and other stuff.
 */
class Mustache extends Mustache_Engine
{
	const DIR_APP = SRC.'_views'.DIRECTORY_SEPARATOR;
	const DIR_LIB = __DIR__.DIRECTORY_SEPARATOR.'_views'.DIRECTORY_SEPARATOR;

	public static function engine(array $options = [], $template = null)
	{
		if($template)
			$options += [
				'partials_loader' => new Loader([
					self::DIR_APP.$template,
					self::DIR_APP,
					self::DIR_LIB,
				], Partials::class),
			];

		return new self($options + [
			'cache' => Cache::DIR . __CLASS__,
			'pragmas' => [Mustache_Engine::PRAGMA_FILTERS],
			'strict_callables' => true,
			'logger' => new Logger,
			'loader' => new Loader([
					self::DIR_APP,
					self::DIR_LIB,
				], File::class),
			]);
	}
}
