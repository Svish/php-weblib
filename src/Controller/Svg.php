<?php

namespace Controller;

use Error\PageNotFound;
use HTTP, Log;


/**
 * Handles serving of SVG files.
 */
class Svg extends Cached
{
	use \Candy\SafePath;

	const DIR = 'src'.DS.'_icons'.DS;
	const OPTS = ['fill', 'opacity'];

	// Cached should cache these
	protected $parameter_whitelist = self::OPTS;



	private $_file;
	public function before(array &$info)
	{
		$this->_file = self::safe(self::DIR.$info['params'][1]);
		parent::before($info);
	}



	protected function cache_valid($cached_time)
	{
		return parent::cache_valid($cached_time)
		   and $cached_time >= filemtime($this->_file);
	}
	


	public function get($filename)
	{
		// Load file
		$doc = new \DOMDocument;
		$doc->load($this->_file);

		// Set id attribute
		$svg = $doc->documentElement;
		$svg->setAttribute('id', $filename);

		// Extra stuff
		$opts = array_whitelist($_GET ?? [], self::OPTS);
		foreach($opts as $a => $v)
			$svg->setAttribute($a, $v);

		// Output
		header('Content-Type: image/svg+xml; charset=utf-8');
		$doc->save('php://output');
	}
}
