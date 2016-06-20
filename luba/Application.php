<?php

namespace Luba\Framework;

use Luba\Exceptions\ControllerNotFoundException;
use Luba\Exceptions\ControllerActionNotFoundException;
use Luba\Exceptions\HttpNotFoundException;
use Luba\Interfaces\SingletonInterface;
use Luba\Traits\Singleton;

class Application implements SingletonInterface
{
	use Singleton;

	/**
	 * base path of the application
	 *
	 * @var string
	 */
	protected $basePath;

	/**
	 * Router instance
	 *
	 * @var Router
	 */
	protected $router;

	/**
	 * Request instance
	 *
	 * @var Request
	 */
	protected $request;

	/**
	 * URL Instance
	 *
	 * @var url
	 */
	protected $url;

	/**
	 * Singleton instance
	 *
	 * @var Application
	 */
	protected static $instance;

	/**
	 * Initialize class
	 *
	 * @param string $basepath
	 */
	public function __construct($basepath)
	{
		self::setInstance($this);
		$this->basePath = $basepath;
		$this->router = new Router();
		$this->request = new Request;
		$this->url = new URL;

		Session::start();
	}

	/**
	 * Run the application
	 *
	 * @return void
	 */
	public function run()
	{
		$response = $this->router->make();
		$this->renderAction($response);
	}

	/**
	 * Render out the returned controller action
	 *
	 * @return void
	 */
	public function renderAction($response)
	{
		if (is_string($response))
			echo $response;
		if ($response instanceof View or $response instanceof \View)
			echo $response->render();
		if ($response instanceof Redirect or $response instanceof \Redirect)
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