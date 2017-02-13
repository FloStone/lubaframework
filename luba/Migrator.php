<?php

namespace Luba\Framework;

use SQL;

abstract class Migrator extends Command
{

	const AVAILABLE_COMMANDS = "Available parameters for migrate:\ndrop|destroy|refresh|rebuild";

	/**
	 * Build the database
	 *
	 * @return void
	 */
	abstract public function build();

	/**
	 * Destroy the database
	 *
	 * @return void
	 */
	abstract public function destroy();

	/**
	 * Disable or enable foreign key check
	 * @var boolean
	 */
	protected static $foreignKeyCheck = false;

	/**
	 * Run the command
	 *
	 * @return void
	 */
	public function run()
	{
		if (!static::$foreignKeyCheck)
			SQL::query("SET FOREIGN_KEY_CHECKS=0");

		$command = $this->argument(0);
		if ($command == 'destroy' || $command == 'drop')
			$this->destroy();
		elseif ($command == "refresh" || $command == 'rebuild')
		{
			$this->destroy();
			$this->build();
		}
		elseif ($command == '')
			$this->build();
		else
			$this->output(static::AVAILABLE_COMMANDS);

		if (!static::$foreignKeyCheck)
			SQL::query("SET FOREIGN_KEY_CHECKS=1");
	}
}