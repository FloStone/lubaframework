<?php

use Luba\Traits\StaticCallable;

class Session
{
	use StaticCallable;

	protected static $class = \Luba\Framework\Session::class;
}