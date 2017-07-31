<?php

namespace Error;

/**
 * 500 Internal Server Error.
 *
 * Errors related to JSON encoding/decoding
 */
class Json extends Internal
{
	public function __construct()
	{
		$error = json_last_error_msg();
		$error = "JSON fail: $error";
		parent::__construct(500, $error);
	}
}
