<?php

namespace Controller;
use HTTP, View, Message;

/**
 * Handles normal pages.
 */
class Page extends Secure
{
	public function get()
	{
		return View::layout()->output();
	}


	protected function error(\Error\HttpException $e, array $context = [])
	{
		HTTP::set_status($e);
		Message::exception($e);

		if($e instanceof \Error\ValidationFailed)
			$context += ['errors' => $e->errors];

		return View::layout($context)->output();
	}
}
