<?php

namespace Luba\Framework\Router;

use FloStone\MySQL\Collection;

class RouteCollection extends Collection
{
	public function __construct(array $routes = [])
	{
		$this->data = [
			'actions' => [],
			'controllers' => [],
			'callbacks' => []
		];

		if (isset($routes['callbacks']))
		{
			foreach ($routes['callbacks'] as $uri => $action)
			{
				$route = new Route($uri, $action, Route::CALLBACK);
				$this->addCallback($route);
			}
		}

		if (isset($routes['actions']))
		{
			foreach ($routes['actions'] as $uri => $action)
			{
				$route = new Route($uri, $action, Route::CONTROLLER_ACTION);
				$this->addAction($route);
			}
		}
		if (isset($routes['controllers']))
		{
			foreach ($routes['controllers'] as $uri => $action)
			{
				$route = new Route($uri, $action, Route::CONTROLLER);
				$this->addController($route);
			}
		}
	}

	public function addController(Route $controller)
	{
		$this->data['controllers'][$controller->uri()] = $controller;
	}

	public function addAction(Route $action)
	{
		$this->data['actions'][$action->uri()] = $action;
	}

	public function addCallback(Route $callback)
	{
		$this->data['callbacks'][$callback->uri()] = $callback;
	}

	public function findController(string $key)
	{
		return isset($this->data['controllers'][$key]) ? $this->data['controllers'][$key] : NULL;
	}

	public function findCallback(string $key)
	{
		return $this->findByRegex($key, 'callbacks');
	}

	public function findAction(string $key)
	{
		return $this->findByRegex($key, 'actions');
	}

	public function findByRegex(string $key, string$type)
	{
		foreach ($this->data[$type] as $url => $action)
		{
			$pattern = str_replace('/', '\/', $url);
			$match = preg_match("/^$pattern$/", $key);
			
			if ($match)
				return $action;
		}

		return NULL;
	}
}