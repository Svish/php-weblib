<?php

namespace View\Helper;
use Session, Message, Mustache;

/**
 * Helper: Returns HTML for current messages.
 */
class Messages
{
	public function __invoke()
	{
		$m = Session::unget(Message::SESSION_KEY, []);
		return Mustache::engine()
			->render('messages', [
				'list' => $m,
				'fl' => new Fl,
				'rf' => new Flr,
				'admin' => new Role('admin'),
				]);
	}
}
