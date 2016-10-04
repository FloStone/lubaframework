<?php

namespace Luba\Framework;

abstract class Luba
{
	public static function runCommand($command)
	{
		return Command::exec($command);
	}
}