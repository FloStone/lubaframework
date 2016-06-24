<?php

namespace Luba\Framework;

class UploadedFile
{
	protected $name;

	protected $extension;

	protected $type;

	protected $size;

	protected $path;

	protected $original = [];

	public function __construct(array $file)
	{
		$this->original = $file;
		$this->size = $this->original['size'];
		$this->path = $this->original['tmp_name'];

		$attr = explode('/', $this->original['type']);

		$this->type = array_shift($attr);
		$this->extension = pathinfo($this->original['name'], PATHINFO_EXTENSION);

		$this->name = pathinfo($this->original['name'], PATHINFO_FILENAME);
	}

	public function rename($name)
	{
		$this->name = $name;
	}

	public function move($destination, $name = NULL)
	{
		$dest = rtrim($destination, '/') . DIRECTORY_SEPARATOR . (is_null($name) ? $this->name : $name) . "." . $this->extension;

		rename($this->path, $dest);

		$this->path = $dest;

		return $this;
	}

	public function type()
	{
		return $this->type;
	}

	public function extension()
	{
		return $this->extension;
	}

	public function size()
	{
		return $this->size;
	}

	public function path()
	{
		return $this->path;
	}
	public function original()
	{
		return $this->original;
	}

	public function fullName()
	{
		return "{$this->name}.{$this->extension}";
	}
}