<?php

namespace Mustache\Loader;


/**
 * Custom FilesystemPartialsloader.
 * 
 * - Extracts whatever is in {{$ content}} block
 * - And if it does, naively decrease all headers by one
 * 
 */
class FilesystemPartials extends Filesystem
{
	protected function loadFile($name)
	{
		$tmpl = parent::loadFile($name);

		// Strip out other than content if BLOCKS file
		if(preg_match('%\{\{\$\s*content*\}\}(.+)\{\{\/\s*content*\}\}%s', $tmpl, $regs))
		{
			return self::demote_headers($regs[1]);
		}
		else
		{
			return $tmpl;
		}
	}

	private static function demote_headers($html)
	{
		$html = str_replace(self::H[3], self::H[4], $html);
		$html = str_replace(self::H[2], self::H[3], $html);
		$html = str_replace(self::H[1], self::H[2], $html);
		return $html;
	}

	const H = [null,
		['<h1>', '</h1>'],
		['<h2>', '</h2>'],
		['<h3>', '</h3>'],
		['<h4>', '</h4>'],
	];
}
