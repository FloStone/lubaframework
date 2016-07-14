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
	 * Delete compiled files after usage
	 *
	 * @var bool
	 */
	protected $deleteCompiled = true;

	/**
	 * Initialization
	 *
	 * @param string $template
	 * @param array $variables
	 */
	public function __construct($template, array $variables = [], $customPath = NULL, $compileVars = false)
	{
		if ($customPath)
			$template = $customPath.str_replace('.', '/', $template);
		else
			$template = view_path(str_replace('.', '/', $template));
		
		if (file_exists("$template.lb"))
			$this->template = "$template.lb";
		elseif(file_exists("$template.php"))
			$this->template = "$template.php";
		else
			throw new TemplateNotFoundException($template);

		if ($compileVars)
			$this->variables = ViewCompiler::compileVariables($variables);
		else
			$this->variables = $variables;

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

		if ($this->deleteCompiled)
			unlink($this->compiled);

		return $this->content;
	}

	public function compileTemplate()
	{
		$compiler = new ViewCompiler($this->template);
		$compiler->compile();
		$this->compiled = $compiler->tempName();
	}

	public static function keepCompiledFiles()
	{
		self::getInstance()->deleteCompiled(false);
	}

	public function deleteCompiled($bool)
	{
		$this->deleteCompiled = $bool;
	}
}