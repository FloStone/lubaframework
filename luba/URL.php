<?php

namespace Luba\Framework;

use Luba\Traits\StaticCallable;
use Luba\Traits\Singleton;
use Luba\Interfaces\SingletonInterface;

class URL implements SingletonInterface
{
	use StaticCallable, Singleton;

	protected $routeKey;

	protected $controllerActionRoute;

	protected static $instance;

	protected $params;

	protected $inputs = [];

	public function __construct()
	{
		self::setInstance($this);
		
		$request = Request::getInstance();
		$urlParts = explode('?', $request->uri());

		if (isset($urlParts[1]))
			parse_str($urlParts[1], $this->inputs);
		else
			$this->inputs = [];
		
		$uri = explode('/', ltrim($urlParts[0], '/'));

		$this->routeKey = array_shift($uri);
		$controllerAction = array_shift($uri);
		$this->controllerActionRoute = $controllerAction == NULL ? '/' : $controllerAction;
		$this->params = $uri;
	}

	public function routeKey()
	{
		return $this->routeKey;
	}

	public function controllerActionRoute()
	{
		return $this->controllerActionRoute;
	}

	public function params()
	{
		return $this->params;
	}

	public function inputs()
	{
		return $this->inputs;
	}
}