<?php

namespace Luba\Form;

use Luba\Traits\RenderAttributes;
use Luba\Framework\Validator;

abstract class FormField
{
	use RenderAttributes;

	/**
	 * Field name
	 *
	 * @var string
	 */
	protected $name;
	
	/**
	 * Label of the formfield
	 *
	 * @var string
	 */
	protected $label = NULL;

	/**
	 * Label attributes
	 *
	 * @var array
	 */
	protected $labelAttributes = [];

	/**
	 * Form field attributes
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * Rules for validation
	 *
	 * @var array
	 */
	protected $validatorAttributes = [];

	/**
	 * Add a label
	 *
	 * @param string $title
	 * @param array $attributes
	 * @return this
	 */
	public function label(string $title, array $attributes = []) : FormField
	{
		$this->label = $title;
		$this->labelAttributes = $attributes;

		return $this;
	}

	/**
	 * Form field is required
	 *
	 * @return thiss
	 */
	public function required() : FormField
	{
		$this->addValidatorAttribute(Validator::REQUIRED);

		return $this;
	}

	/**
	 * Form field must be numeric
	 *
	 * @return this
	 */
	public function numeric() : FormField
	{
		$this->addValidatorAttribute(Validator::NUMERIC);

		return $this;
	}

	/**
	 * Form field is required with another field
	 *
	 * @param string $requirement
	 * @return this
	 */
	public function requiredWith(string $requirement) : FormField
	{
		$this->addValidatorAttribute(Validator::REQUIRED_WITH . $requirement);

		return $this;
	}

	/**
	 * Form field is required without another field
	 *
	 * @param string $requirement
	 * @return this
	 */
	public function requiredWithout(string $requirement) : FormField
	{
		$this->addValidatorAttribute(Validator::REQUIRED_WITHOUT . $requirement);

		return $this;
	}

	/**
	 * Form field must be an email
	 *
	 * @return this
	 */
	public function email() : FormField
	{
		$this->addValidatorAttribute(Validator::EMAIL);

		return $this;
	}

	/**
	 * Add a rule to the validation
	 *
	 * @param string $attribute
	 * @return void
	 */
	public function addValidatorAttribute(string $attribute)
	{
		if (!array_search($attribute, $this->validatorAttributes))
			$this->validatorAttributes[] = $attribute;
	}

	/**
	 * Get validation rules
	 *
	 * @return array
	 */
	public function getValidatorAttributes() : array
	{
		return $this->validatorAttributes;
	}

	/**
	 * Get the Form field name
	 *
	 * @return string
	 */
	public function getName() : string
	{
		return $this->name;
	}

	/**
	 * Render out the form field
	 *
	 * @return array
	 */
	abstract public function render();
}