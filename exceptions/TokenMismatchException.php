<?php

namespace Luba\Exceptions;

class TokenMismatchException extends \Exception
{
	public function __construct()
	{
		http_response_code(500);
		parent::__construct('Token Mismatch!');
	}
}