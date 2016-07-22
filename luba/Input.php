<?php

namespace Luba\Framework;

use Luba\Traits\Singleton;
use Luba\Interfaces\SingletonInterface;

class Input implements SingletonInterface
{
	use Singleton;

	protected $getInput = [];

	protected $postInput = [];

	protected $fileInput = [];

	public function __construct()
	{
		self::setInstance($this);
		$this->getInput = $_GET;
		$this->postInput = array_merge($_POST, $_FILES);
		$this->fileInput = $_FILES;
	}

	public function getInput($index = NULL, $default = NULL)
	{
		if ($index)
		{
			if (isset($this->getInput[$index]))
				return $this->getInput[$index];
			else
				return $default;
		}
		else
			return $this->getInput;
	}

	public function postInput($index = NULL, $default = NULL)
	{
		if ($index)
		{
			if (isset($this->fileInput[$index]))
				return $this->getFile($index);
			
			if (isset($this->postInput[$index]))
				return $this->postInput[$index];
			else
				return $default;
		}
		else
			return $this->postInput;
	}

	public function getFile($name, $default = NULL)
	{
		if (isset($this->fileInput[$name]))
		{
			if ($this->fileInput[$name]['tmp_name'] != "")
				return new UploadedFile($this->fileInput[$name]);
			else
				return $default;
		}
		else
			return $default;
	}

	public static function get($index = NULL, $default = NULL)
	{
		return self::getInstance()->getInput($index, $default);
	}

	public static function post($index = NULL, $default = NULL)
	{
		return self::getInstance()->postInput($index);
	}

	public static function file($name, $default = NULL)
	{
		return self::getInstance()->getFile($name);
	}
}