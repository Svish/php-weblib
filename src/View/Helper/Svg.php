<?php

namespace View\Helper;

/**
 * Helper: SVG importer for Mustache templates.
 *
 * If the name includes a ";" everything
 * following it will be added to the <svg> 
 * tag as attributes.
 * 
 *     {{#svg}}send{{/svg}}
 * 
 *     {{#svg}}send;class="icon" id="send-icon"{{/svg}}
 * 
 * TODO: Pull file reading from this and controller to own Svg class.
 * 	- Should ignore comments and credits attributes
 *  - Output without whitespace
 */
class Svg
{
	const DIR = SRC.'_icons'.DS;

	public function __invoke($name, $render = null)
	{
		if($render)
			$name = $render($name);

		return $this->get($name);
	}

	protected function get($file)
	{
		$opt = explode(';', $file, 2);

		$file = self::DIR."{$opt[0]}.svg";
		$opt = $opt[1] ?? null;


		if( ! is_file($file))
			return "[svg=$opt]";
		$svg = file_get_contents($file);

		if($opt)
			$svg = str_replace('<svg ', "<svg $opt ", $svg);

		return $svg;
	}
}
