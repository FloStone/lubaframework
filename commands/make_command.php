<?php

namespace Luba\Commands;

class make_command extends Command
{
	protected static $description = "Create a Command.";

	public function run()
	{
		$name = $this->argument(0);

		if (file_exists(base_path("controllers/$name.php")))
		{
			$this->output("$name already exists.");
			exit;
		}

		$stub = __DIR__.'/../stubs/command.stub';
		$file = file_get_contents($stub);
		$file = str_replace("%name%", $name, $file);
		file_put_contents(base_path("commands/$name.php"), $file);
		$this->output("Successfully created ".$name);
	}
}