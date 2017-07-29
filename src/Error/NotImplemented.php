<?php

namespace Error;

/**
 * 501 Internal Server Error.
 *
 * Used for hiding non-UserError.
 */
class NotImplemented extends HttpException
{
	public function __construct(\Throwable $reason = null)
	{
		parent::__construct(501, null, $reason);
	}
}
