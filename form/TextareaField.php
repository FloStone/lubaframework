<?php

namespace Luba\Form;

class TextareaField extends FormField
{
	public function __construct(string $name, string $value, array $attributes = [], bool $bind = NULL)
	{
		$this->attributes = $attributes;
		$this->name = $name;
		$this->value = $value;
		$this->bind = $bind;
	}

	public function render() : array
	{
		$name = $this->name;
		$value = $this->bind ?: $this->value;
		$attributes = $this->renderAttributes($this->attributes);
		$label = $this->label;
		$labelAttributes = $this->renderAttributes($this->labelAttributes);

		return [
			'label' => is_null($label) ? "" : "<label for=\"$name\" $labelAttributes>$label</label>",
			'field' => "<textarea name=\"$name\" id=\"$name\" $attributes>$value</textarea>",
            'type' => 'textarea'
		];
	}
}