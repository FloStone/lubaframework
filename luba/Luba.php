<?php

namespace Luba\Framework;

abstract class Luba
{
	public function __construct()
	{
		$this->loadconfigs();
	}

	public function loadconfigs()
	{
		if (file_exists(base_path('config/config.php')))
			require base_path('config/config.php');

		if (file_exists(base_path('config/global.php')))
			require base_path('config/global.php');
	}

	public static function command($command)
	{
		return Command::exec($command);
	}
}