<?php

namespace Luba\Framework;

class Auth
{
	public static function login($username, $password)
	{
		$user = sql()->table(AUTH_TABLE)->select()->where(AUTH_USERNAME_COLUMN, addslashes($username))->where(AUTH_PASSWORD_COLUMN, static::hash($password))->get()->first();

		if ($user)
		{
			Session::set('__auth_user', $user);

			return true;
		}

		return false;
	}

	public static function check()
	{
		return Session::has('__auth_user');
	}

	public static function logout()
	{
		Session::remove('__auth_user');
	}

	public static function hash($string)
	{
		return hash(AUTH_HASH, $string);
	}

	public static function user()
	{
		return Session::get('__auth_user');
	}
}