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
	public function __invoke($text, $render = null)
	{
		if($render)
			$text = $render($text);

		return explode("\r\n", $text, 2)[0];
	}
}
