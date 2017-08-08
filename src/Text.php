<?php

/**
 * Gets and formats text from the text.ini file.
 *
 * Examples: 
 * 
 *     Text::ok('email-sent');
 *     Text::error('within', [1, 10]);
 * 
 * TODO: Get localized text path from Path class?
 * 
 * @uses Config text
 */
class Text
{
	public static function __callStatic($header, $args)
	{
		$text = I18N::strings();

		$key = array_shift($args);
		$key = is_array($key) ? 'Array' : strval($key);
		$args = array_shift($args);

		$text = $text[$header][$key] ?? $key;


		// TODO: Move this to translate function (or just use gettext?)
		if(is_array($text))
			$text = implode("\r\n", $text);

		if(is_array($args))
			$args = array_map(['self', 'implode'], $args);

		return $args
			? vsprintf($text, $args)
			: $text;
	}

	private static function implode($item)
	{
		return is_array($item)
			? json_encode($item, JSON_UNESCAPED_UNICODE)
			: $item;
	}
}
