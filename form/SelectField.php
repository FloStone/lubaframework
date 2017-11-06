<?php

namespace Luba\Form;

class SelectField extends FormField
{
	/**
	 * Select options
	 *
	 * @var array
	 */
	protected $options = [];

	/**
	 * Default selected
	 *
	 * @var string
	 */
	protected $default = NULL;

	/**
	 * Initialization
	 *
	 * @param string $name
	 * @param array $options
	 * @param string $default
	 * @param array $attributes
	 */
	public function __construct(string $name, array $options = [], string $default = NULL, array $attributes = [])
	{
		$this->name = $name;
		$this->options = $options;
        if(is_array($default) || $default === null)
		    $this->default = $default;
        else
            $this->default = [$default];
		$this->attributes = $attributes;
	}

	/**
	 * Render the Select field
	 *
	 * @return array
	 */
	public function render() : array
	{
        $id = $this->name;
		$name = $this->name;
		$attributes = $this->renderAttributes($this->attributes);
        if(array_key_exists("multiple", $this->attributes))
            $name.="[]";
		$label = $this->label;
		$labelAttributes = $this->renderAttributes($this->labelAttributes);

		$select = "<select name=\"$name\" id=\"$id\" $attributes>\r\n";

		foreach ($this->options as $value => $name)
		{
            $strict = false;
            if($value == 0) {
                //Strange php behaviour needs this on in_array(0, ["somestring"])
                $strict = true;
            }
			if ($this->default !== null && in_array($value, $this->default, $strict))
				$select = "$select<option value=\"$value\" selected>$name</option>\r\n";
			else
				$select = "$select<option value=\"$value\">$name</option>\r\n";
		}

		$select = "$select</select>\r\n";

		return [
			'label' => is_null($label) ? "" : "<label for=\"$name\" $labelAttributes>$label</label>",
			'field' => $select,
            'type' => "select"
		];
	}
}