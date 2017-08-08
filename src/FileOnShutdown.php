<?php

/**
 * Writes/Appends to a file on shutdown.
 */
class FileOnShutdown
{
	private $_file;
	private $_append;
	private $_contents;

	public function __construct(string $file, bool $append = true)
	{
		$this->_file = $file;
		$this->_append = $append;
		register_shutdown_function([$this, 'flush']);
	}


	public function put(string $data): string
	{
		return $this->_contents = $data;
	}


	public function append(string $data, string $prefix = "\r\n"): string
	{
		if($this->_contents)
			$this->_contents .= $prefix;

		return $this->_contents .= $data;
	}


	public function flush()
	{
		$m = $this->_append ? 'append' : 'put';
		if($this->_contents)
			File::$m($this->_file, $this->_contents);
	}
}
