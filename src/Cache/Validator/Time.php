<?php
namespace Cache\Validator;

use Log;


/**
 * Invalidates if TTL has passed.
 * 
 * TODO: Tests.
 */
class Time implements \Cache\Validator
{
	protected $ttl;

	/**
	 * @param $ttl Max age in seconds.
	 */
	public function __construct($ttl)
	{
		$this->ttl = (int)$ttl;
	}

	/**
	 * @return FALSE if $time is older than TTL.
	 */
	public function __invoke(int $time): bool
	{
		$age = time() - $time;
		Log::trace("Checking TTL {$this->ttl} > {$age}");
		$valid = $age <= $this->ttl;
		
		if( ! $valid)
			Log::trace("Age={$age} is older than TTL={$this->ttl}");

		return $valid;
	}
}
