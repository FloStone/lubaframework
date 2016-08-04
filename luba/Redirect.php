<?php

namespace Luba\Framework;

class Redirect
{
	public static function to($url)
	{
		return header("Location: $url");
	}
}