<?php

namespace Luba\Traits;

trait StaticCallable
{
	public static function __callStatic($method, $args)
	{
		return call_user_func_array([self::getInstance(), $method], $args);
	}
}