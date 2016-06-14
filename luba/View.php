<?php

namespace Luba\Framework;

use Luba\Exceptions\TemplateNotFoundException;

class View
{
	/**
	 * Path to the template
	 *
	 * @var string
	 */
	protected $template;

	/**
	 * Variables passed to template
	 *
	 * @var array
	 */
	protected $variables = [];

	/**
	 * Rendered content
	 *
	 * @var string
	 */
	protected $content;

	/**
	 * Initialization
	 *
	 * @param string $template
	 * @param array $variables
	 */
	public function __construct($template, array $variables = [])
	{
		$this->template = view_path(str_replace('.', '/', $template) . '.php');
		$this->variables = $variables;

		if (!file_exists($this->template))
			throw new TemplateNotFoundException($template);

		$this->compileTemplate();
	}

	/**
	 * Create a View instance
	 *
	 * @param string $template
	 * @param array $variables
	 */
	public function make($template, array $variables = [])
	{
		return new static($template, $variables);
	}

	/**
	 * String representation
	 *
	 * @return string
	 */
	public function __tostring()
	{
		return $this->render();
	}

	public function render()
	{
		ob_start();

		extract($this->variables);
		$include = include $this->compiled;

		$this->content = ob_get_clean();

		unlink($this->compiled);

		return $this->content;
	}

	public function compileTemplate()
	{
		$compiler = new ViewCompiler($this->template);
		$compiler->compile();
		$this->compiled = $compiler->tempName();
	}
}