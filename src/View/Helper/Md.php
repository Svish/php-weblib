<?php

namespace View\Helper;
use Mustache_LambdaHelper;
use Markdown;

/**
 * Helper: Markdown
 * 
 * Renders markdown text
 * 
 *     {{#md}}{{summary}}{{/md}}
 */
class Md
{
	public function __invoke($text, Mustache_LambdaHelper $render = null)
	{
		if($render)
			$text = $render($text);

		return Markdown::instance()->render($text);
	}
}
