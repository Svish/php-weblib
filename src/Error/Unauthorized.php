<?php

namespace Error;

/**
 * 401 Unauthorized
 * 
 * User needs to login.
 */
class Unauthorized extends User
{
	public function __construct()
	{
		parent::__construct(401);
	}
}
