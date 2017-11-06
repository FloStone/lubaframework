<?php

namespace Luba\Exceptions;

class HttpNotFoundException extends \Exception
{
	public function __construct(string $url)
	{
		http_response_code(404);
		parent::__construct("The URL \"$url\" was not found on this server!");
	}
}