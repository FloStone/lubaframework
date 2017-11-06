<?php

namespace Luba\Framework;

use Flo\MySQL\MySQLResult;
use SQL;

class Auth
{
	public function login(string $username, string $password)
	{
		return $this->loginQuery(function($query) use ($username, $password){
			$query->where(AUTH_USERNAME_COLUMN, addslashes($username))->where(AUTH_PASSWORD_COLUMN, static::hash($password));
		});
	}

	public function check() : bool
	{
		return Session::has('__auth_user');
	}

	public function logout()
	{
		Session::remove('__auth_user');
	}

	public function hash($string)
	{
		return hash(AUTH_HASH, $string);
	}

	public function loginWithId($id)
	{
		return $this->loginQuery(function($query) use ($id){
			$query->find($id);
		});
	}

	public function loginWithCredentials(array $cred = [])
	{
		return $this->loginQuery(function($query) use ($cred){

			foreach ($cred as $key => $value)
			{
				$query->where($key, $value);
			}
		});
	}

	public function loginQuery(callable $query)
	{
		$user = SQL::table(AUTH_TABLE)->select();

		$query($user);

		$user = $user->first();

		if ($user)
		{
			Session::set('__auth_user', $user);

			return true;
		}

		return false;
	}

	public static function user()
	{
		return Session::get('__auth_user');
	}
}