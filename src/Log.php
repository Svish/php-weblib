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

	const DIR = ROOT.'.logs'.DS;
	const TYPES = [
		'group',
		'groupEnd',
		'error',
		'warn',
		'info',
		'trace',
	];



	private $_console;
	private function __construct()
	{
		$this->_console = new ConsoleLog(4);
	}



	/**
	 * Call via instance.
	 */
	public static function __callStatic($type, $args)
	{
		self::instance()->$type(...$args);
	}



	/**
	 * Logging calls.
	 */
	public function __call($type, $args)
	{
		// Get backtrace
		$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[2];

		// Get type and "raw"
		$raw = ends_with('_raw', $type);
		$type = $raw ? substr($type, 0, -4) : $type;

		// Check type
		if( ! in_array($type, self::TYPES))
			throw new Exception("Unsupported log type: $type");

		// Console logging
		if(ENV == 'dev' || Security::check('admin'))
			self::instance()->_consoleLog($backtrace, $type, $raw, $args);

		// File logging
		//self::instance()->_fileLog($backtrace, $type, $raw, $args);
	}



	/**
	 * Helper: .
	 */
	protected function _fileLog(array $backtrace, string $type, bool $raw, array $args)
	{
		// TODO: Write errors to file/email? Tail on problems page?
		switch($type)
		{
			case 'group':
				$this->_groupLevel++;
				break;

			case 'groupEnd':
				$this->_groupLevel--;
				break;

			default:
				$m = strtoupper($type)."\t";
				
				if( ! $raw)
					$m .= "{$backtrace['class']}: ";

				$args = array_map([$this, '_filter'], $args);
				$m .= implode(' ', $args);

				if($this->_config['error_log'] ?? true)
					error_log($m);
				break;
		}
	}
	private $_groupLevel = 0;
	private function _filter($arg)
	{
		if(is_scalar($arg))
			return $arg;
		else
			return json_encode($arg);
	}


	
	/**
	 * Helper: ConsoleLog wrapper with some extras.
	 */
	protected function _consoleLog(array $backtrace, string $type, bool $raw, array $args)
	{
		if($type == 'trace')
			$type = 'log';

		if( ! $raw)
		{
			// Add caller as header/first argument
			$caller = $backtrace['class'];
			array_unshift($args, "$caller:");
		}

		// TODO: Already have backtrace here, so make a private subclass of ConsoleLog that gets that passed in instead?
		$this->_console->$type(...$args);
	}
}
