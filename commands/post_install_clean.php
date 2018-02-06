<?php

namespace Luba\Commands;

class post_install_clean extends Command
{
	public function run()
	{
		unlink(base_path('copyconfig'));
	}
}