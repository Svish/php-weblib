<?php
namespace Cache\Validator;

/**
 * Checks if TTL has passed.
 */
class Time
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
	public function __invoke($time)
	{
		$age = time() - $time;
		$valid = $age <= $this->ttl;
		
		if( ! $valid)
			Log::trace("Age={$age} is older than TTL={$this->ttl}");

		return $valid;
	}
}
