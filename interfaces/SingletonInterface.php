<?php

namespace Luba\Interfaces;

interface SingletonInterface
{
	/**
	 * Get the classes Instance
	 *
	 * @return self
	 */
	public static function getInstance();

	/**
	 * Set the classes Instance
	 */
	public static function setInstance(SingletonInterface $instance);
}