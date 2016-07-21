<?php

namespace Luba\Exceptions;

class ControllerNotFoundException extends \Exception
{
	public function __construct($controller)
	{
		http_response_code(500);
		parent::__construct("Class $controller not found!");
	}
}