<?php

namespace Luba\Framework;

use Luba\Interfaces\SingletonInterface;

class LubaConfig
{
	/**
	 * Config entry collection
	 * @var Collection
	 */
	protected static $collection;

	/**
	 * Config in the instance
	 * @var Collection
	 */
	protected $config;

	/**
	 * Get static config collection
	 */
	public function __construct()
	{
		$this->config = self::$collection;
	}

	/**
	 * init the collection
	 * @return void
	 */
	public static function init()
	{
		self::$collection = new Collection;
	}

	/**
	 * Set an item in the config
	 * @param string $key
	 * @param string $value
	 */
	public function set($key, $value)
	{
		$this->config->add($key, $value);
	}

	/**
	 * Set an array of config items
	 * @param array $arr
	 */
	public function setArray(array $arr)
	{
		$this->config->addArray($arr);
	}

	/**
	 * Remove an item from config
	 * @param  string $key
	 * @return void
	 */
	public function remove($key)
	{
		$this->config->remove($key);
	}

	/**
	 * Get an item from the config
	 * @param  string $key
	 * @return string
	 */
	public function get($key)
	{
		return $this->config->get($key);
	}

	/**
	 * Set static config collection
	 */
	public function __destruct()
	{
		self::$collection = $this->config;
	}
}