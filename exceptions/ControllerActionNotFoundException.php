<?php

namespace Luba\Exceptions;

class ControllerActionNotFoundException extends \Exception
{
	public function __construct($action, $controller)
	{
		http_response_code(404);
		parent::__construct("Action \"$action\" does not exist in $controller");
	}
}