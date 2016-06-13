<?php

namespace Luba\Exceptions;

class ControllerActionNotFoundException extends \Exception
{
	public function __construct($action, $controller)
	{
		parent::__construct("Action \"$action\" does not exist in $controller");
	}
}