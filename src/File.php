<?php

use Error\Oops;

/**
 * File helper.
 * 
 *  - Uses flock to (hopefully) prevent any issues with
 *      potentially simultaneous writes.
 *
 * @see http://php.net/manual/en/function.fopen.php
 * @see http://php.net/manual/en/function.flock.php
 */
class File
{
	/**
	 * Gets data from $file.
	 * 
	 * @return mixed Returns data if files exists; otherwise $default.
	 */
	public static function get(string $file, $default = NULL)
	{
		if( ! file_exists($file))
			return $default;
		
		$fp = fopen($file, 'r');
		flock($fp, LOCK_SH);
		$size = filesize($file);
		if($size > 0)
			$contents = fread($fp, $size);
		flock($fp, LOCK_UN);
		fclose($fp);

		return $contents ?? '';
	}


	/**
	 * Puts $data in $file.
	 * 
	 * @return string Returns $data for chaining.
	 */
	public static function put(string $file, string $data): string
	{
		if(empty($file))
			throw new Oops(__METHOD__.' called with empty file.');

		self::mkdir(dirname($file));

		$fp = fopen($file, 'c');
		flock($fp, LOCK_EX);
		ftruncate($fp, 0);
		fwrite($fp, $data);
		fflush($fp);
		flock($fp, LOCK_UN);
		fclose($fp);

		return $data;
	}

	/**
	 * Appends $data to $file.
	 * 
	 * @return string Returns $data for chaining.
	 */
	public static function append(string $file, string $data, string $postfix = "\r\n"): string
	{
		if(empty($file))
			throw new Oops(__METHOD__.' called with empty file.');

		self::mkdir(dirname($file));

		$fp = fopen($file, 'a');
		flock($fp, LOCK_EX);
		fwrite($fp, $data.$postfix);
		fflush($fp);
		flock($fp, LOCK_UN);
		fclose($fp);

		return $data;
	}



	/**
	 * Creates $dir if not existing, otherwise does nothing.
	 * 
	 * @return string Returns $dir for chaining
	 * @see https://en.wikipedia.org/wiki/Chmod#System_call
	 */
	public static function mkdir(string $dir): string
	{
		if( ! is_dir($dir))
		{
			@mkdir($dir, 06750, true);
			@chmod($dir, 06750);
		}
		return $dir;
	}




	/**
	 * Recursively deletes $directory.
	 * 
	 * @param string $dir Directory to delete
	 * @param bool|bool $keep_self If false, $dir will also be deleted.
	 */
	public static function rdelete(string $dir, bool $keep_self = false): void
	{
		if( ! is_dir($dir))
			return;

		$it = new RecursiveDirectoryIterator($dir,FilesystemIterator::SKIP_DOTS);
		$it = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::CHILD_FIRST);
 
		foreach($it as $file)
			if($file->isDir())
				@rmdir($file->getRealPath());
			else
				@unlink($file->getRealPath());

		if( ! $keep_self)
			@rmdir($dir);
	}
}
