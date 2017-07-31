<?php

namespace Mustache\Loader;


/**
 * Mustache_Engine wrapper with some defaults and other stuff.
 */
class CascadingFilesystem extends \Mustache_Loader_CascadingLoader
{
	public function __construct(array $paths, string $loader = FilesystemLoader::class)
	{
		foreach($paths as $path)
			if( ! is_null($path) && is_dir($path))
				$loaders[] = new $loader($path);

		parent::__construct($loaders);
	}
}
