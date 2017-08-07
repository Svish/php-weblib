<?php

namespace View\Helper;
use Mustache_LambdaHelper as Helper;

/**
 * Helper: Title Trim
 * 
 * HACK: Trims spaces and dashes for missing title pages.
 */
class TitleTrim
{
	public function __invoke(string $txt, Helper $render = null)
	{
		$txt = $render ? $render($txt) : $txt;
		var_dump($txt);exit;
	}
}
