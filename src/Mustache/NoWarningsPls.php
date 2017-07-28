<?php

namespace Mustache;

/**
 * Mustache logger that converts warnings into exceptions.
 */
class NoWarningsPls extends \Mustache_Logger_AbstractLogger
{
	public function log($level, $message, array $context = [])
	{
		if($level == \Mustache_Logger::WARNING)
		{
			foreach($context as $key => $val)
			{
				$context['{'.$key.'}'] = $val;
				unset($context[$key]);
			}
			$message = strtr($message, $context);
			throw new \Exception($message);
		}
	}
}
