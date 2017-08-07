<?php

namespace View\Helper;

use Mustache_LambdaHelper;
use Model;
use Security as S;


/**
 * Helper: Role
 * 
 *  - Show only to given role
 *  
 *    {{#_s.admin}}Shown to admin only{{/role.admin}}
 * 
 * - Throws exception if not role
 * 
 *    {{_s.admin}}
 * 
 */
class Security
{
	private $_role;

	public function __construct(string $role = null)
	{
		$this->_role = $role;
	}

	public function __invoke($text = null, Mustache_LambdaHelper $render = null)
	{
		// Do a check and potentially output our "insides"
		if($text && $render)
		{
			if(S::check($this->_role ?: 'login'))
				return $render ? $render($text) : $text;
		}
		// Do a require
		else
		{
			S::require($this->_role ?: 'login');
		}
		return null;
	}


	private $_roles;
	public function __get($role)
	{
		return $this->_roles[$role]
			?? $this->_roles[$role] = new self($role);
	}	
	public function __isset($key)
	{
		return true;
	}

}
