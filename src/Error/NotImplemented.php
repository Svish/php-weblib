<?php

namespace Error;

/**
 * 501 Internal Server Error
 *
 * When a method does not exist or has not been implemented yet.
 */
class NotImplemented extends Internal
{
	public function __construct($method)
	{
		parent::__construct(501, "Method does not exist: $method");
	}
}
