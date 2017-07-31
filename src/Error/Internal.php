<?php

namespace Error;

/**
 * 500 Internal Server Error.
 *
 * Errprs that will be presented more obscurely to users.
 */
class Internal extends HttpException
{
	public function __construct(int $code = 500, string $message = null, \Throwable $reason = null)
	{
		parent::__construct($code, $message, $reason);
	}
}
