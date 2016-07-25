<?php

$files = glob(base_path('storage/logs/*'));

foreach ($files as $file)
{
	if (is_file($file))
		unlink($file);
}