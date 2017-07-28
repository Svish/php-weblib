<?php

namespace Email;
use Log;

class SwiftLogger implements \Swift_Plugins_Logger
{
	public function add($entry)
	{
		$entry = trim($entry);
		return Log::trace_raw($entry);
	}

	public function clear() {}
	public function dump() {}
}
