<?php

namespace Luba\Framework;

use Luba\Exceptions\ControllerNotFoundException;
use Luba\Exceptions\ControllerActionNotFoundException;
use Luba\Exceptions\HttpNotFoundException;

class Application
{
	/**
	 * base path of the application
	 *
	 * @var string
	 */
	protected $basePath;

	/**
	 * Collection of routes
	 *
	 * @var array
	 */
	protected $routes = [];

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
	 * Initialize class
	 *
	 * @param string $basepath
	 */
	public function __construct($basepath)
	{
		$this->basePath = $basepath;
		$this->getRoutes();
	}

	/**
	 * Run the application
	 *
	 * @return void
	 */
	public function run()
	{
		$this->router();
	}

	/**
	 * Get the registered routes
	 *
	 * @return void
	 */
	public function getRoutes()
	{
		$this->routes = include $this->basePath.'/routes.php';
	}

	/**
	 * Route the URL to the bound controller
	 *
	 * @return void
	 * @throws HttpNotFoundException
	 */
	public function router()
	{
		$params = explode('/', ltrim($_SERVER['REQUEST_URI'], '/'));
		$route = explode('?', array_shift($params))[0];
		$this->route = $route == "" ? '/' : $route;

		if (isset($this->routes[$this->route]))
		{
			$this->controller = controller($this->routes[$this->route]);

			if (empty($params) or $params[0] == "")
			{
				$this->action = 'index';
				$this->routeToAction();
			}
			else
			{
				$this->action = array_shift($params);
				$this->params = $params;
				$this->routeToAction();
			}
		}
		else
			throw new HttpNotFoundException($action);
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
				$this->renderAction(call_user_func_array([$this->controller, $action], $this->params));
		}
		else
			throw new ControllerActionNotFoundException($action, $this->controller);
	}

	/**
	 * Render out the returned controller action
	 *
	 * @return void
	 */
	public function renderAction($action)
	{
		if (is_string($action))
			e($action);
		if ($action instanceof View or $action instanceof \View)
			e($action);
		if ($action instanceof Redirect or $action instanceof \Redirect)
			return true;
	}

	/**
	 * Return the apps base path
	 *
	 * @return string
	 */
	public function basePath()
	{
		return $this->basePath;
	}
}