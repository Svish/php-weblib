<?php
namespace Data;
use Log;

/**
 * Stuff expected by Model\Accounts.
 */
trait Account_
{
	public function has_roles(string ...$roles): bool
	{
		$mine = $this->roles;

		foreach($roles as $role)
			if( ! in_array($role, $mine))
				return false;

		return true;
	}


	public function verify_password(string $password): bool
	{
		// Verify password
		if( ! password_verify($password, $this->password_hash))
		{
			Log::trace("Password rejected for $this.");
			return false;
		}
		Log::trace("Password accepted for $this.");

		// Rehash if necessary
		if(Hash::needs_rehash($this->password_hash))
		{
			$this->password = $password;
			Log::info("Rehashed password for $this. Saving…");
			$this->save();
		}

		return true;
	}


	public function make_token()
	{
		$this->token = bin2hex(random_bytes(16));
		Log::info("Made reset token for $this. Saving…");
		$this->save();
	}
	

	public function verify_token(string $token): bool
	{
		$good = password_verify($token, $this->token_hash);

		// TODO: Add a TTL for valid tokens
		if($good)
		{
			Log::trace("Token accepted for $this. Removed and saving…");
			unset($this->token);
			$this->save();
		}
		else
			Log::trace("Token rejected for $this.");

		return $good;
	}
}
