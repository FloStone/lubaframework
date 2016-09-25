<?php

namespace Luba\Exceptions;

class PermissionDeniedException extends \Exception
{
	public function __construct($url = '')
	{
		http_response_code(403);
		parent::__construct("Permission denied on \"$url\"!");
	}
}