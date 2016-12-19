<?php

use Luba\Traits\StaticCallable;

class Request
{
	use StaticCallable;

	protected static $class = "Luba\Framework\Request";

	protected static $singleton = true;
}