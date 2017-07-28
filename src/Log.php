<?php

use Geekality\ConsoleLog;


/**
 * Logger class.
 * 
 *     Log::info('some', $data); // This gets caller prepended
 *     Log::info_raw('some', $data); // This doesn't
 *
 * @uses ConsoleLog
 */
class Log
{
	use Instance;

	const DIR = ROOT.'.logs'.DIRECTORY_SEPARATOR;

	const LEVELS = ['group', 'groupEnd', 'trace', 'info', 'warn', 'error'];


	private $console;
	private function __construct()
	{
		$this->console = new ConsoleLog(4);
	}


	/**
	 * Call via instance.
	 */
	public static function __callStatic($level, $args)
	{
		self::instance()->$level(...$args);
	}

	/**
	 * Logging calls.
	 * TODO: Should be private?
	 */
	public function __call($level, $args)
	{
		$caller = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[2];
		$raw = ends_with('_raw', $level);
		$level = $raw ? substr($level, 0, -4) : $level;

		if( ! in_array($level, self::LEVELS))
			throw new Exception("Unsupported log level: $level");

		self::instance()->_log($caller, $level, $raw, $args);
		self::instance()->_chromeLog($caller, $level, $raw, $args);
	}



	/**
	 * Helper: ConsoleLog wrapper with some extras.
	 */
	protected function _log(array $caller, string $level, bool $raw, array $args)
	{
		// TODO: Write errors to file/email? Tail on problems page?
		//var_dump(get_defined_vars());
	}


	
	/**
	 * Helper: ConsoleLog wrapper with some extras.
	 */
	protected function _chromeLog(array $caller, string $level, bool $raw, array $args)
	{
		if(ENV != 'dev')
			return;

		if($level == 'trace')
			$level = 'log';

		if( ! $raw)
		{
			// Add caller as header/first argument
			$caller = $caller['class'];
			array_unshift($args, "$caller:");
		}

		// TODO: Already have backtrace here, so make a private subclass of ConsoleLog that gets that passed in instead?
		$this->console->$level(...$args);
	}
}
