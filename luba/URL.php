<?php

namespace Luba\Framework;

use Luba\Traits\Singleton;
use Luba\Interfaces\SingletonInterface;

class URL implements SingletonInterface
{
	use Singleton;

	/**
	 * Key for route mapping
	 *
	 * @var string
	 */
	protected $routeKey;

	/**
	 * Action of the controller to use
	 *
	 * @var string
	 */
	protected $controllerAction;

	/**
	 * Parameters for route action
	 *
	 * @var array
	 */
	protected $params;

	/**
	 * Inputs of the request
	 *
	 * @var array
	 */
	protected $inputs = [];

	/**
	 * Full URL
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * Full URI
	 *
	 * @var string
	 */
	protected $uri;

	/**
	 * Previous URL
	 *
	 * @var string
	 */
	protected $previous;

	/**
	 * Initialization
	 *
	 * @return void
	 */
	public function __construct()
	{
		self::setInstance($this);
		
		$request = Request::getInstance();
		$this->uri = rtrim($request->uri(), '/') . "/";
		$this->url = $request->scheme() . "://" . rtrim($request->root(), '/') . $this->uri;

		$urlParts = explode('?', $request->uri());

		if (isset($urlParts[1]))
			parse_str($urlParts[1], $this->inputs);
		else
			$this->inputs = [];
		$uri = explode('/', ltrim($urlParts[0], '/'));
        $this->uri = $urlParts[0];
		$routeKey = array_shift($uri);

		$this->routeKey = $routeKey == "" ? '/' : $routeKey;
		$controllerAction = array_shift($uri);
		$this->controllerAction = $controllerAction;
		$this->params = $uri;
	}

	/**
	 * Get the route key
	 *
	 * @return string
	 */
	public function routeKey()
	{
		return $this->routeKey;
	}

	/**
	 * Get the controller action
	 *
	 * @return string
	 */
	public function controllerAction()
	{
		return $this->controllerAction;
	}

	/**
	 * Return the parameters
	 *
	 * @return array
	 */
	public function params()
	{
		return $this->params;
	}

	/**
	 * Return the inputs
	 *
	 * @return array
	 */
	public function inputs()
	{
		return $this->inputs;
	}

	/**
	 * Create an absloute URL
	 *
	 * @param string $uri
	 * @param array $params
	 * @return string
	 */
	public function make($uri = NULL, array $params = [])
	{
		if (!empty($params))
			$params = http_build_query($params);

		$request = Request::getInstance();
		$scheme = $request->scheme();
		$root = $request->root();
		$uri = rtrim(ltrim($uri, '/'), '/');
		if ($uri == '/')
			$uri = "";
		else
			$uri = "$uri/";

		return empty($params) ? "$scheme://$root$uri": "$scheme://$root$uri?$params";
	}

	/**
	 * Get the full URL
	 *
	 * @return string
	 */
	public function full()
	{
		return $this->url;
	}

	/**
	 * Get the full URI
	 *
	 * @return string
	 */
	public function uri()
	{
		return $this->uri;
	}
}