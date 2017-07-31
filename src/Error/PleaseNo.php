<?php

namespace Error;

/**
 * 403 Forbidden
 *
 * Things not supposed to happen unless a user is messing with something.
 */
class PleaseNo extends User
{
	public $actualReason;
	public function __construct(string $actualReason, \Throwable $e = null)
	{
		parent::__construct(403, [], $e);
		$this->actualReason = $actualReason;
	}
}
