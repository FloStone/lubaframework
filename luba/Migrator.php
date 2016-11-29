<?php

namespace Luba\Framework;

abstract class Migrator extends Command
{
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
		if ($command == 'destroy')
			$this->destroy();
		elseif ($command == "refresh")
		{
			$this->destroy();
			$this->build();
		}
		else
			$this->build();
	}
}