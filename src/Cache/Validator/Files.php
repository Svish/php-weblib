<?php

namespace Cache\Validator;

use Log;


/**
 * Invalidates if any listed files have changes.
 * 
 * TODO: Tests.
 */
class Files implements \Cache\Validator
{
	protected $files;


	/**
	 * @param $files Files to check.
	 */
	public function __construct(array $files)
	{
		$this->files = $files;
	}


	/**
	 * @return FALSE if any given files have changed since $time.
	 */
	public function __invoke(int $time): bool
	{
		Log::trace("Checking files…");
		foreach($this->files as $f)
			if(filemtime(self::to_win($f)) >= $time)
			{
				Log::trace('File', self::from_win($f, true), 'has changed.');
				return false;
			}
		return true;
	}


	use \Candy\WinPathFix;
}
