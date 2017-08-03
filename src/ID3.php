<?php

/**
 * ID3 instance.
 */
class ID3
{
	/**
	 * 
	 */
	const NAMES = [
		'unsynchronised_lyric' => 'lyrics',
		'release_time' => 'released',
		'creation_date' => 'date',
		'band' => 'album_artist',
	];



	/**
	 * @return string More common name for ID3 tag names.
	 */
	public static function name(string $tag_name): string
	{
		return self::NAMES[$tag_name] ?? $tag_name;
	}



	/**
	 * @return string More common name for ID3 tag names.
	 */
	public static function join($value, string $glue = ' / '): string
	{
		return is_array($value)
			? implode($glue, $value)
			: $value;
	}



	private static $_i;
	public static function instance()
	{
		if( ! self::$_i)
			self::$_i = new getID3;
		return self::$_i;
	}
}
