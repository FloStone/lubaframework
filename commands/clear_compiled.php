<?php

namespace Luba\Commands;

class clear_compiled extends Command
{
	public function run()
	{
		$files = glob(base_path('storage/temp/*'));

		foreach ($files as $file)
		{
			if (is_file($file))
				unlink($file);
		}

		$this->output("Remove compiled views.");
	}
}