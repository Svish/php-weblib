<?php

namespace Cache\Validator;

use Error\Oops;
use Log;


/**
 * Invalidates if directory or files in it have changes.
 * 
 * TODO: Tests.
 */
class Directory extends Files
{
	protected $dir;


	public function __construct(string $dir)
	{
		$x = substr($dir, -1);
		if($x != '/' AND $x != '\\')
			throw new Oops("Directory $dir is missing a trailing slash.");

		$this->dir = $dir;
	}


	public function __invoke(int $time): bool
	{
		// Check directory
		if(filemtime($this->dir) > $time)
		{
			Log::trace('Directory', self::from_win($this->dir, true), 'has changed.');
			return false;
		}

		// Check files IN directory
		$this->files = glob("{$this->dir}*");
		return parent::__invoke($time);
	}


	use \Candy\WinPathFix;
}
