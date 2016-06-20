<?php

namespace Luba\Framework;

use Luba\Form\Form;

class Validator
{
	const REQUIRED = 'required';
	const NUMERIC = 'numeric';
	const REQUIRED_WITH = 'requiredWith:';
	const REQUIRED_WITHOUT = 'requiredWithout:';
	const EMAIL = 'email';

	protected $fields;

	protected $form;

	protected $postVars;

	protected $passed = true;

	protected $errors = [];

	public function __construct(Form $form)
	{
		$this->form = $form;
		$this->fields = $form->fields();

		$method = strtolower($form->getMethod());

		$this->postVars = Input::$method();
	}

	public function run()
	{
		foreach ($this->fields as $field)
		{
			foreach ($field->getValidatorAttributes() as $rule)
			{
				if (!$this->$rule($field))
				{
					$this->passed = false;
					continue;
				}
			}
		}

		Session::set('formerrors', $this->errors);

		return $this->passed;
	}

	public function required($field)
	{
		$postField = $this->postVars[$field->getName()];
		
		if ($postField == "" or empty($postField) or is_null($postField))
		{
			$this->errors[$field->getName()] = "This field is required!";
		}
		else
			return true;
	}

	public function numeric($field)
	{
		
	}

	public function requiredWith($field)
	{
		
	}

	public function requiredWithout($field)
	{
		
	}

	public function email($field)
	{
		
	}
}