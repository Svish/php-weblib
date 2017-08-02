<?php

namespace Cache;

interface Validator
{
	/**
	 * Performs the validation.
	 * 
	 *     return filemtime($somefile) > $time;
	 * 
	 * @param int $time The time to validate against.
	 * @return bool True if valid; otherwise false;
	 */
	public function __invoke(int $time): bool;
}
