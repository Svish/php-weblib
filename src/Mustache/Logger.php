<?php

namespace Mustache;
use Log;
use \Mustache_Logger as ML;


/**
 * Mustache logger that converts warnings into exceptions.
 */
class Logger extends \Mustache_Logger_AbstractLogger
{
	public function log($level, $message, array $context = [])
	{
		// Intrapolate message
		if(strpos($message, '{') !== false)
		{
			foreach($context as $key => $val)
			{
				$context['{'.$key.'}'] = $val;
				unset($context[$key]);
			}
			$message = strtr($message, $context);
		}
		
		// Throw on Warning to make sure we don't have any lurking around..
		if($level == ML::WARNING)
			throw new \Exception($message);


		$level = self::MAP[$level] ?? 'info';
		if($level)
			Log::$level($message);
	}


	const MAP = [
			ML::EMERGENCY => 'error',
			ML::ALERT => 'error',
			ML::CRITICAL => 'error',
			ML::ERROR => 'error',
			ML::WARNING => 'warn',
			ML::NOTICE => 'info',
			ML::INFO => false,
			ML::DEBUG => false,
		];
}
