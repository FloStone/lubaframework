<?php

namespace Luba\Exceptions;

class HttpNotFoundException extends \Exception
{
	public function __construct($url)
	{
		parent::__construct("The URL \"$url\" was not found on this server!");
	}
}