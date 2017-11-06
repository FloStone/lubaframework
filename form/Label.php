<?php

namespace Luba\Form;

use Luba\Traits\RenderAttributes;

class Label
{
	use RenderAttributes;

	protected $name;

	protected $value;

	protected $attributes = [];

	public function __construct(string $name, string $value, array $attributes = [])
	{
		$this->name = $name;
		$this->value = $value;
		$this->attributes = $attributes;
	}

	public function getName() : string
	{
		return $this->name;
	}

	public function render() : array
	{
		$attributes = $this->renderAttributes($this->attributes);
		return [
			'label' => "<label for=\"{$this->name}\" $attributes>{$this->value}</label>",
			'field' => NULL
		];
	}
}