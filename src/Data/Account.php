<?php
namespace Data;
use Log;

/**
 * Stuff expected by Model\Accounts.
 */
interface Account
{
	public function has_roles(string ...$roles): bool;
	
	public function make_token();

	public function verify_password(string $password): bool;
	public function verify_token(string $token): bool;
}
