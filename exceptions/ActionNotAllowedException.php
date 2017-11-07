<?php

namespace Luba\Exceptions;

class ActionNotAllowedException extends LubaException
{
	public function __construct(string $action, string $controller)
	{
		parent::__construct("Action \"$action\" is not an allowed action in $controller", 500);
	}
}