<?php

namespace Luba\Framework;

use Luba\Exceptions\HttpNotFoundException;

class Router
{
	/**
	 * Controller action
	 *
	 * @var string
	 */
	protected $action;

	/**
	 * Controller
	 *
	 * @var Controller
	 */
	protected $controller;

	/**
	 * Collection of routes
	 *
	 * @var array
	 */
	protected $routes;

	/**
	 * Controller action parameters
	 *
	 * @param array $params
	 */
	protected $params = [];

	/**
	 * Route to controller binding
	 *
	 * @var string
	 */
	protected $route;

	/**
	 * Initialization
	 *
	 * @param Application $app
	 */
	public function __construct()
	{
		$this->routes = $this->getRoutes();
	}

	/**
	 * Get the registered routes
	 *
	 * @return void
	 */
	public function getRoutes()
	{
		return include base_path('routes.php');
	}

	/**
	 * Route the URL to the bound controller
	 *
	 * @return void
	 * @throws HttpNotFoundException
	 */
	public function make()
	{
		$url = URL::getInstance();
		$this->route = $url->routeKey();
		$params = $url->params();

		if (isset($this->routes[$this->route]))
		{
			$this->controller = controller($this->routes[$this->route]);

			$controllerActionRoute = $url->controllerActionRoute();

			if ($controllerActionRoute == "")
			{
				$this->action = 'index';
				return $this->routeToAction();
			}
			else
			{
				$this->action = $controllerActionRoute;
				$this->params = $params;
				return $this->routeToAction();
			}
		}
		else
			throw new HttpNotFoundException($this->route);
	}

	/**
	 * Route to a given method in a controller
	 *
	 * @param string $action
	 * @param Controller $controller
	 * @throws ControllerActionNotFoundException
	 */
	public function routeToAction()
	{
		$action = $this->action;

		if (method_exists($this->controller, $action))
		{
			if ($this->controller->actionIsAllowed($action))
				return call_user_func_array([$this->controller, $action], $this->params);
		}
		else
			throw new ControllerActionNotFoundException($action, $this->controller);
	}
}