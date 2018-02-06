<?php

namespace Luba\Framework;

abstract class Luba
{
	const VERSION = "2.0.0";

	public function __construct()
	{
		$this->setConfigInstance();
		$this->loadconfigs();
	}

	final private function loadconfigs()
	{
		if (file_exists(base_path('config/config.php')))
			require base_path('config/config.php');

		if (file_exists(base_path('config/global.php')))
			require base_path('config/global.php');
	}

	final private function setConfigInstance()
	{
		LubaConfig::init();
	}

	public static function command($command)
	{
		return Command::runCommand($command);
	}
}