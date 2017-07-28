<?php

/**
 * Wraps up and adds messages to session.
 *
 *     Message::ok('db-migrated', $version);
 * 
 * @uses Text
 */
class Message
{
	const SESSION_KEY = 'messages';

	public static function __callStatic($type, $args)
	{
		$key = array_shift($args);
		return self::add($type, Text::$type($key, $args));
	}

	private static function add($type, $text)
	{
		Session::append('messages', get_defined_vars());
	}

	public static function exception(Exception $e)
	{
		return self::add('error', $e->getMessage());
	}
}
