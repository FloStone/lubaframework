<?php

namespace Luba\Framework\Router;

use Luba\Exceptions\HttpNotFoundException;
use Luba\Exceptions\ControllerActionNotFoundException;

use Luba\Framework\URL;

class Router
{
	/**
	 * Controller action
	 *
	 * @var string
	 */
	protected $action;

	/**
	 * Collection of routes
	 *
	 * @var array
	 */
	protected $routeCollection;

	/**
	 * Controller action parameters
	 *
	 * @param array $params
	 */
	protected $params = [];

	/**
	 * URL
	 *
	 * @var string
	 */
	protected $url;

	/**
	 * Initialization
	 *
	 * @param Application $app
	 */
	public function __construct()
	{
		$this->routeCollection = $this->getRoutes();
	}

	/**
	 * Get the registered routes
	 *
	 * @return void
	 */
	public function getRoutes()
	{
		$routes = include base_path('routes.php');

		$collection = new RouteCollection;

		foreach ($routes as $uri => $action)
		{
			$route = new Route($uri, $action);
			if ($route->isAction())
				$collection->addAction($route);
			elseif ($route->isCallback())
				$collection->addCallback($route);
			elseif ($route->isController())
				$collection->addController($route);
		}
		
		return $collection;
	}

	/**
	 * Route the URL to the bound controller
	 *
	 * @return void
	 * @throws HttpNotFoundException
	 */
	public function make()
	{
		// Get the URL isntance
		$url = URL::getInstance();
		$uri = explode('/', rtrim(ltrim($url->uri(), '/'), '/'));
		// Return a public file or asset if exists
		if (file_exists(public_path($url->uri())) && is_file(public_path($url->uri())))
			return public_path($url->uri());
		
		// Controller binding
		$action = $this->routeCollection->findController($url->routeKey());

		if ($action)
		{
			return $this->routeController($action);
		}
		else
		{
			// Callback action
			$action = $this->routeCollection->findCallback($url->uri());

			if ($action)
			{
				return $this->routeCallback($action);
			}
			else
			{
				// Controller action
				$action = $this->routeCollection->findAction($url->uri());

				if ($action)
				{
					return $this->routeAction($action);
				}
				else
				{
					throw new HttpNotFoundException($url->full());
				}
			}
		}
	}

	public function routeController(Route $action)
	{
		$controller = "\Luba\Controllers\\{$action->controller()}";

		$controller = new $controller;
		$method = $action->method() == '' ? 'index' : $action->method();

		if (method_exists($controller, $method) or $controller->isGlobal())
		{
			if ($controller->actionIsAllowed($method))
				return call_user_func_array([$controller, $method], $action->params());
		}
		else
			throw new ControllerActionNotFoundException($method, $controller);
	}

	public function routeCallback(Route $action)
	{
		$callback = $action->getAction();
		
		$parameters = $this->getparameters($action);

		return call_user_func_array($callback, $parameters);
	}

	public function routeAction(Route $action)
	{
		$controller = "\Luba\Controllers\\{$action->controller()}";
		$controller = new $controller;
		$parameters = $this->getParameters($action);

		return call_user_func_array([$controller, $action->method()], $parameters);
	}

	public function getParameters(Route $action)
	{
		$uri = URL::getInstance()->uri();
		$pattern = str_replace('/', '\/', ltrim(rtrim($action->fullUri(), '/'), '/'));
		
		preg_match("/$pattern/", $uri, $matches);

		array_shift($matches);

		return $matches;
	}
}