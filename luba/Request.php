<?php

namespace Luba\Framework;

use Luba\Interfaces\SingletonInterface;
use Luba\Traits\Singleton;

class Request implements SingletonInterface
{
	use Singleton;

	/**
	 * Singleton instance
	 *
	 * @var Request
	 */
	protected static $instance;

	/**
	 * Domain name
	 *
	 * @var string
	 */
	protected $domain;

	/**
	 * Request method
	 *
	 * @var string
	 */
	protected $method;

	/**
	 * URL root
	 *
	 * @var string
	 */
	protected $root;

	/**
	 * Request URI
	 *
	 * @var string
	 */
	protected $uri;

	/**
	 * HTTP status
	 *
	 * @var string
	 */
	protected $status;

	/**
	 * Request scheme
	 *
	 * @var string
	 */
	protected $scheme;

	/**
	 * Full request
	 *
	 * @var object
	 */
	protected $fullRequest;

	/**
	 * Initialize
	 *
	 * @return void
	 */
	public function __construct()
	{
		self::setInstance($this);

		$server = $_SERVER;
		$extra = str_replace('index.php', '', $server['SCRIPT_NAME']);

		$this->domain = $server['HTTP_HOST'];
		$this->method = $server['REQUEST_METHOD'];
		$this->root = $this->domain . $extra;
		$this->uri = str_replace($extra == '/' ? '' : $extra, '', $server['REQUEST_URI']);
		$this->status = isset($server['REDIRECT_STATUS']) ? $server['REDIRECT_STATUS'] : NULL;
		$this->scheme = $server['REQUEST_SCHEME'];
		$this->fullRequest = (object)$server;
	}

	public function full()
	{
		return $this->fullRequest;
	}

	public function domain()
	{
		return $this->domain;
	}

	public function method()
	{
		return $this->method;
	}

	public function root()
	{
		return $this->root;
	}

	public function uri()
	{
		return $this->uri;
	}

	public function status()
	{
		return $this->status;
	}

	public function scheme()
	{
		return $this->scheme;
	}

	public static function post($index)
	{
		if (isset($_POST[$index]))
			return $_POST[$index];
		else
			return NULL;
	}

	public static function get($index)
	{
		if (isset($_GET[$index]))
			return $_GET[$index];
		else
			return NULL;
	}
}