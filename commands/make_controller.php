<?php

namespace Luba\Commands;

class make_controller extends Command
{
	protected static $description = "Create a Controller.";

	public function run()
	{
		$name = $this->argument(0);

		if (file_exists(base_path("controllers/$name.php")))
		{
			$this->output("$name already exists.");
			exit;
		}

		$stub = __DIR__.'/../stubs/controller.stub';
		$file = file_get_contents($stub);
		$file = str_replace("%name%", $name, $file);
		file_put_contents(base_path("controllers/$name.php"), $file);
		$this->output("Successfully created ".$name);
	}
}