<?php

namespace Luba\Exceptions;

class TokenMismatchException extends LubaException
{
	public function __construct()
	{
		parent::__construct('Token Mismatch!', 500);
	}
}