<?php

namespace Error;

/**
 * 400 Unknown Login
 * 
 * Unknown user OR password.
 */
class UnknownLogin extends User
{
	public function __construct(\Throwable $e = null)
	{
		parent::__construct(400, [], $e);
	}
}
