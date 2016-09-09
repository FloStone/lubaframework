<?php

namespace Luba\Commands;

class PostInstallClean extends Command
{
	public function run()
	{
		unlink(base_path('copyconfig'));
	}
}