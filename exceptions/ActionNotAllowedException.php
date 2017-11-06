<?php

namespace Luba\Exceptions;

class ActionNotAllowedException extends \Exception
{
	public function __construct(string $action, string $controller)
	{
		http_response_code(500);
		parent::__construct("Action \"$action\" is not an allowed action in $controller");
	}
}