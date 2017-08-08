<?php

# Simple utility functions

/**
 * @return string HTML5 encode string.
 */
function html_encode(string $subject): string
{
	return htmlspecialchars($subject, ENT_HTML5);
}

/**
 * @return string $subject After running $callback on all matches.
 */
function preg_match_all_callback(string $pattern, string $subject, callable $callback, ...$callback_parameters)
{
	$r = preg_match_all($pattern, $subject, $matches, PREG_SET_ORDER);
	foreach($matches ?? [] as $match)
		$callback($match, ...$callback_parameters);
	return $r;
}

/**
 * @return string Class name of $obj, without namespaces.
 */
function get_class_name($obj): string
{
	if(is_object($obj))
		$obj = get_class($obj);
	return substr(strrchr('\\'.$obj, '\\'), 1);
}



/**
 * @return string Truncates the $subject
 */
function str_truncate(string $subject, int $max_length, string $append = '…')
{
	return strlen($subject) > $max_length
		? substr($subject, 0, $max_length) . $append
		: $subject;
}


function str_indent(string $subject, string $chr = "\t")
{
	return preg_replace("/^/m", $chr, $subject);
}


/**
 * @return string Safe strval that (should) accept anything.
 */
function strval_any($subject): string
{
	if(is_object($subject))
		return get_class($subject);

	if(is_array($subject))
	{
		$str = json_encode($subject, JSON_UNESCAPED_UNICODE|JSON_NUMERIC_CHECK);
		return str_truncate($str, 35);
	}

	return strval($subject);
}


function iterable_reverse(iterable $it)
{
	foreach($it as $item)
		$list[] = $item;

	if(isset($list))
		while(!is_null($item = array_pop($list)))
			yield $item;
}


/**
 * @return mixed Array without rejected items.
 */
function array_reject(array $array, callable $callback)
{
	$good = [];
	foreach($array as $item)
		if( ! $callback($item))
			$good[] = $item;
	return $good;
}



/**
 * @return mixed The removed item.
 */
function array_remove(array &$array, $key)
{
	$value = $array[$key] ?? null;
	unset($array[$key]);
	return $value;
}



/**
 * @return array Flattened array.
 */
function array_flatten(array $array): array
{
	$it = new \RecursiveArrayIterator($array);
	$it = new \RecursiveIteratorIterator($it);
    return iterator_to_array($it, false);
}


/**
 * Checks if $array contains any of $wanted.
 * @param array $array 
 * @param array $wanted 
 * @return type
 */
function array_any(array $array, array $wanted): bool
{
	return array_intersect($array, $wanted) !== [];
}



/**
 * Same as array_map, but the extra parameters
 * will be passed to the callback function
 * after the item.
 */
function array_map_callback(array $array, callable $callback, ...$extra_parameters)
{
	foreach($array as $key => $value)
		$array[$key] = $callback($value, ...$extra_parameters);
}



/**
 * Same as array_map, but a variable number of callbacks in parameter order.
 */
function array_map_callbacks(array $array, callable ...$callbacks): array
{
	foreach($callbacks as $callback)
		foreach($array as $key => $value)
			$array[$key] = $callback($value);

	return $array;
}



/**
 * Returns only items in $array whose key exists in $whitelist.
 */
function array_whitelist(array $array, array $whitelist)
{
	return array_intersect_key($array, array_flip($whitelist));
}

/**
 * Returns all items in $array except whose key exists in $blacklist.
 */
function array_blacklist(array $array, array $blacklist)
{
	return array_diff_key($array, array_flip($blacklist));
}



/**
 * Sorts the arrays/objects by key.
 */
function array_sort_by($key, array &$subject)
{
	return usort($subject, function($x, $y) use ($key)
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



/**
 * Groups the array by $key.
 */
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



/**
 * @return bool True if $haystack starts with $needle.
 */
function starts_with(string $needle, string $haystack): bool
{
	return $needle === "" 
		|| strpos($haystack, $needle) === 0;
}



/**
 * @return bool True if $haystack ends with $needle.
 */
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
