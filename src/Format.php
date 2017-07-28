<?php

/**
 * Format helper.
 * 
 * Turns stuff into strings.
 */
class Format
{
	public static function bytes($size, $precision = 2): string
	{
		return self::si($size, 'B', $precision, 1024);
	}

	public static function si($number, $type = '', $precision = 2, $kilo = 1000): string
	{
		for($i=0; ($number / $kilo) > 0.9; $i++, $number /= $kilo);
		return round($number, $precision)
			 . ' '
			 . ['','k','M','G','T','P','E','Z','Y'][$i]
			 . $type;
	}
	
	public static function slug(string $text): string
	{
		$txt = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $txt);
		$txt = preg_replace('/\W+/', '-', $txt);
		$txt = trim($txt, '-');
		return strtolower($txt);
	}
}
