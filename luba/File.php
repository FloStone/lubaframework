<?php

namespace Luba\Framework;

class File
{
	protected $name;

	protected $extension;

	protected $path;

	public function __construct($path = "")
	{
		$this->path = $path;
		$this->name = pathinfo($path, PATHINFO_FILENAME);
		$this->extension = pathinfo($path, PATHINFO_EXTENSION);
	}

	public static function make($path)
	{
		return new self($path);
	}
}