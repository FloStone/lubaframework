<?php

namespace Luba\Exceptions;

class ControllerNotFoundException extends LubaException
{
	public function __construct(string $controller)
	{
		parent::__construct("Class $controller not found!", 500);
	}
}