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
	const MD_REF = '/]\(ref=([^)]++)\)/';

	private $_url;


	public function __construct()
	{
		$url = Config::bibleRefs(INI_SCANNER_RAW)[LOCALE]['search'];
		$this->_url = $url;
	}

	public function __invoke(string $ref, Helper $render = null)
	{
		$ref = $render ? $render($ref) : $ref;
		$ref = urlencode($ref);
		return str_replace(self::KEY, $ref, $this->_url);
	}

	public function md_replace(string $markdown)
	{
		return preg_replace_callback(self::MD_REF, [$this, '_replace'], $markdown);
	}

	private function _replace(array $m)
	{
		$ref = $this($m[1]);
		return "]($ref)";
	}
}
