<?php

namespace Luba\Exceptions;

class TemplateNotFoundException extends \Exception
{
	public function __construct($template)
	{
		parent::__construct("Template \"$template\" does not exist!");
	}
}