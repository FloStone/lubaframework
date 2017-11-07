<?php

use Luba\Traits\StaticCallable;

class Config
{
	use StaticCallable;

	protected static $class = \Luba\Framework\LubaConfig::class;
}