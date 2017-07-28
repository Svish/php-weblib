<?php
namespace Mustache;
use Mustache\FilesystemLoader as Loader;

/**
 * Mustache_Engine wrapper with some defaults and other stuff.
 */
class CascadingFilesystemLoader extends \Mustache_Loader_CascadingLoader
{
	public function __construct(array $paths)
	{
		foreach($paths as $path)
			if( ! is_null($path) && is_dir($path))
				$loaders[] = new Loader($path);

		parent::__construct($loaders);
	}
}
