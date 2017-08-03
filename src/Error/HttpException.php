<?php

namespace Error;
use HTTP, Text;

/**
 * Exception with HTTP status and title.
 */
class HttpException extends \Exception
{
	protected $httpStatus;
	protected $httpTitle;

	public function __construct(int $httpStatus = 500, $message = null, \Throwable $cause = null, $code = E_USER_ERROR)
	{
		$this->httpStatus = $httpStatus;
		$this->httpTitle = HTTP::status($httpStatus);

		// If array, use as parameters and format $message
		if(is_array($message))
		{
			$class = get_class($this);
			$class = str_replace('Error\\', '', $class);
			$message = Text::exception($class, $message);
		}

		parent::__construct($message ?? $this->httpTitle, $code, $cause);
	}

	public function getHttpStatus()
	{
		return $this->httpStatus;
	}
	public function getHttpTitle()
	{
		return $this->httpTitle;
	}
}
