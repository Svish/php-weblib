<?php

namespace Controller;

use Error\PageNotFound;
use HTTP, Log;

use DOMDocument as Xml;
use RecursiveDirectoryIterator as Iterator;
use RecursiveHiddenFilterIterator as Reject;
use RecursiveExtensionFilterIterator as Accept;
use RecursiveIteratorIterator as Recursor;


/**
 * Handles serving of SVG files.
 */
class Svg extends Cached
{
	use \Candy\SafePath;

	const EXT = '.svg';
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
		$xml = new Xml;
		$xml->load($this->_file);

		// Set id attribute
		$svg = $xml->documentElement;
		$svg->setAttribute('id', $filename);

		// Extra stuff
		$opts = array_whitelist($_GET ?? [], self::OPTS);
		foreach($opts as $a => $v)
			$svg->setAttribute($a, $v);

		// Output
		header('Content-Type: image/svg+xml; charset=utf-8');
		$xml->save('php://output');
	}



	public static function index(): iterable
	{
		$it = new Iterator(self::DIR, Iterator::SKIP_DOTS);
		$it = new Reject($it);
		$it = new Accept($it, self::EXT);
		$it = new Recursor($it);

		return $it;
	}

	public static function credits(): iterable
	{
		foreach(self::index() as $key => $file)
		{
			$svg = new Xml;
			$svg->load($file);
			$svg = $svg->documentElement;

			$author = $svg->getAttributeNS('credits', 'author');
			$url = $svg->getAttributeNS('credits', 'url');

			if($author && $url)
				yield [
					'file' => $key,
					'author' => $author,
					'url' => $url,
				];
			else
				Log::warn($key, 'is lacking credit attributes.');
		}
	}
}
