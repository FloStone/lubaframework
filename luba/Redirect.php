<?php

namespace Luba\Framework;

class Redirect
{
	public static function to($url, $type = 302)
	{
		return header("Location: $url");
	}

	public static function external($url, $type = 302)
	{
		$url = \URL::other($url);

		return header("Location: $url");
	}

	public function getRedirectHeader($type)
	{
		if ($type == 301)
			header("HTTP/1.1 301 Moved Permanently");
	}
}