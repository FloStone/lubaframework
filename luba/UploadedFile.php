<?php

namespace Luba\Framework;

class UploadedFile extends File
{
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
	 * Move the file
	 *
	 * @param string destination
	 * @param string $name
	 * @return this
	 */
	public function move($destination, $name = NULL)
	{
		$dest = rtrim($destination, '/') . DIRECTORY_SEPARATOR . (is_null($name) ? $this->name : $name) . "." . $this->extension;
		
		move_uploaded_file($this->path, $dest);

		$this->path = $dest;

		return $this;
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
}