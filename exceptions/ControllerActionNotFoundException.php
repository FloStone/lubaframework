<?php

namespace Luba\Exceptions;

class ControllerActionNotFoundException extends LubaException
{
	public function __construct(string $action, string $controller)
	{
		parent::__construct("Action \"$action\" does not exist in $controller", 404);
	}
}