<?php

namespace View\Helper;
use Config, Model, Mustache;

/**
 * Helper: Clicky
 * 
 * Returns HTML for Clicky tracking code.
 * 
 *         {{{clicky}}}
 *     </body>
 *
 * @see https://clicky.com/stats/prefs-tracking-code
 * 
 * @uses Config clicky
 */
class Clicky
{
	public function __invoke()
	{
		$config = Config::clicky()[ENV] ?? false;

		if($config)
		{
			$config['user'] = Model::users()->logged_in();
			
			return Mustache::engine()
				->render('clicky', $config);
		}
	}
}
