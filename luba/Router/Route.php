<?php

namespace Luba\Framework\Router;

use Luba\Framework\URL;

class Route
{
	const CONTROLLER_ACTION = 'controller_action';
	const CONTROLLER = 'controller';
	const CALLBACK = 'callback';

	protected $uri;

	protected $action;

	protected $fullUri;

	protected $type;

	protected $controller;

	protected $parameters = [];

	protected $method;

	public function __construct(string $uri, $action)
	{
		$this->uri = $uri;
		$this->action = $action;
		$this->make();
	}

	public function make()
	{
		$baseUri = $this->uri;

		if (is_string($this->action))
		{
			$this->makeStringAction();
		}
		elseif (is_callable($this->action))
		{
			$this->makeCallableAction();
		}
	}

	public function makeStringAction()
	{
		if (strpos($this->action, '@') !== false)
		{
			$this->type = self::CONTROLLER_ACTION;

			$explode = explode('@', $this->action);
			$explodeBak = $explode;
			$class = array_shift($explode);
			$method = array_shift($explode);

			$this->controller = $class;
			$this->method = $method;

			preg_match_all('/{(\w*)}/', $this->uri, $params);
			$params = $params[1];

			$this->fullUri = $this->uri == '/' ? '/' : "/" . $this->uri . "/";
		}
		else
		{
			$this->type = self::CONTROLLER;
			$this->controller = $this->action;
			$this->fullUri = "/{$this->uri}/{action}/*/";

			$uri = URL::getInstance()->uri();
			$this->method = URL::getInstance()->controllerAction();
			$this->parameters = URL::getInstance()->params();
		}
	}

	public function makeCallableAction()
	{
		$this->type = self::CALLBACK;
		$uri = rtrim($this->uri, '/');
		$this->fullUri = "/$uri/";
	}

	/**
	 * Check if route is action
	 * @return boolean
	 */
	public function isAction() : bool
	{
		return $this->type == self::CONTROLLER_ACTION;
	}

	/**
	 * Check if route is callback
	 * @return boolean
	 */
	public function isCallback() : bool
	{
		return $this->type == self::CALLBACK;
	}

	/**
	 * Check if route is controller
	 * @return boolean
	 */
	public function isController() : bool
	{
		return $this->type == self::CONTROLLER;
	}

	public function uri()
	{
		return $this->uri;
	}

	/**
	 * Get the full url
	 * @return string
	 */
	public function fullUri() : string
	{
		return $this->fullUri;
	}

	public function getAction()
	{
		return $this->action;
	}

	public function controller()
	{
		return $this->controller;
	}

	public function method() : string
	{
		return $this->method;
	}

	public function params() : array
	{
		return $this->parameters;
	}
}