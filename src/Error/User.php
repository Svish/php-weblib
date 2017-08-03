<?php

namespace Error;

/**
 * 4xx User errors.
 */
abstract class User extends HttpException
{
	public function __construct(int $code = 400, $message = null, \Throwable $reason = null)
	{
		parent::__construct($code, $message, $reason);
	}	
}
