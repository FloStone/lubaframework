<?php

use Flo\MySQL\MySQL;

class SQL
{
	protected static $sqlInstance;

	public static function __callStatic($func, $args)
	{	
		if (!self::$sqlInstance)
			self::$sqlInstance = MySQL::connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		return call_user_func_array([self::$sqlInstance, $func], $args);
	}
}