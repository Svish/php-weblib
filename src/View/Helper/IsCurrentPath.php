<?php

namespace View\Helper;
use Mustache_LambdaHelper;


/**
 * Helper: Is Current Path
 * 
 * Menu hack for marking current menu item.
 * 
 *     <a href="path1" class="{{#_icp}}path1{{/_icp}}">1</a>
 *     <a href="path2" class="{{#_icp}}path2{{/_icp}}">2</a>
 */
class IsCurrentPath
{
	public function __invoke($text, Mustache_LambdaHelper $render = null)
	{
		$text = $render ? $render($text) : $text;

		$item = explode('/', $text);
		$path = explode('/', trim(PATH, '/'));

		if(reset($item) == reset($path))
			return 'current';

		return $text;
	}
}
