<?php
namespace View;

use Config;

use RecursiveArrayIterator as Iterator;
use PathableRecursiveIteratorIterator as Recursor;
use DateTime;


/**
 * Json error response.
 * 
 * @see Error\Handler
 */
class I18n extends Layout
{
	public function __construct()
	{
		$this->formats();

		parent::__construct();
	}

	public function formats()
	{
		$it = new Iterator(Config::dateFormats());
		$it = new Recursor($it);

		$date = new DateTime();
		$it->rewind();
		while($it->valid())
		{
			yield [
				'key' => $it->getPath(' / '),
				'val' => $it->current(),
				'txt' => $date->format($it->current()),
			];
			$it->next();
		}
	}
}


