<?php

namespace View\Helper;
use Mustache_LambdaHelper;

/**
 * Helper: URL
 * 
 * Makes absolute URLs.
 * 
 *     {{#url}}some/path{{/url}}
 *         => /base/some/path
 * 
 *     {{#url}}/some/path{{/url}}
 *         => http://host/base/some/path
 */
class Url
{
	/**
	 * Returns $url prefixed with WEBBASE, or WEBROOT if starting with /.
	 *
	 *     foo   => /base/foo
	 *     /foo  => http://host/base/foo
	 */
	public function __invoke($url = null, Mustache_LambdaHelper $render = null)
	{
		if($render)
			$url = $render($url);

		return strpos($url, '/') === 0
			? WEBROOT.ltrim($url, '/')
			: WEBBASE.$url;
	}
}
	
