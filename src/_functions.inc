<?php

# Simple utility functions

function preg_match_all_callback(string $pattern, string $subject, callable $callback, ...$callback_parameters)
{
	$r = preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
	foreach($matches ?? [] as $match)
		$callback($match, ...$callback_parameters);
	return $r;
}

function get_class_name($obj)
{
	if(is_object($obj))
		$obj = get_class($obj);
	return substr(strrchr('\\'.$obj, '\\'), 1);
}

function str_truncate(string $str, int $max_length, string $append = '…')
{
	return strlen($str) > $max_length
		? substr($str, 0, $max_length) . $append
		: $str;
}

function strval_any($anything): string
{
	if(is_object($anything))
		return get_class($anything);

	if(is_array($anything))
	{
		$str = json_encode($anything, JSON_NUMERIC_CHECK);
		return str_truncate($str, 35);
	}

	return strval($anything);
}

function array_remove(array &$array, $key)
{
	$value = $array[$key] ?? null;
	unset($array[$key]);
	return $value;
}

function array_flatten(array $array)
{
	$it = new \RecursiveArrayIterator($array);
	$it = new \RecursiveIteratorIterator($it);
    return iterator_to_array($it, false);
}

function array_map_callback(array $array, callable $callback, ...$extra_parameters)
{
	foreach($array as $key => $value)
		$array[$key] = $callback($value, ...$extra_parameters);
}

function array_map_callbacks(array $array, callable ...$callbacks): array
{
	foreach($callbacks as $callback)
		foreach($array as $key => $value)
			$array[$key] = $callback($value);

	return $array;
}

function array_whitelist(array $array, array $whitelist)
{
	return array_intersect_key($array, array_flip($whitelist));
}

function array_blacklist(array $array, array $blacklist)
{
	return array_diff_key($array, array_flip($blacklist));
}

function array_sort_by($key, array &$array)
{
	return usort($array, function($x, $y) use ($key)
	{
		$x = is_array($x)
			? $x[$key] ?? null
			: $x->$key ?? null;

		$y = is_array($y)
			? $y[$key] ?? null
			: $y->$key ?? null;
		return strnatcasecmp($x, $y);
	});
}

function array_group_by(string $key, $list, bool $keep_key = false, string $key_name = null, string $group_name = 'items'): array
{
	$groups = [];
	foreach($list as $value)
	{
		$group = $value[$key] ?? '';

		if( ! $keep_key)
			unset($value[$key]);

		if( ! isset($groups[$group]))
			$groups[$group][$key_name ?? $key] = $group;

		$groups[$group][$group_name][] = $value;
	}

	return array_values($groups);
}


function starts_with(string $needle, string $haystack): bool
{
	return $needle === "" 
		|| strpos($haystack, $needle) === 0;
}

function ends_with(string $needle, string $haystack): bool
{
	return $needle === "" 
		|| substr($haystack, -strlen($needle)) === $needle;
}

/**
 * #rrggbb or #rgb to [r, g, b]
 */
function hex2rgb(string $hex): array
{
	$hex = ltrim($hex, '#');

	if(strlen($hex) == 3)
		return [
			hexdec($hex[0].$hex[0]),
			hexdec($hex[1].$hex[1]),
			hexdec($hex[2].$hex[2]),
		];
	else
		return [
			hexdec($hex[0].$hex[1]),
			hexdec($hex[2].$hex[3]),
			hexdec($hex[4].$hex[5]),
		];
}

/**
 * [r, g, b] to #rrggbb
 */
function rgb2hex(array $rgb): string
{
	return '#'
		. sprintf('%02x', $rgb[0])
		. sprintf('%02x', $rgb[1])
		. sprintf('%02x', $rgb[2]);
}