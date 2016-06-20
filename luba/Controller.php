<?php

namespace Luba\Framework;

use Luba\Exceptions\ActionNotAllowedException;
use Luba\Framework\View;

class Controller
{
	/**
	 * Allowed actions to be called by URLs
	 *
	 * @var array
	 */
	protected static $actions = [];

	/**
	 * String representation
	 *
	 * @return string
	 */
	public function __tostring()
	{
		return get_class($this);
	}

	/**
	 * Check if the called method is allowed
	 *
	 * @param string $action
	 * @return bool
	 * @throws ActionNotAllowedException
	 */
	final public function actionIsAllowed($action)
	{
		if (array_search($action, static::$actions) === false)
			throw new ActionNotAllowedException($action, get_called_class());

		return true;
	}

	/**
	 * Return a view
	 *
	 * @param string $template
	 * @param array $variables
	 * @return View
	 */
	public function view($template, array $variables = [])
	{
		return new View($template, $variables);
	}

	/**
	 * Redirect to another URL
	 *
	 * @return response
	 */
	public function redirect($url)
	{
		header("Location: $url");
	}
}