<?php

namespace Luba\Framework;

class Session
{
	public static function start()
	{
		session_start();
	}

	public static function get($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
	}

	public static function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}
}