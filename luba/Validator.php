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

	protected $messages = [
		'required' => "The %f field is required!",
		'numeric' => "The %f field must only contain numbers!",
		'email' => "The %f field must contain a valid email address!",
		'requiredWith' => "The %f field is required with %o!",
		'requiredWithout' => "The %f field is required without %o!"
	];

	protected static $customMessages = [];

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
			$this->errors[$field] = str_replace('%f', $field , $this->getErrorMessage(self::REQUIRED));

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
			$this->errors[$field] = str_replace('%f', $field, $this->getErrorMessage(self::NUMERIC));

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
				$this->errors[$field] = str_replace(['%f', '%o'], [$field, $otherfield], $this->getErrorMessage(self::REQUIRED_WITH));

				return false;
			}
		}

		return true;
	}

	public function requiredWithout($field, $otherfield)
	{
		$postField = $this->getPostField($field);

		if (is_null($postField) or $postField == "")
		{
			$otherPostField = $this->getPostField($otherfield);

			if (is_null($otherPostField) && $otherPostField == "")
			{
				$this->errors[$field] = str_replace(['%f', '%o'], [$field, $otherfield], $this->getErrorMessage(self::REQUIRED_WITHOUT));

				return false;
			}
		}

		return true;
	}

	public function email($field)
	{
		$postField = $this->getPostField($field);

		if (preg_match('/\w+@\w+\.\w+/', $postField))
			return true;
		else
		{
			$this->errors[$field] = str_replace('%f', $field, $this->getErrorMessage(self::EMAIL));

			return false;
		}
	}

	public function getPostField($fieldname)
	{
		return $this->postVars[$fieldname];
	}

	public function getErrorMessage($rule)
	{
		if (isset(self::$customMessages[$rule]))
			return self::$customMessages[$rule];
		else
			return $this->messages[$rule];
	}

	public static function customMessages(array $messages)
	{
		self::$customMessages = $messages;
	}
}