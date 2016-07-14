<?php

use Symfony\Component\VarDumper\VarDumper;
use Flo\MySQL\MySQL;
use Luba\Framework\Application;
use Luba\Framework\View;
use Luba\Framework\URL;

/**
 * Die and dump
 *
 * @return void
 */
if (!function_exists('dd'))
{
	function dd()
	{
		$args = func_get_args();

		array_map(function($x){
			(New VarDumper)->dump($x);
		}, $args);
		
		die;
	}
}

/**
 * Make an SQL statement
 *
 * @return Flo\MySQL\MySQL
 */
if (!function_exists('sql'))
{
	function sql()
	{
		global $mysql_instnc;
		
		if (!$mysql_instnc)
			$mysql_instnc = MySQL::connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

		return $mysql_instnc;
	}
}

/**
 * Get a Controller instance
 *
 * @param string $name
 * @return Controller
 */
if (!function_exists('controller'))
{
	function controller($name)
	{
		$controller = '\\Luba\\Controllers\\'.$name;
		return new $controller;
	}
}

/**
 * Get the base application path
 *
 * @param string $path
 * @return string
 */
if (!function_exists('base_path'))
{
	function base_path($path = NULL)
	{
		return app()->basePath() . $path;
	}
}

/**
 * Get the public application path
 *
 * @param string $path
 * @return string
 */
if (!function_exists('public_path'))
{
	function public_path($path = NULL)
	{
		return base_path('public/') . ltrim($path, '/');
	}
}

/**
 * Get an asset
 *
 * @param string $asset
 * @return string
 */
if (!function_exists('asset'))
{
	function asset($asset)
	{
		$asset = ltrim($asset, '/');
		return rtrim(url("$asset"), '/');
	}
}

/**
 * Create an absolute URL
 *
 * @param string $url
 * @param array $attributes
 * @return string
 */
if (!function_exists('url'))
{
	function url($uri = NULL, array $params = [])
	{
		return URL::getInstance()->make($uri, $params);
	}
}

/**
 * Get the view application path
 *
 * @param string $path
 * @return string
 */
if (!function_exists('view_path'))
{
	function view_path($path)
	{
		return base_path('views/') . $path;
	}
}

/**
 * Register the application
 *
 * @param Luba\Framework\Application $instance
 * @return void
 */
if (!function_exists('registerApplication'))
{
	function registerApplication(Application $instance)
	{
		global $application_instnc;

		if (!$application_instnc)
			$application_instnc = $instance;
	}
}

/**
 * Return the Application instance
 *
 * @return Luba\Framework\Applicatio
 */
if (!function_exists('app'))
{
	function app()
	{
		//global $application_instnc;

		return Luba\Framework\Application::getInstance(); //$application_instnc;
	}
}

/**
 * Echo using escaped strings
 *
 * @param string $string
 * @return string
 */
if (!function_exists('e'))
{
	function e($string)
	{
		echo htmlspecialchars($string);
	}
}

/**
 * Create a random string
 *
 * @param int $length
 * @return string
 */
if (!function_exists('str_random'))
{
	function str_random($length = 10)
	{
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';

	    for ($i = 0; $i < $length; $i++)
	    {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }

	    return $randomString;
	}
}

/**
 * Create a form token
 *
 * @return string
 */
if (!function_exists('form_token'))
{
	function form_token()
	{
		$token = str_random(9);
		Session::set('__formtoken', $token);

		return $token;
	}
}