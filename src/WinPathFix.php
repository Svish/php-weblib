<?php

define('IS_WIN', stripos(PHP_OS, 'win') === 0);

/**
 * Methods for fixing paths if on windows.
 * 
 *     $system_path = self::to_win($unicode_path);
 *     $unicode_path = self::from_win($system_path);
 */
trait WinPathFix
{
	private static function to_win(string $path): string
	{
		$path = str_replace(['/', '\\'], DS, $path);
		return IS_WIN ? utf8_decode($path) : $path;
	}
	
	private static function from_win(string $path, bool $strip_path = false): string
	{
		if($strip_path)
			$path = str_replace(ROOT, '', $path);

		$path = str_replace(['/', '\\'], '/', $path);
		return IS_WIN ? utf8_encode($path) : $path;
	}
}
