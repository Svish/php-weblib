<?php

namespace View\Helper;
use Session, Message, Mustache;

/**
 * Helper: Returns HTML for current messages.
 * 
 * TODO: Load async via js.
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
				'_s' => new Security('admin'),
				]);
	}
}
