<?php

namespace Luba\Form;

use Luba\Traits\RenderAttributes;
use Luba\Framework\Validator;

abstract class FormField
{
	use RenderAttributes;
	
	protected $label = NULL;

	protected $labelAttributes = [];

	protected $attributes = [];

	protected $validatorAttributes = [];

	public function label($title, array $attributes = [])
	{
		$this->label = $title;
		$this->labelAttributes = $attributes;

		return $this;
	}

	public function required()
	{
		$this->addValidatorAttribute(Validator::REQUIRED);

		return $this;
	}

	public function numeric()
	{
		$this->addValidatorAttribute(Validator::NUMERIC);

		return $this;
	}

	public function requiredWith($requirement)
	{
		$this->addValidatorAttribute(Validator::REQUIRED_WITH . $requirement);

		return $this;
	}

	public function requiredWithout($requirement)
	{
		$this->addValidatorAttribute(Validator::REQUIRED_WITHOUT . $requirement);

		return $this;
	}

	public function email()
	{
		$this->addValidatorAttribute(Validator::EMAIL);

		return $this;
	}

	public function addValidatorAttribute($attribute)
	{
		if (!array_search($attribute, $this->validatorAttributes))
			$this->validatorAttributes[] = $attribute;
	}


	public function getValidatorAttributes()
	{
		return $this->validatorAttributes;
	}

	public function getName()
	{
		return $this->name;
	}

	abstract public function render();
}