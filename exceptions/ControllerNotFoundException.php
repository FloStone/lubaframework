<?php

namespace Luba\Exceptions;

class ControllerNotFoundException extends \Exception
{
	public function __construct($controller)
	{
		$dir = 
		parent::__construct("Class $controller not found!");
	}
}