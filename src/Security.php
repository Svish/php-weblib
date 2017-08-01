<?php
/**
 * Security class.
 * 
 * @uses Model::users()->logged_in(): $user
 * @uses $user->has_roles(array $roles): bool
 */
class Security
{
	/**
	 * Checks if logged in and has required roles.
	 *
	 * @throws Unauthorized If not logged in.
	 * @throws Forbidden If not having required roles
	 */
	public static function require(array $roles): bool
	{
		Log::trace("Requiring", $roles, '…');
		self::log_backtrace();

		// Get logged in user
		$user = Model::users()->logged_in();

		// Redirect if not logged in
		if( ! $user)
		{
			Log::trace('User not logged in.');
			throw new \Error\Unauthorized();
		}

		// Always require login role
		array_unshift($roles, 'login');

		// Check roles
		if( ! $user->has_roles(...$roles))
		{
			Log::warn('Requires:', $roles, '; Has:', $user->roles);
			throw new \Error\Forbidden($roles);
		}

		return true;
	}


	/**
	 * Checks if logged in and has required roles.
	 *
	 * @throws Unauthorized If not logged in.
	 * @throws Forbidden If not having required roles
	 */
	public static function check(string ...$roles): bool
	{
		Log::trace("Checking for", $roles, '…');
		self::log_backtrace();

		$user = Model::users()->logged_in();

		if( ! $user)
		{
			Log::trace('User not logged in.');
			return false;
		}

		array_unshift($roles, 'login');
		if( ! $user->has_roles(...$roles))
			return false;

		return true;
	}

	private static function log_backtrace()
	{
		$back = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3)[2];
		Log::trace_raw(" └ Called from {$back['class']}->{$back['function']}");
	}
}
