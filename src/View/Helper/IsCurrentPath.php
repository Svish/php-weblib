<?php

namespace View\Helper;
use Mustache_LambdaHelper;


/**
 * Helper: Is Current
 * 
 * Menu hack for selecting active menu item.
 * 
 *     <a href="{{#isCurrentPath}}path1{{/isCurrentPath}}">1</a>
 *     <a href="{{#isCurrentPath}}path2{{/isCurrentPath}}">2</a>
 */
class IsCurrentPath
{
	public function __invoke($text, Mustache_LambdaHelper $render = null)
	{
		$text = $render ? $render($text) : $text;

		$item = explode('/', $text);
		$path = explode('/', trim(PATH, '/'));

		if(reset($item) == reset($path))
			return $text.'" class="current';

		return $text;
	}
}
