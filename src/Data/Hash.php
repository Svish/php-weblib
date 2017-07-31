<?php

namespace Data;
/**
 * Computes a hash of another property.
 * 
 *     $this->computed( new Hash('password', 'token') );
 */
class Hash extends Computed
{
	const ALGO = PASSWORD_DEFAULT;
	const ALGO_OPT = [];


	protected function _set(string $key, $value)
	{
		$hash = password_hash($value, self::ALGO, self::ALGO_OPT);
		yield "{$key}_hash" => $hash;
	}

	protected function _unset(string $key)
	{
		yield "{$key}_hash";
	}

	public static function needs_rehash(string $hash): bool
	{
		return password_needs_rehash($hash, self::ALGO, self::ALGO_OPT);
	}
}
