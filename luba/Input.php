<?php

namespace Luba\Framework;

class Input
{
	public static function get($index = NULL)
	{
		if (is_null($index))
			return $_GET;

		if (isset($_GET[$index]))
			return $_GET[$index];
		else
			return NULL;
	}

	public static function post($index = NULL)
	{
		if (is_null($index))
			return $_POST;

		if (isset($_POST[$index]))
			return $_POST[$index];
		else
			return NULL;
	}
}