<?php

namespace View\Helper;

/**
 * Helper: First Line Rest
 * 
 * Removes the first line and returns the rest.
 * 
 *     {{text | flr}}
 */
class Flr
{
	public function __invoke($text, $render = null)
	{
		if($render)
			$text = $render($text);

		$text = preg_split(Fl::NL, $text, -1, PREG_SPLIT_NO_EMPTY);
		array_shift($text);
		return implode("\r\n", $text);
	}
}
