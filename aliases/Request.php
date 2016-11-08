<?php

use Luba\Traits\StaticCallable;

class Request
{
	use StatcCallable;

	protected static $class = "Luba\Framework\Request";

	protected static $singleton = true;
}