<?php

namespace Error;

/**
 * 403 Forbidden
 * 
 * User has no access.
 */
class Forbidden extends User
{
	public function __construct(array $required_roles)
	{
		parent::__construct(403, [implode(', ', $required_roles)]);
	}
}
