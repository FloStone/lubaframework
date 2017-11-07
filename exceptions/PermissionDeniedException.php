<?php

namespace Luba\Exceptions;

class PermissionDeniedException extends LubaException
{
	public function __construct(string $url = '')
	{
		parent::__construct("Permission denied on \"$url\"!", 403);
	}
}