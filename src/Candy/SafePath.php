<?php

namespace Candy;
use Error\PleaseNo;


trait SafePath
{
	/**
	 * Checks if realpath($path) is sub static::DIR.
	 * 
	 * TODO: Tests.
	 * 
	 * @return mixed Result of realpath.
	 * @throws PleaseNo If path is outside DIR
	 */
	private static function safe(string $path): string
	{
		$parent = ROOT.static::DIR;
		$path = realpath($path);
		if( ! starts_with($parent, $path))
		{
			throw new PleaseNo(static::class." shouldn't be touching $path unless someone is messing with something...");
		}

		return $path;
	}
}
