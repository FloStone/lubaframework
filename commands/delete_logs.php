<?php

namespace Luba\Commands;

class delete_logs extends Command
{
	protected static $description = "Delete all Luba logs.";

	public function run()
	{
		$files = glob(base_path('storage/logs/*'));

		foreach ($files as $file)
		{
			if (is_file($file))
				unlink($file);
		}

		$this->output("Removed all logs.");
	}
}