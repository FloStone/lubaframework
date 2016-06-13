<?php

namespace Luba\Framework;

use Luba\Exceptions\ActionNotAllowedException;

class Controller
{
	protected static $actions = [];

	public function __tostring()
	{
		return get_class($this);
	}

	final public function actionIsAllowed($action)
	{
		if (array_search($action, static::$actions) === false)
			throw new ActionNotAllowedException($action, get_called_class());

		return true;
	}
}