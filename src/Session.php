<?php

/**
 * Session helper.
 *
 * @see Session fixation: http://stackoverflow.com/a/5081453/39321
 */
class Session
{
	const ID = 'session';


	public static function append($key, $value)
	{
		if( ! session_id())
			self::start();

		Log::trace("Append", $key, $value);
		return $_SESSION[$key][] = $value;
	}

	public static function unget($key, $default = null)
	{
		Log::trace("Unget", $key, $default);

		$value = self::get($key, $default);
		self::unset($key);
		return $value;
	}

	public static function get($key, $default = null)
	{
		if( ! session_id())
			self::start();

		Log::trace("Get", $key, $default);
		return $_SESSION[$key] ?? $default;
	}

	public static function set($key, $value)
	{
		if( ! session_id())
			self::start();

		Log::trace("Setting", $key, $value);
		return $_SESSION[$key] = $value;
	}

	public static function unset($key)
	{
		if( ! session_id())
			self::start();

		Log::trace("Unset", $key);
		unset($_SESSION[$key]);
	}

	public static function start()
	{
		Log::trace('Starting session['.self::ID.']…');
		session_name(self::ID);
		session_start();
	}

	public static function close()
	{
		if(session_name())
		{
			Log::trace('Closing session['.self::ID.']…');
			session_write_close();
		}
	}

	public static function destroy()
	{
		self::start();
		Log::trace('Destroying session['.self::ID.']…');

		$_SESSION = array();
		
		if(ini_get("session.use_cookies"))
		{
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}

		session_destroy();
	}
}
