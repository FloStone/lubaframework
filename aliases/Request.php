<?php

use Luba\Framework\Request as BaseRequest;

class Request
{
	public static function __callStatic($func, $args)
	{
		return call_user_func_array([BaseRequest::getInstance(), $func], $args);
	}
}