<?php

namespace Error;

/**
 * 400 Unknown Reset Token
 * 
 * Unknown user OR reset token.
 */
class UnknownResetToken extends User
{
	public function __construct()
	{
		parent::__construct(400);
	}
}
