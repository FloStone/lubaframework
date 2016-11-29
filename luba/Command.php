<?php

namespace Luba\Framework;

use Luba\Interfaces\CommandInterface;

abstract class Command implements CommandInterface
{
	protected static $options = [];

	protected static $arguments = [];

	public static function setArguments(array $args = [])
	{
		$args = $args;
		unset($args[0]);
		unset($args[1]);
		$args = array_values($args);

		static::$arguments = $args;
	}

	public static function runCommand($name)
	{
		$command = "Luba\Commands\\$name";

		if (!class_exists($command))
			throw new \Exception("Command $name not found!");

		$command = new $command;
		$command->run();
	}

	public function output($output)
	{
		print $output;
		print "\n";
	}

	public function exec($name)
	{
		static::runCommand($name);
	}

	public function argument($index)
	{
		return static::$arguments[$index];
	}
}