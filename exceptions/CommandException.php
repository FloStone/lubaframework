<?php

namespace Luba\Exceptions;

class CommandException extends LubaException
{
	public function __construct(string $message)
	{
		parent::__construct($message, 500);
	}
}