<?php

namespace Cache\Validator;

/**
 * Checks if any included files have changed.
 */
class IncludedFiles extends File
{
	public function __construct()
	{
		parent::__construct([]);
	}

	/**
	 * @returns FALSE if any included files have changed since $time.
	 */
	public function __invoke($time)
	{
		$this->files = array_filter(get_included_files(), function($s) 
			{
				return strpos($s, 'vendor'.DS) === false
					&& strpos($s, '.cache'.DS) === false;
			});

		return parent::__invoke($time);
	}
}
