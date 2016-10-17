<?php

use Luba\Framework\Auth as BaseAuth;

class Auth
{
	public static function __callStatic($func, $args)
	{
		$auth = new BaseAuth();

		return call_user_func_array([$auth, $func], $args);
	}
}