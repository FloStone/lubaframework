<?php

use Luba\Framework\URL as BaseURL;

class URL
{
	public static function __callStatic($method, $args)
	{
		return call_user_func_array([BaseURL::getInstance(), $method], $args);
	}
}