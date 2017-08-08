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
	use \Candy\Instance;
	

	const DIR = ROOT.'.logs'.DS;
	const EXT = '.log';
	const TYPES = [
		'group',
		'groupEnd',
		'error',
		'warn',
		'info',
		'trace',
	];



	private $_console;
	private $_file;
	private function __construct()
	{
		$this->_console = new ConsoleLog(4);

		$logfile = ENV !== 'dev'
			? ENV.'.'.date('Y-m-d')
			: ENV;
		$this->_file = new FileOnShutdown(self::DIR.$logfile.self::EXT, true);
		$this->_file->put('---');
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
		$backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS)[2] ?? null;		

		// Get type and "raw"
		$raw = ends_with('_raw', $type);
		$type = $raw ? substr($type, 0, -4) : $type;

		// Check type
		if( ! in_array($type, self::TYPES))
			throw new Exception("Unsupported log type: $type");

		// Console logging
		self::instance()->_consoleLog($backtrace, $type, $raw, $args);

		// File logging
		self::instance()->_fileLog($backtrace, $type, $raw, $args);
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
				$m = (new DateTime)->format('Y-m-d H:i:s.v')."\t";
				$m .= strtoupper($type)."\t";

				if( ! $raw)
					$m .= ($backtrace['class'] ?? '.') . ': ';

				$args = array_map([$this, '_filter'], $args);
				$m .= implode(' ', $args);

				$this->_file->append($m);
				break;
		}
	}
	private $_groupLevel = 0;
	private function _filter($arg)
	{
		if(is_scalar($arg))
			return $arg;
		if(is_array($arg))
			return trim(substr(print_r($arg, true), 7, -2));
		else
			return print_r($arg, true);
	}

	

	/**
	 * Helper: ConsoleLog wrapper with some extras.
	 */
	protected function _consoleLog(array $backtrace, string $type, bool $raw, array $args)
	{
		// HACK: Something following here crashes on one.com... :/
		if(ENV !== 'dev')
			return;

		if($type == 'trace')
			$type = 'log';

		if( ! $raw)
		{
			// Add caller as header/first argument
			$caller = $backtrace['class'] ?? '{main}';
			array_unshift($args, "$caller:");
		}

		// TODO: Already have backtrace here, so make a private subclass of ConsoleLog that gets that passed in instead?
		$this->_console->$type(...$args);
	}
}
