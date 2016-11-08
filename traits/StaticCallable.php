<?php

namespace Luba\Traits;

trait StaticCallable
{
	public static function __callStatic($func, $args)
	{
		$class = isset(static::$class) ? static::$class : NULL;
		$singleton = isset(static::$singleton) ? static::$singelton : false;

		return call_user_func_array([$singleton ? $class::getInstance() : new $class, $func], $args);
	}
}