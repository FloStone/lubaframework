<?php

namespace Luba\Exceptions;

class TemplateNotFoundException extends \Exception
{
	public function __construct($template)
	{
		http_response_code(500);
		parent::__construct("Template \"$template\" does not exist!");
	}
}