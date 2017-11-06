<?php

use Luba\Traits\StaticCallable;

class URL
{
	use StaticCallable;

	protected static $class = \Luba\Framework\URL::class;

	protected static $singleton = true;
}