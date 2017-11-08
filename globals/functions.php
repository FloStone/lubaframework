<?php

use Symfony\Component\VarDumper\VarDumper;
use FloStone\MySQL\MySQL;
use Luba\Framework\{Application, View, URL, Controller};

define('HUHU', 'HUHU');

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
 * Get a Controller instance
 *
 * @param string $name
 * @return Controller
 */
if (!function_exists('controller'))
{
	function controller(string $name) : Controller
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
	function base_path(string $path = NULL) : string
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
	function public_path(string $path = NULL) : string
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
	function asset(string $asset) : string
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
	function url(string $uri = NULL, array $params = []) : string
	{
		return URL::make($uri, $params);
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
	function view_path(string $path) : string
	{
		return base_path('views/') . $path;
	}
}

/**
 * Get the temp path
 *
 * @param string $path
 * @return string
 */
if (!function_exists('storage_path'))
{
	function storage_path(string $path = '') : string
	{
		return base_path('storage/') . $path;
	}
}

/**
 * Return the Application instance
 *
 * @return Luba\Framework\Applicatio
 */
if (!function_exists('app'))
{
	function app() : Application
	{
		return Application::getInstance();
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
	function e(string $string) : string
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
	function str_random(int $length = 10) : string
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