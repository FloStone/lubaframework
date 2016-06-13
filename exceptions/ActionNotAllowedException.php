<?php

namespace Luba\Exceptions;

class ActionNotAllowedException extends \Exception
{
	public function __construct($action, $controller)
	{
		parent::__construct("Action \"$action\" is not an allowed action in $controller");
	}
}