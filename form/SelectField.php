<?php

namespace Luba\Form;

class SelectField extends FormField
{
	protected $name;

	protected $options = [];

	protected $default = NULL;

	public function __construct($name, array $options = [], $default = NULL, array $attributes = [])
	{
		$this->name = $name;
		$this->options = $options;
		$this->default = $default;
		$this->attributes = $attributes;
	}

	public function render()
	{
		$name = $this->name;
		$attributes = $this->renderAttributes($this->attributes);
		$label = $this->label;
		$labelAttributes = $this->renderAttributes($this->labelAttributes);

		$select = "<select name=\"$name\" id=\"$name\" $attributes>\r\n";

		foreach ($this->options as $value => $name)
		{
			if ((string)$this->default == (string)$value)
				$select = "$select<option value=\"$value\" selected>$name</option>\r\n";
			else
				$select = "$select<option value=\"$value\">$name</option>\r\n";
		}

		$select = "$select</select>\r\n";

		return [
			'label' => is_null($label) ? "" : "<label for=\"$name\" $labelAttributes>$label</label>",
			'field' => $select
		];
	}
}