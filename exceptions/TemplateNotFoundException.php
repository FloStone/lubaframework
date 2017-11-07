<?php

namespace Luba\Exceptions;

class TemplateNotFoundException extends LubaException
{
	public function __construct(string $template)
	{
		parent::__construct("Template \"$template\" does not exist!", 500);
	}
}