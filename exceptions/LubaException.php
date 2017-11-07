<?php

namespace Luba\Exceptions;

class LubaException extends \Exception
{
	public function __construct($message, $code = 500)
	{
		parent::__construct($message, $code);
	}
}