<?php

namespace Luba\Framework;

class Session
{
	public function start()
	{
		session_start();
	}

	public function get($key)
	{
		return isset($_SESSION[$key]) ? $_SESSION[$key] : NULL;
	}

	public function set($key, $value)
	{
		$_SESSION[$key] = $value;
	}

	public function remove($key)
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

	public function destroy()
	{
		session_destroy();
	}

	public function all()
	{
		return $_SESSION;
	}
}