<?php
namespace Model;
use Data\Account;
use Error\NotFound;
use Session, Model, Valid;

/**
 * Model: Accounts.
 * 
 * Handles logins and such.
 */
abstract class Accounts extends Model
{
	const SESSION_KEY = 'user';
	private static $_user = null;

	public abstract function get($id = null);

	/**
	 * Try login user.
	 */
	public function login(array $data): Account
	{		
		extract($_POST, EXTR_SKIP);

		// Check if user exists
		$user = $this->get($email ?? null);
		if( ! $user)
			throw new \Error\UnknownLogin();

		// Check password
		if( ! $user->verify_password($password ?? null))
			throw new \Error\UnknownLogin();

		// Login
		return $this->_login($user);
	}



	/**
	 * Login via link.
	 */
	public function login_token(array $data): Account
	{
		if( ! Valid::keys_exist($data, ['id', 'token']))
			throw new \Error\UnknownResetToken();

		extract($data, EXTR_SKIP);

		// Check if user exists
		$user = $this->get($id);
		if( ! $user)
			throw new \Error\UnknownResetToken();

		// Check token
		if( ! $user->verify_token($token))
			throw new \Error\UnknownResetToken();

		// Login
		return $this->_login($user);
	}
	
	private function _login(Account $user): Account
	{
		Session::set(self::SESSION_KEY, $user->id);
		return $user;
	}



	/**
	 * Logout user.
	 */
	public function logout()
	{
		Session::unset(self::SESSION_KEY);
	}



	/**
	 * Get logged in user; false if not logged in.
	 */
	public function logged_in()
	{
		// Already checked this request
		if(self::$_user !== null)
			return self::$_user;

		// Supposed to be logged in
		$id = Session::get(self::SESSION_KEY);
		if( ! $id )
			return self::$_user = false;

		// User (still) exists?
		try
		{
			$user = self::$_user ?? $this->get($id);
		}
		catch(NotFound $e)
		{
			return self::$_user = false;
		}

		// Can (still) login?
		if( ! $user->has_roles('login'))
			return self::$_user = false;

		// Return user
		return self::$_user = $user;
	}
}
