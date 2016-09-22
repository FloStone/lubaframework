<?php

namespace Luba\Framework;

class Redirect
{
	public static function to($url)
	{
		return header("Location: $url");
	}

	public static function external($url)
	{
		$url = \URL::other($url);

		return header("Location: $url");
	}
}