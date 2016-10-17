<?php

use Flo\MySQL\MySQL;

class SQL
{
	public static function __callStatic($func, $args)
	{
		return call_user_func_array([new MySQL(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, false), $func], $args);
	}
}