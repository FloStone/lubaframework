<?php

namespace Luba\Form;

class Button extends FormField
{
	public function __construct(string $value, string $title, array $attributes = [], bool $bind = NULL)
	{
		$this->attributes = $attributes;
		$this->title = $title;
		$this->value = $value;
		$this->bind = $bind;
	}

	public function render() : array
	{
		$value = $this->bind ?: $this->value;
		$attributes = $this->renderAttributes($this->attributes);
		$label = $this->title;
		$labelAttributes = $this->renderAttributes($this->labelAttributes);

		return [
			'label' => "",
			'field' => "<button value=\"$value\" $attributes>$label</button>",
            'type' => 'button'
		];
	}
}