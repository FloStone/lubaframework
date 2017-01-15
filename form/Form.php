<?php

namespace Luba\Form;

use Luba\Framework\View;
use Luba\Traits\RenderAttributes;
use Luba\Framework\Validator;
use Luba\Framework\Session;

class Form
{
	const GET = 'get';
	const POST = 'post';
	const PUT = 'put';
	const DELETE = 'delete';

	const TYPE_PASSWORD = 'password';
	const TYPE_HIDDEN = 'hidden';
	const TYPE_FILE = 'file';
	const TYPE_CHECKBOX = 'checkbox';
	const TYPE_TEXT = 'text';

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
	protected $method = 'post';

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
	 * Inputs for the form
	 *
	 * @var array
	 */
	protected $bindings = [];

	/**
	 * Determine if bound inputs are used
	 *
	 * @var bool
	 */
	protected $bind = false;

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

		if (Session::has('__formerrors'))
		{
			$this->bind = true;
			$this->bindings = Session::get('__forminputs');
		}
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
	 * Bind inputs to the form
	 *
	 * @param array $bindings
	 * @return void
	 */
	public function bind(array $bindings = [])
	{
		$this->bind = true;
		$this->bindings = $bindings;
	}

	/**
	 * Add a hidden field
	 *
	 * @param string $name
	 * @param string $value
	 * @param array $attributes
	 * @return InputField
	 */
	public function hidden($name, $value = NULL, array $attributes = [])
	{
		return $this->inputField(self::TYPE_HIDDEN, $name, $value, $attributes);
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
	public function checkbox($name, $value = NULL, $checked = false, array $attributes = [])
	{
		$bind = $this->bind ? isset($this->bindings[$name]) ? $this->bindings[$name] : false : $checked;
		return $this->inputField(self::TYPE_CHECKBOX, $name, $value, $attributes, $bind ? ['checked' => 'checked'] : []);
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
		return $this->inputField(self::TYPE_TEXT, $name, $value, $attributes);
	}

	/**
	 * Textarea field
	 * @param  String $name
	 * @param  String $value
	 * @param  array  $attributes
	 * @return TextareaField
	 */
	public function textarea($name, $value = NULL, array $attributes = [])
	{
		$bind = $this->bind ? isset($this->bindings[$name]) ? $this->bindings[$name] : NULL : NULL;
		$textarea = new TextareaField($name, $value, $attributes, $bind);
		$this->fields[] = $textarea;

		return $textarea;
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
	public function select($name, array $options = [], $default = NULL, array $attributes = [], $nobind = false)
	{
		if ($this->bind && !$nobind)
			$default = isset($this->bindings[$name]) ? $this->bindings[$name] : NULL;
		
		$select = new SelectField($name, $options, $default, $attributes);
		$this->fields[] = $select;

		return $select;
	}

	/**
	 * Add a file field
	 *
	 * @param string $name
	 * @param array $attributes
	 * @return InputField
	 */
	public function file($name, array $attributes = [])
	{
		$this->files = true;

		return $this->inputField(self::TYPE_FILE, $name, NULL, $attributes, [], true);		
	}

	/**
	 * Add a password field
	 *
	 * @param string $name
	 * @param array $attributes
	 * @return InputField
	 */
	public function password($name, array $attributes = [])
	{
		return $this->inputField(self::TYPE_PASSWORD, $name, NULL, $attributes);
	}

	/**
	 * Add a submit button
	 *
	 * @param string $name
	 * @param string $value
	 * @param array $attributes
	 * @return InputField
	 */
	public function submit($name, $value = NULL, array $attributes = [])
	{
		return $this->inputField('submit', $name, $value, $attributes);
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
	public function label($name, $value = NULL, array $attributes = [])
	{
		$label = new Label($name, $value, $attributes);

		$this->fields[] = $label;
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
	public function inputField($type, $name, $value = NULL, array $attributes = [], array $other = [], $nobind = false)
	{
		if ($this->bind && !$nobind)
			$value = isset($this->bindings[$name]) ? $this->bindings[$name] : NULL;

		$formfield = new InputField($type, $name, $value, $attributes, $other);
		$this->fields[] = $formfield;

		return $formfield;
	}

	/**
	 * Generate a form token
	 *
	 * @return string
	 */
	public static function token()
	{
		$token = str_random(9);
		Session::set('__formtoken', $token);

		return $token;
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
	 * Render the form
	 *
	 * @return View
	 */
	public function render()
	{
		$this->makeTokenField();
		$rendered = [];

		$attributes = $this->renderAttributes($this->attributes);
		$files = $this->files ? "enctype=\"multipart/form-data\"" : "";
		$method = "method=\"{$this->method}\"";
		$action = "action=\"{$this->action}\"";

		$fields = [];

		$formtemplate = file_exists($this->templates . 'form.lb') ? $this->templates : __DIR__.'/templates/';
		$formfieldtemplate = file_exists($this->templates . 'formfield.lb') ? $this->templates : __DIR__.'/templates/';

		foreach($this->fields as $field)
		{
			if (is_string($field))
			{
				$rendered[] = $field;
				continue;
			}

			$arr = $field->render();

			$session = &Session::get('__formerrors')[$field->getName()];

			$error = is_null(Session::get("__formerrors")) ? NULL : isset($session) ? $session : NULL;
			
			$fields[] = (new View('formfield', ['label' => $arr['label'], 'field' => $arr['field'], 'error' => $error], $formfieldtemplate))->render();
		}

		$template = new View('form', compact('method', 'action', 'files', 'attributes', 'fields'), $formtemplate);

		Session::remove('__formerrors');

		return $template;
	}

	/**
	 * String representation
	 *
	 * @return string
	 */
	public function __tostring()
	{
		return (string)$this->render();
	}

	/**
	 * Add a token field
	 *
	 * @return void
	 */
	public function makeTokenField()
	{
		$token = self::token();
		$this->inputField('hidden', '_token', $token, [], [], true);
	}
}