<?php

namespace Luba\Framework;

use Luba\Interfaces\CommandInterface;
use Luba\Exceptions\CommandException;

abstract class Command implements CommandInterface
{
	const COLOR_DEFAULT = "\033[0m";
	const COLOR_BLUE = "\033[34m";
	const COLOR_GREEN = "\033[32m";
	const COLOR_RED = "\033[31m";
	const COLOR_PURPLE = "\033[35m";

	/**
	 * Command options
	 * @var array
	 */
	protected static $options = [];

	/**
	 * Command Arguments
	 * @var array
	 */
	protected static $arguments = [];

	/**
	 * Command description
	 * @var string
	 */
	protected static $description = "";

	/**
	 * Set the command arguments
	 * @param array $args
	 */
	public static function setArguments(array $args = [])
	{
		unset($args[0]);
		unset($args[1]);
		$args = array_values($args);
		static::$arguments = $args;
	}

	/**
	 * Run a command
	 * @param  string $name
	 * @return void
	 */
	public static function runCommand($name, array $args = [])
	{
		$command = "Luba\Commands\\$name";
		$command::setArguments($args);

		if (!class_exists($command))
			throw new \Exception("Command $name not found!");

		$command = new $command;
		$command->run();
	}

	/**
	 * Print something to console
	 * @param  string $output
	 * @return void
	 */
	public function output($output, $color = self::COLOR_DEFAULT)
	{
		print $color . $output;
		print "\n";
	}

	/**
	 * Execute a command
	 * @param  string $name
	 * @return void
	 */
	public function exec($name, array $args = [])
	{
		static::runCommand($name, $args);
	}

	/**
	 * Get a command argument
	 * @param  string|int $index
	 * @return string
	 */
	public function argument($index)
	{
		if (isset(static::$arguments[$index]))
			return static::$arguments[$index];
		else
			throw new CommandException("Argument with index $index was not found.");
	}

	public static function getDescription()
	{
		return static::$description;
	}
}