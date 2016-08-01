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
	protected $actions = [];

	/**
	 * Allowed post only actions
	 *
	 * @var array
	 */
	protected $post_actions = [];

	/**
	 * Allowed get only actions
	 *
	 * @var array
	 */
	protected $get_actions = [];

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
		$allowed = $this->checkAction($action);

		if (!$allowed)
			throw new ActionNotAllowedException($action, get_called_class());

		return true;
	}

	final public function checkAction($action)
	{
		if (array_search($action, $this->get_actions) !== false && strtolower(Request::getInstance()->method()) == 'get')
			return true;
		elseif (array_search($action, $this->post_actions) !== false && strtolower(Request::getInstance()->method()) == 'post')
			return true;
		elseif (array_search($action, $this->actions) !== false)
			return true;
		else
			return false;
	}

	/**
	 * Return a view
	 *
	 * @param string $template
	 * @param array $variables
	 * @return View
	 */
	final public function render($template, array $variables = [])
	{
		return new View($template, $variables);
	}

	/**
	 * Redirect to another URL
	 *
	 * @return response
	 */
	final public function redirect($url)
	{
		header("Location: $url");
	}
}