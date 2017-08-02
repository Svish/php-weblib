<?php

namespace View\Helper;
use ReflectionFunction as Func;
use Mustache_LambdaHelper as LambdaHelper;
use Log;

/**
 * Helper: PHP Function wrapper
 * 
 *     {{title | ucwords}}
 */
class PhpFunction
{
	private static $whitelist = [
		'ucfirst',
		'ucwords',
		'strtolower',
		'urlencode',
		];


	private $function;
	public function __construct($function)
	{
		$this->function = new Func($function);

		// Check required parameter count
		if(1 != $this->function->getNumberOfRequiredParameters())
			throw new \Exception("'$function' not usable via ".__CLASS__.". Has $rp required parameters, needs exactly 1.");
	}


	public function __invoke($text, LambdaHelper $render = null)
	{
		Log::trace($this->function->getShortName().'(', $text, ')');
		$text = $this->function->invokeArgs([$text]);
		return $render ? $render($text) : $text;
	}


	/**
	 * Only use for certain whitelisted functions.
	 */
	public static function exists($name)
	{
		return function_exists($name)
		   and in_array($name, self::$whitelist);
	}
}
