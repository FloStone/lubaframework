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

	public static function all()
	{
		if (strtolower(Request::getInstance()->method()) == 'post')
			return static::post();
		if (strtolower(Request::getInstance()->method()) == 'get')
			return static::get();

		return NULL;
	}

	public static function except()
	{
		$exceptions  = func_get_args();
		$inputs = static::all();

		foreach ($exceptions as $except)
		{
			if (isset($inputs[$except]))
				unset($inputs[$except]);
		}

		return $inputs;
	}

    /*
     * Build a query string with modified/additional parameters
     */
    public static function buildQuery($additional = [])
    {
        $query = self::get();
        $query = array_merge($query, $additional);
        return http_build_query($query);
    }
}