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

	public static function remove($key)
	{
		if (isset($_SESSION[$key]))
			unset($_SESSION[$key]);
	}

	public function has($key)
	{
		return isset($_SESSION[$key]);
	}

	public function flush()
	{
		foreach($_SESSION as $key => $value)
		{
			unset($_SESSION[$key]);
		}
	}

	public static function destroy()
	{
		session_destroy();
	}
}