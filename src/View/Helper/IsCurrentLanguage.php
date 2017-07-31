<?php

namespace View\Helper;
use Mustache_LambdaHelper;


/**
 * Helper: Is Current Language
 * 
 * Menu hack for marking current language menu item.
 * 
 *     <a href="path1" class="{{#_icp}}path1{{/_icp}}">1</a>
 *     <a href="path2" class="{{#_icp}}path2{{/_icp}}">2</a>
 */
class IsCurrentLanguage
{
	public function __invoke($text, Mustache_LambdaHelper $render = null)
	{
		$text = $render ? $render($text) : $text;

		return $text === LANG
			? 'current'
			: null;
	}
}
