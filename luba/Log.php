<?php

namespace Luba\Framework;

class Log
{
	public function write($content)
	{
		if (!is_dir(base_path('storage/logs')))
			mkdir(base_path('storage/logs'));

		$name = date("Y-m-d_H-i-s") . '.log';

		file_put_contents(base_path("storage/logs/$name"), $content);
	}

	public function exception($exception)
	{
		$this->write(str_replace('{main}', $exception->getMessage(), $exception->getTraceAsString()));
	}
}