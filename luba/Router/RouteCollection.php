<?php

namespace Luba\Framework\Router;

use Flo\MySQL\Collection;

class RouteCollection extends Collection
{
	public function __construct()
	{
		$this->data = [
			'actions' => [],
			'controllers' => [],
			'callbacks' => []
		];
	}

	public function addController(Route $controller)
	{
		$this->data['controllers'][$controller->uri()] = $controller;
	}

	public function addAction(Route $action)
	{
		$this->data['actions'][$action->fullUri()] = $action;
	}

	public function addCallback(Route $callback)
	{
		$this->data['callbacks'][$callback->fullUri()] = $callback;
	}

	public function findController($key)
	{
		return isset($this->data['controllers'][$key]) ? $this->data['controllers'][$key] : NULL;
	}

	public function findCallback($key)
	{
		return $this->findByRegex($key, 'callbacks');
	}

	public function findAction($key)
	{
		return $this->findByRegex($key, 'actions');
	}

	public function findByRegex($key, $type)
	{
		foreach ($this->data[$type] as $url => $action)
		{
			$pattern = str_replace('/', '\/', $url);
			$match = preg_match("/$pattern/", $key);
			
			if ($match)
				return $action;
		}

		return NULL;
	}
}