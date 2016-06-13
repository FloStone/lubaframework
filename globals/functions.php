<?php

use Symfony\Component\VarDumper\VarDumper;
use Flo\MySQL\MySQL;

function dd()
{
	$args = func_get_args();

	array_map(function($x){
		(New VarDumper)->dump($x);
	}, $args);
	
	die;
}

function sql()
{
	global $mysql_var;
	
	if (!$mysql_var)
		$mysql_var = MySQL::connect(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	return $mysql_var;
}

function controller($name)
{
	$controller = 'Luba\Controllers\\'.$name;
	return new $controller;
}