<?php

namespace Error;

/**
 * 500 Internal Not Found
 *
 * Used for things that are not found because of developer...
 */
class InternalNotFound extends Internal
{
	public function __construct($id, $what, \Throwable $reason = null)
	{
		parent::__construct(500, [$id, $what], $reason);
	}
}
