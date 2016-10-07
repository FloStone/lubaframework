<?php

namespace Luba\Framework;

use Luba\Exceptions\ControllerNotFoundException;
use Luba\Exceptions\ControllerActionNotFoundException;
use Luba\Exceptions\HttpNotFoundException;
use Luba\Interfaces\SingletonInterface;
use Luba\Traits\Singleton;

class Application extends Luba implements SingletonInterface
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
	 * Input instance
	 *
	 * @var Input
	 */
	protected $input;

	/**
	 * Initialize class
	 *
	 * @param string $basepath
	 */
	public function __construct($basepath)
	{
		if (class_exists(\Luba\ExceptionHandler::class))
		{
			set_exception_handler([new \Luba\ExceptionHandler, 'handle']);
			set_error_handler([new \Luba\ErrorHandler, 'handle']);
		}
		else
			set_exception_handler([$this, 'handleException']);
		
		self::setInstance($this);
		$this->basePath = $basepath;
		$this->request = new Request;
		$this->url = new URL;
		$this->input = new Input;
		$this->router = new Router\Router;

		Session::start();

		parent::__construct();
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
		{

			$rendered = $response->render();
			echo ViewCompiler::cleanUp($rendered);
		}
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

	public function url()
	{
		return $this->url;
	}

	public function handleException($exception)
	{
		Log::exception($exception);
		echo $exception->getMessage();
		die;
	}
}