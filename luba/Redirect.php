<?php

namespace Luba\Framework;

class Redirect
{
	public static function to($url, $type = 302)
	{
		static::getRedirectType($type);

		return header("Location: $url");
	}

	public static function external($url, $type = 302)
	{
		$url = \URL::other($url);
		static::getRedirectType($type);
		
		return header("Location: $url");
	}

	public static function getRedirectHeader($type)
	{
		if ($type == 301)
			header("HTTP/1.1 301 Moved Permanently");
	}
}