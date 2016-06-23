<?php

namespace Luba\Form;

use Luba\Traits\RenderAttributes;

class Label
{
	use RenderAttributes;

	protected $name;

	protected $value;

	protected $attributes = [];

	public function __construct($name, $value, $attributes = [])
	{
		$this->name = $name;
		$this->value = $value;
		$this->attributes = $attributes;
	}

	public function getName()
	{
		return $this->name;
	}

	public function render()
	{
		$attributes = $this->renderAttributes($this->attributes);
		return [
			'label' => "<label for=\"{$this->name}\" $attributes>{$this->value}</label>",
			'field' => NULL
		];
	}
}