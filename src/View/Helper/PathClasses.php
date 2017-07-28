<?php

namespace View\Helper;

/**
 * Helper: Path Classes
 * 
 * Returns the path as CSS classes.
 * 
 *     <body class="{{pathClasses}}">
 */
class PathClasses
{
	public function __invoke()
	{
		if(PATH == 'index')
			return 'index front';
		return str_replace('/', ' ', PATH);
	}
}
