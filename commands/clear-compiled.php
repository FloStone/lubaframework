<?php

$files = glob(base_path('temp/*'));

foreach ($files as $file)
{
	if (is_file($file))
		unlink($file);
}