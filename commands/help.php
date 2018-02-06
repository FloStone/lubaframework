<?php

namespace Luba\Commands;

class help extends Command
{
	public static $description = "\tShow command help.";

	public function run()
	{
		$this->output("Available Luba commands:");

		$files = scandir(__DIR__);

		foreach ($files as $file)
		{
			if ($file == ".gitignore" or $file == "." or $file == "..")
				continue;

			$command = $this->parseName($file);
			$classname = "\Luba\Commands\\$command";
			$description = $classname::$description;
			$this->output("\t" . $this->parseName($command) . "\t\t\t" . $description);
		}

		$this->output("");
		$this->output("Custom commands:");

		$files = scandir(base_path("commands"));

		foreach ($files as $file)
		{
			if ($file == ".gitignore" or $file == "." or $file == ".." or $file == "Command.php")
				continue;

			$command = $this->parseName($file);
			$classname = "\Luba\Commands\\$command";
			$description = $classname::$description;
			$this->output("\t" . $this->parseName($command) . "\t\t\t" . $description);
		}
	}

	public function parseName(string $file)
	{
		return str_replace(".php", "", $file);
	}
}