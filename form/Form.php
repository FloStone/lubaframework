<?php

namespace Luba\Form;

use Luba\Framework\View;
use Luba\Traits\RenderAttributes;
use Luba\Framework\Validator;
use Luba\Framework\Session;

class Form
{
	const GET = 'GET';
	const POST = 'POST';
	const PUT = 'PUT';
	const DELETE = 'DELETE';

	use RenderAttributes;

	/**
	 * Form action
	 *
	 * @var string
	 */
	protected $action = NULL;

	/**
	 * Form fields
	 *
	 * @var array
	 */
	protected $fields = [];

	/**
	 * Form templates location
	 *
	 * @var string
	 */
	protected $templates = NULL;

	/**
	 * Form method
	 *
	 * @var string
	 */
	protected $method = 'GET';

	/**
	 * Multipart formdata
	 *
	 * @var bool
	 */
	protected $files = false;

	/**
	 * Form attributes
	 *
	 * @var array
	 */
	protected $attributes = [];

	/**
	 * Initialization
	 *
	 * @param string $action
	 * @return void
	 */
	public function __construct($action = NULL, array $attributes = [])
	{
		$this->attributes = $attributes;
		$this->templates = defined('FORM_TEMPLATES') ? FORM_TEMPLATES : __DIR__.'/templates/';
		$this->action = $action;
	}

	/**
	 * Allow or disallow files in form submit
	 *
	 * @param bool $files
	 * @return void
	 */
	public function files($files = true)
	{
		$this->files = $files;
	}

	/**
	 * Set the form method
	 *
	 * @param string $method
	 * @return void
	 */
	public function method($method)
	{
		$this->method = $method;
	}

	/**
	 * Set the template path
	 *
	 * @param string $path
	 * @return void
	 */
	public function template($path)
	{
		$this->templates = $path;
	}

	/**
	 * Add a hidden field
	 *
	 * @param string $name
	 * @param string $value
	 * @param array $attributes
	 * @return InputField
	 */
	public function hidden($name, $value, array $attributes = [])
	{
		return $this->inputField('hidden', $name, $value, $attributes);
	}

	/**
	 * Add a checkbox field
	 *
	 * @param string $name 
	 * @param string $value
	 * @param bool $checked
	 * @param array $attributes
	 * @return InputField
	 */
	public function checkbox($name, $value, $checked = false, array $attributes = [])
	{
		return $this->inputField('checkbox', $name, $value, $attributes, $checked ? ['checked' => 'checked'] : []);
	}

	/**
	 * Add a text field
	 *
	 * @param string $name
	 * @param string $value
	 * @param array $attributes
	 * @return InputField
	 */
	public function text($name, $value = NULL, array $attributes = [])
	{
		return $this->inputField('text', $name, $value, $attributes);
	}

	/**
	 * Add a select field
	 *
	 * @param string $name
	 * @param array $options
	 * @param string $default
	 * @param array $attributes
	 * @return SelectField
	 */
	public function select($name, array $options = [], $default = NULL, array $attributes = [])
	{
		$select = new SelectField($name, $options, $default, $attributes);
		$this->fields[] = $select;

		return $select;
	}

	/**
	 * Validate form fields
	 *
	 * @return bool
	 */
	public function validate()
	{
		$validator = new Validator($this);

		return $validator->run();
	}

	/**
	 * Add a label field
	 *
	 * @param string $name
	 * @param string $value
	 * @param array $attributes
	 * @return void
	 */
	public function label($name, $value, array $attributes = [])
	{
		$this->fields[] = "<label for=\"$name\">$value</label>";
	}

	/**
	 * Create an InputField
	 *
	 * @param string $type
	 * @param string $name
	 * @param string $value
	 * @param array $attributes
	 * @param array $other
	 * @return InputField
	 */
	public function inputField($type, $name, $value, array $attributes = [], array $other = [])
	{
		$formfield = new InputField($type, $name, $value, $attributes, $other);
		$this->fields[] = $formfield;

		return $formfield;
	}

	/**
	 * Set the form action
	 *
	 * @param string $action
	 * @return void
	 */
	public function action($action)
	{
		$this->action = $action;
	}

	/**
	 * Get the forms fields
	 *
	 * @return array
	 */
	public function fields()
	{
		return $this->fields;
	}

	/**
	 * Get the Form method
	 *
	 * @return string
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 * String representation
	 *
	 * @return string
	 */
	public function __tostring()
	{
		$rendered = [];

		$attributes = $this->renderAttributes($this->attributes);
		$files = $this->files ? "enctype=\"multipart/formdata\"" : "";
		$method = "method=\"{$this->method}\"";
		$action = "action=\"{$this->action}\"";

		$rendered[] = "<form $method $action $files $attributes>";

		foreach($this->fields as $field)
		{
			$template = $this->templates.'form.lb';
			if (file_exists($template))
			{
				$arr = $field->render();
				$error = is_null(Session::get("formerrors")) ? NULL : isset(Session::get('formerrors')[$field->getName()]) ? Session::get('formerrors')[$field->getName()] : NULL;
				
				$rendered[] = (new View('form', ['label' => $arr['label'], 'field' => $arr['field'], 'error' => $error], $this->templates))->render();
			}
			else
				return "Template $template does not exist!";
		}

		$rendered[] = "<input type=\"submit\" id=\"submit\">";
		$rendered[] = "</form>";

		return implode("\r\n", $rendered);
	}
}