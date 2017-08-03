<?php


/**
 * Validator.
 * 
 * TODO: Tests.
 */
class Valid
{
	public static function check_array(array $subject, iterable $rule_set)
	{
		static::check(new Data($subject), $rule_set);
	}

	public static function check(Data $subject, iterable $rule_set)
	{
		$errors = [];
		foreach($rule_set as $property => $rules)
		{
			$value = $subject->$property;
			if(is_string($rules))
				$rules = [$rules];

			// If allowed empty, and value is empty, skip other rules
			if( ! in_array('not_empty', $rules) and static::empty($value))
				continue;


			foreach($rules as $rule)
			{
				// Get method and params
				if(is_array($rule))
				{
					$method = array_shift($rule);
					$params = $rule;
					array_unshift($params, $value);
				}
				else
				{
					$method = $rule;
					$params = [$value];
				}

				// Try self if string and not callable
				if(is_string($method) && ! is_callable($method))
					$method = [Valid::class, $method];

				// Append subject to parameters
				array_push($params, $property, $subject);

				// Call validation method
				if( ! $method(...$params))
				{
					// Add error text
					array_shift($params);
					if(is_array($method))
						$method = implode(is_object($method[0]) ? '->' : '::', $method);
					$errors[$property] = Text::validation($method, $params);
					break;
				}
			}
		}

		// Throw if any errors found
		if($errors)
		{
			Log::warn($errors);
			throw new Error\ValidationFailed($errors, $subject);
		}
	}



	public static function keys_exist(array $value, array $keys): bool
	{
		foreach($keys as $key)
			if( ! array_key_exists($key, $value))
				return false;
		return true;
	}



	public static function max_length($value, int $length): bool
	{
		return ! $value || strlen($value) <= $length;
	}

	public static function min_length($value, int $length): bool
	{
		return $value && strlen($value) >= $length;
	}



	public static function empty($value): bool
	{
		return in_array($value, [null, false, '', []], true);
	}



	public static function not_empty($value): bool
	{
		return ! static::empty($value);
	}



	public static function contains($value, $require): bool
	{
		foreach($value as $x)
			if(empty(array_intersect($x, $require)))
				return false;

		return true;
	}



	public static function phone($value): bool
	{
		return preg_match('/^\+?\d+$/', $value);
	}



	public static function email($value): bool
	{
		// TODO: Use https://github.com/egulias/EmailValidator?
		return strpos($value, '@') > 0;
	}

	public static function email_domain($value): bool
	{
		// Check if the email domain has a valid MX record
		return $value && (bool) checkdnsrr(preg_replace('/^[^@]++@/', '', $value), 'MX');
	}



	public static function http_ok($value): bool
	{
		$r = HTTP::head($value);

		if($r == false)
			return false;

		return $r->info['http_code'] >= 200
			&& $r->info['http_code'] <  300;
	}

	public static function integer($value): bool
	{
		return preg_match('/^-?\d+$/', $value);
	}


	public static function within($value, $min, $max): bool
	{
		return $value >= $min && $value <= $max;
	}

	/**
	 * @see http://www.geekality.net/?p=3022
	 */
	public static function flexi_time($value): bool
	{
		$valid = preg_match('/^'.static::FLEXI_TIME.'$/', $value, $x);
		
		if( ! $valid)
			return false;

		extract($x);

		// Check month
		if($month ?? null AND ! static::within($month, 1, 12))
			return false;

		// Check date
		if($day ?? null AND ! checkdate($month, $day, $year))
			return false;

		// Check hour
		if($hour ?? null AND ! static::within($hour, 0, 23))
			return false;

		// Check minute
		if($min ?? null AND ! static::within($min, 0, 59))
			return false;

		// Check second
		if($sec ?? null AND ! static::within($sec, 0, 59))
			return false;

		return true;
	}
	const FLEXI_TIME = '(?<year>\d{4})(?:-(?<month>\d{2})(?:-(?<day>\d{2})(?: (?<hour>\d{2}):(?<min>\d{2})(?::(?<sec>\d{2}))?)?)?)?';
}
