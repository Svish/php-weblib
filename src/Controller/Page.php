<?php

namespace Controller;
use HTTP, View;
use Message, Log;

/**
 * Controller: catch-all
 */
class Page extends Secure
{
	protected $view;

	public function __construct()
	{
		$view = 'View\\'.str_replace('/', '\\', ucwords(PATH));
		if(is_subclass_of($view, View::class))
			$this->view = $view;
	}

	public function get()
	{
		Log::trace("Using {$this->view}");
		$view = $this->view ?? \View\Layout::class;
		return (new $view)->output();
	}


	public static function error(\Error\HttpException $e, array $context = [])
	{
		HTTP::set_status($e);
		Message::exception($e);

		if($e instanceof \Error\ValidationFailed)
			$context += ['errors' => $e->errors];

		return View::layout($context)->output();
	}
}
