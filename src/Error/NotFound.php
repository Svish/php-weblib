<?php

namespace Error;

/**
 * 404 Not found
 *
 * Used for e.g. database entities, not pages.
 */
class NotFound extends User
{
	public function __construct($id, $what, \Throwable $reason = null)
	{
		parent::__construct(404, [$id, $what], $reason);
	}
}
