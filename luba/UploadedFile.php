<?php

namespace Luba\Framework;

class UploadedFile extends File
{
	/**
	 * File size
	 *
	 * @var int
	 */
	protected $size;

	/**
	 * File type
	 *
	 * @var string
	 */
	protected $type;

	/**
	 * Original array
	 *
	 * @var array
	 */
	protected $original = [];

	/**
	 * Initalization
	 *
	 * @param array $file
	 * @return void
	 */
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

	/**
	 * Rename the file
	 *
	 * @param string $name
	 * @return void
	 */
	public function rename($name)
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * Move the file
	 *
	 * @param string destination
	 * @param string $name
	 * @return this
	 */
	public function move($destination, $name = NULL)
	{
		$dest = rtrim($destination, '/') . DIRECTORY_SEPARATOR . (is_null($name) ? $this->name : $name) . "." . $this->extension;

		rename($this->path, $dest);

		$this->path = $dest;

		return $this;
	}

	/**
	 * get the file type
	 *
	 * @return string
	 */
	public function type()
	{
		return $this->type;
	}

	/**
	 * Get the file extension
	 *
	 * @return string
	 */
	public function extension()
	{
		return $this->extension;
	}

	/**
	 * Get the file size
	 *
	 * @return int
	 */
	public function size()
	{
		return $this->size;
	}

	/**
	 * Get the file path
	 *
	 * @return string
	 */
	public function path()
	{
		return $this->path;
	}

	/**
	 * Get the original array
	 *
	 * @return array
	 */
	public function original()
	{
		return $this->original;
	}

	public function name()
	{
		return $this->name;
	}

	/**
	 * Get the full name including extension
	 *
	 * @return string
	 */
	public function fullName()
	{
		return "{$this->name}.{$this->extension}";
	}
}