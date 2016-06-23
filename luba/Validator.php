<?php

namespace Luba\Framework;

use Luba\Form\Form;
use Luba\Form\Label;

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
			if ($field instanceof Label)
				continue;

			foreach ($field->getValidatorAttributes() as $rule)
			{
				if (stripos($rule, 'requiredWith:') !== false)
				{
					if (!$this->requiredWith($field->getName(), str_replace('requiredWith:', '', $rule)))
					{
						$this->passed = false;
						break;
					}
				}
				elseif(stripos($rule, 'requiredWithout:') !== false)
				{
					if (!$this->requiredWithout($field->getName(), str_replace('requiredWithout:', '', $rule)))
					{
						$this->passed = false;
						break;
					}	
				}
				elseif (!$this->$rule($field->getName()))
				{
					$this->passed = false;
					break;
				}
			}

			Session::set('__forminputs', $this->postVars);
		}

		Session::set('__formerrors', $this->errors);

		return $this->passed;
	}

	public function required($field)
	{
		$postField = $this->getPostField($field);
		
		if ($postField == "" or empty($postField) or is_null($postField))
		{
			$this->errors[$field] = "This field is required!";

			return false;
		}
		else
			return true;
	}

	public function numeric($field)
	{
		$postField = $this->getPostField($field);

		if (!is_numeric($postField))
		{
			$this->errors[$field] = "This field must only contain numbers!";

			return false;
		}
		else
			return true;
	}

	public function requiredWith($field, $otherfield)
	{
		$postField = $this->getPostField($field);

		if (is_null($postField) or $postField == "")
		{
			$otherPostField = $this->getPostField($otherfield);

			if (!is_null($otherPostField) && $otherPostField != "")
			{
				$this->errors[$field] = "This field is required with $otherfield!";

				return false;
			}
		}

		return true;
	}

	public function requiredWithout($field, $otherfield)
	{
		
	}

	public function email($field)
	{
		$postField = $this->getPostField($field);

		if (preg_match('/\w+@\w+\.\w+/', $postField))
			return true;
		else
		{
			$this->errors[$field] = "Please enter a valid email address!";

			return false;
		}
	}

	public function getPostField($fieldname)
	{
		return $this->postVars[$fieldname];
	}
}