<?php
namespace View;

use Config;
use Controller\Svg;
use Mustache\IteratorPresenter as Presenter;


/**
 * Json error response.
 * 
 * @see Error\Handler
 */
class About extends Layout
{
	public function credits()
	{
		return new Presenter(Config::credits(), true);
	}


	public function icons()
	{
		foreach(Svg::credits() as $svg)
			$list[$svg['url']] = $svg;

		array_sort_by('author', $list);
		return $list;
	}

	// TODO Show locale? Etc?
	/*
	var_dump(
		get_defined_vars(),
		get_defined_constants(true)['user'],
		setlocale(LC_ALL, 0),
		I18N::instance());
	*/
}


