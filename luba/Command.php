<?php

namespace Luba\Framework;

use Luba\Interfaces\CommandInterface;

abstract class Command implements CommandInterface
{
	public static function exec($name)
	{
		$command = "Luba\Commands\\$name";

		if (!class_exists($command))
			throw new \Exception("Command $name not found!");

		$command = new $command;
		$command->run();
	}
}