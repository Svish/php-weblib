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

		// TODO: use substr + strpos instead
		$text = explode("\r\n", $text);
		array_shift($text);
		return implode("\r\n", $text);
	}
}
