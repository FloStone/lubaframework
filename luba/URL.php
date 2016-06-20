<?php

namespace Luba\Framework;

use Luba\Traits\Singleton;
use Luba\Interfaces\SingletonInterface;

class URL implements SingletonInterface
{
	use Singleton;

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
		$routeKey = array_shift($uri);
		$this->routeKey = $routeKey == "" ? '/' : $routeKey;
		$controllerAction = array_shift($uri);
		$this->controllerActionRoute = $controllerAction;
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

	public function make($uri = NULL)
	{
		$request = Request::getInstance();
		$scheme = $request->scheme();
		$root = $request->root();
		$uri = rtrim(ltrim($uri, '/'), '/');

		return "$scheme://$root$uri/";
	}
}