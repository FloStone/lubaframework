<?php

namespace Luba\Framework;

use Luba\Interfaces\SingletonInterface;
use Luba\Traits\Singleton;
use Luba\Traits\StaticCallable;

class Request implements SingletonInterface
{
	use Singleton, StaticCallable;

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
		$this->status = $server['REDIRECT_STATUS'];
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
}