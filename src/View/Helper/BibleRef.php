<?php

namespace View\Helper;

use Config;
use Mustache_LambdaHelper as Helper;


/**
 * Helper: Bible Ref
 * 
 * Adds search URL to bible references.
 * 
 */
class BibleRef
{
	const KEY = '%s';

	private $_url;

	public function __construct()
	{
		$config = Config::bibleRefs(INI_SCANNER_RAW);
		$this->_url = $config[LOCALE]['search'] ?? $config['search'];;
	}

	public function __invoke(string $ref, Helper $render = null)
	{
		$ref = $render ? $render($ref) : $ref;
		$ref = urlencode($ref);
		return str_replace(self::KEY, $ref, $this->_url);
	}
}
