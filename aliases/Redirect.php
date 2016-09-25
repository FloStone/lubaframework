<?php

use Luba\Framework\Redirect as BaseRedirect;

class Redirect
{
	public static function __callStatic($func, $args)
	{
		return call_user_func_array([new BaseRedirect, $func], $args);
	}
}