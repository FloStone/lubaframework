<?php

use FloStone\MySQL\MySQL;
use Config;

class SQL
{
	public static function __callStatic($func, $args)
	{
		return call_user_func_array([
			new MySQL(
				Config::get('DB_HOSTNAME'),
				Config::get('DB_USERNAME'),
				Config::get('DB_PASSWORD'),
				Config::get('DB_DATABASE'),
				Config::get('SQL_NEW_INSTANCE')
			), $func
		], $args);
	}
}