<?php

namespace Luba\Exceptions;

class HttpNotFoundException extends LubaException
{
	public function __construct(string $url)
	{
		parent::__construct("The URL \"$url\" was not found on this server!", 404);
	}
}