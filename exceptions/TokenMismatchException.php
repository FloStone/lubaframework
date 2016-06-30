<?php

namespace Luba\Exceptions;

class TokenMismatchException extends \Exception
{
	public function __construct()
	{
		parent::__construct('Token Mismatch!');
	}
}