<?php

namespace Email;
use Log;

class SwiftLoggerPlugin extends \Swift_Plugins_LoggerPlugin
{
	public function __construct()
	{
		parent::__construct(new SwiftLogger);
	}
}
