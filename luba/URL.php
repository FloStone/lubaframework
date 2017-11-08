<?php

namespace Luba\Framework;

use Session;

class URL
{
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
	public function __construct($url = null, array $params = [])
	{
		$request = Request::getInstance();

		if ($url)
			$this->url = $this->parse($url, $params);
		else
			$this->url = $request->scheme() . '://' . $request->root() . ltrim($request->uri(), '/');
		parse_str(parse_url($this->url, PHP_URL_QUERY), $this->inputs);
		$this->uri = str_replace(str_replace("{$request->domain()}/" , '', $request->root()), '', ltrim(parse_url($this->url, PHP_URL_PATH), '/'));

		if ($this->uri == "")
			$this->uri = "/";

		$uri = explode('/', ltrim($this->uri, '/'));
		$routeKey = array_shift($uri);

		$this->routeKey = $routeKey == "" ? '/' : $routeKey;
		$controllerAction = array_shift($uri);
		$this->controllerAction = $controllerAction;
		$this->params = $uri;

		if (Session::has('__current_url'))
		{
			if (Session::get("__current_url") != $this->full())
			{
				$last = Session::get('__current_url');
				Session::set('__last_url', $last);
				Session::set('__current_url', $this->full());
			}
		}
		else
		{
			Session::set('__current_url', $this->full());
		}
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

	public function parse($uri, array $params = [])
	{
		if (!empty($params))
			$params = http_build_query($params);

		$request = Request::getInstance();
		$scheme = $request->scheme();
		$root = $request->root();
		$uri = rtrim(ltrim($uri, '/'), '/');

		if ($uri != '')
			$uri = "$uri";

		return empty($params) ? "$scheme://$root$uri": "$scheme://$root$uri?$params";
	}

	/**
	 * Create an absloute URL
	 *
	 * @param string $uri
	 * @param array $params
	 * @return string
	 */
	public static function make($uri = NULL, array $params = [])
	{
		if ($uri instanceof self)
			return $uri;

		return new self($uri, $params);
	}

	public function other($url, array $params = [])
	{
		if (!empty($params))
			$params = http_build_query($params);

		if (stripos($url, 'http') === false)
			$url = "http://$url";

		return $url;
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

	/**
	 * Get the url without parameters
	 * @return String
	 */
	public function withoutParams()
	{
		return \Request::scheme() . "://" . \Request::root() . ($this->uri() == "/" ? "" : $this->uri());
	}

	/**
	 * Get the previous url
	 * @return String
	 */
	public function previous()
	{
		return Session::has('__last_url') ? Session::get('__last_url') : null;
	}

	public function __toString()
	{
		return $this->full();
	}
}