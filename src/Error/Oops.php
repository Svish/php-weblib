<?php

namespace Error;

/**
 * 500 Internal server error.
 *
 * Things that could happen, but shouldn't,
 * unless the I've messed something up...
 */
class Oops extends Internal
{
	public $actualReason;
	public function __construct(string $actualReason)
	{
		$this->actualReason = $actualReason;
		parent::__construct(500);
	}
}
