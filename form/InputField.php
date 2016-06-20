<?php

namespace Luba\Form;

use Luba\Framework\Validator;

class InputField extends FormField
{
	protected $type;

	protected $name;

	protected $value;

	protected $other;

	public function __construct($type, $name, $value = NULL, array $attributes = [], array $other = [])
	{
		$this->type = $type;
		$this->name = $name;
		$this->value = $value;
		$this->attributes = $attributes;
		$this->other = $other;
	}

	public function render()
	{
		$label = $this->label;
		$type = $this->type;
		$name = $this->name;
		$value = $this->value ? "value=\"{$this->value}\"" : "";
		$attributes = $this->renderAttributes($this->attributes);
		$other = $this->renderAttributes($this->other);
		$labelAttributes = $this->renderAttributes($this->labelAttributes);

		return [
			'label' => is_null($label) ? "" : "<label for=\"$name\" $labelAttributes>$label</label>",
			'field' => "<input type=\"$type\" name=\"$name\" id=\"$name\" $value $attributes $other>"
		];
	}
}