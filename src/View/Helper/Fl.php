<?php

namespace View\Helper;

/**
 * Helper: FirstLine
 * 
 * Returns the first line of text.
 * 
 *     {{text | fl}}
 */
class Fl
{
	const NL = '/(?:\r\n|\n|\r)/';

	public function __invoke($text, $render = null)
	{
		if($render)
			$text = $render($text);

		if( ! $text)
			return $text;

		return preg_split(self::NL, $text, 2, PREG_SPLIT_NO_EMPTY)[0];
	}
}
