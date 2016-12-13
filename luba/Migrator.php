<?php

namespace Luba\Framework;

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
	 * Run the command
	 *
	 * @return void
	 */
	public function run()
	{
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
	}
}