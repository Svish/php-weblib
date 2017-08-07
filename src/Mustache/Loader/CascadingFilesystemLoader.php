<?php

namespace Mustache\Loader;

use Mustache_Loader_ProductionFilesystemLoader as Loader;


/**
 * A Cascading filesystem loader
 * 
 *  - Checks if directory exists before creaing a filesystem loader for it.
 *  - Defaults to shorter .ms extension.
 */
class CascadingFilesystemLoader extends \Mustache_Loader_CascadingLoader
{
	const EXT = '.ms';

	public function __construct(array $paths, array $options = [])
	{
		foreach($paths as $path)
			if( ! is_null($path) && is_dir($path))
			{
				$loaders[] = new Loader($path, $options +
					[
						'stat_props' => ['mtime'],
						'extension' => self::EXT,
					]);
			}

		parent::__construct($loaders ?? []);
	}
}
