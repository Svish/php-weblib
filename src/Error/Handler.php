<?php

namespace Error;
use HTTP, Message, Log;
use View\ErrorHtml;
use View\ErrorJson;

/**
 * Global error handler.
 */
class Handler
{
	/**
	 * @see http://php.net/manual/en/function.set-exception-handler.php
	 */
	public function __invoke(\Throwable $e = null)
	{
		// Wrap in Internal if not User error
		if( ! $e instanceof User && ! $e instanceof Internal)
			$e = new Internal(500, null, $e);

		// Log
		$log = $e instanceof Internal ? 'error_raw' : 'warn_raw';
		Log::$log(get_class($e), $e->getMessage());
		if(ENV == 'dev' || $user->has_roles('admin'))
		{
			if($e->actualReason ?? false)
				Log::trace_raw(" └ Actual reason: {$e->actualReason}");
			Log::trace_raw(" └ ", $e->getTraceAsString());
			Log::trace_raw(" └ ", $e->getFile(), $e->getLine());
		}

		// Add message
		Message::exception($e);

		// Redirect to login if unauthorized
		// TODO: Bring extra GET query parameters along
		if($e instanceof Unauthorized)
			HTTP::redirect('user/login?url='.urlencode(PATH));


		// Set status
		HTTP::set_status($e);

		// Render error page
		$view = boolval(getallheaders()['Is-Ajax'] ?? false)
			? new ErrorJson($e)
			: new ErrorHtml($e);
		$view->output();
		exit;
	}

	/**
	 * @see http://php.net/manual/en/class.errorexception.php#errorexception.examples
	 */
	public function error($severity, $message, $file, $line)
	{
		// Check if included in error_reporting
		if( ! (error_reporting() & $severity))
			return;

		$this(new \ErrorException($message, 0, $severity, $file, $line));
	}
}
