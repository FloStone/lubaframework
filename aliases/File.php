<?php

use Luba\Framework\File;

class File extends BaseFile
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
	 * File extension
	 * @var string
	 */
	protected $extension;

	/**
	 * File name
	 * @var string
	 */
	protected $name;

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
	 * Get the full name including extension
	 *
	 * @return string
	 */
	public function fullName()
	{
		return "{$this->name}.{$this->extension}";
	}

	/**
	 * Name of the file
	 * @return String name
	 */
	public function name()
	{
		return $this->name;
	}
}