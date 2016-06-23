<?php

namespace Luba\Traits;

use Luba\Interfaces\SingletonInterface;

trait Singleton
{
	/**
	 * Singleton instance
	 *
	 * @var self
	 */
	protected static $instance;

	/**
	 * Get the instance
	 *
	 * @return SingletonInterface
	 */
	public static function getInstance()
	{
		return self::$instance;
	}

	/**
	 * Set the instance
	 *
	 * @param SingletonInterface $instance
	 * @return void
	 */
	public static function setInstance(SingletonInterface $instance)
	{
		self::$instance = $instance;
	}
}