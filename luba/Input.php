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

	public function getInput($index = NULL)
	{
		if ($index)
		{
			if (isset($this->getInput[$index]))
				return $this->getInput[$index];
			else
				return NULL;
		}
		else
			return $this->getInput;
	}

	public function postInput($index = NULL)
	{
		if ($index)
		{
			if (isset($this->fileInput[$index]))
				return $this->getFile($index);
			
			if (isset($this->postInput[$index]))
				return $this->postInput[$index];
			else
				return NULL;
		}
		else
			return $this->postInput;
	}

	public function getFile($name)
	{
		if (isset($this->fileInput[$name]))
		{
			if ($this->fileInput[$name]['tmp_name'] != "")
				return new UploadedFile($this->fileInput[$name]);
			else
				return NULL;
		}
		else
			return NULL;
	}

	public static function get($index = NULL)
	{
		return self::getInstance()->getInput($index);
	}

	public static function post($index = NULL)
	{
		return self::getInstance()->postInput($index);
	}

	public static function file($name)
	{
		return self::getInstance()->getFile($name);
	}
}