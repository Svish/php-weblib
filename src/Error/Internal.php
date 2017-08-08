<?php

namespace Error;

/**
 * 500 Internal Server Error.
 *
 * Errors that will be presented more obscurely to users.
 */
class Internal extends HttpException
{
	public function __construct(int $code = 500, $message = null, \Throwable $reason = null)
	{
		parent::__construct($code, $message, $reason);
	}
}
