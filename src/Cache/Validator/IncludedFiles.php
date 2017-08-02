<?php

namespace Cache\Validator;

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
		$this->files = array_filter(get_included_files(), function($s) 
			{
				return strpos($s, 'vendor'.DS) === false
					&& strpos($s, '.cache'.DS) === false;
			});

		return parent::__invoke($time);
	}
}
