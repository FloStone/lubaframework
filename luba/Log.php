<?php

namespace Luba\Framework;

class Log
{
	public static function write($content)
	{
		if (!is_dir(base_dir('logs')))
			mkdir(base_dir('logs'));

		$name = date("Y-m-dTH_i_s") . '.log';

		file_put_contents(base_dir("logs/$name"), $content);
	}

	public static function exception(Exception $exception)
	{
		static::write($exception->getTraceAsString());
	}
}