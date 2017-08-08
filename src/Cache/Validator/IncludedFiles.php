<?php

namespace Cache\Validator;

use Log;


/**
 * Invalidates if any included files have changes.
 * 
 * TODO: Tests.
 */
class IncludedFiles extends Files
{
	public function __construct()
	{
		parent::__construct([]);
	}

	/**
	 * @returns FALSE if any included files have changed since $time.
	 */
	public function __invoke(int $time): bool
	{
		$count = 0;
		$this->files = array_filter(get_included_files(), function($s) use(&$count)
			{
				$count++;
				return strpos($s, '.cache'.DS) === false;
			});
		Log::trace("Checking {$count} included files");

		return parent::__invoke($time);
	}
}
