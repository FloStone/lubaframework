<?php

use Luba\Traits\StaticCallable;

class Request
{
	use StaticCallable;

	protected static $class = \Luba\Framework\Request::class;

	protected static $singleton = true;
}