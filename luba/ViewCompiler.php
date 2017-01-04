<?php

namespace Luba\Framework;

use Luba\Exceptions\TemplateNotFoundException;

class ViewCompiler
{
	protected $template;

	protected $compiled;

	protected static $patterns = [
		'/<echo>/',			// echo open
		'/<\/echo>/',		// echo close
		'/\$(\$\w*)/',		// echo variable
		'/<if (.*)>/',		// if open
		'/<else>/',			// else
		'/<elseif(.*)>/',	// elseif
		'/<\/if>/',			// if close
		'/<php>/',			// php open
		'/<\/php>/',		// php close
		'/<foreach(.*)>/',	// foreach open
		'/<\/foreach>/',	// foreach close
		'/<continue>/',		// continue
		'/<break>/',		// break
		'/<<(.*)>>/'		// echo php
	];

	protected static $replacements = [
		'<?php echo ',				// echo open
		' ; ?>',					// echo close
		'<?= $1; ?>',				// echo variable
		'<?php if ($1): ?>',		// if open
		'<?php else: ?>',			// else
		'<?php elseif ($1): ?>',	// elseif
		'<?php endif; ?>',			// if close
		'<?php ',					// php open
		' ?>',						// php close
		'<?php foreach($1): ?>',	// foreach open
		'<?php endforeach; ?>',		// foreach close
		'<?php continue; ?>',		// continue
		'<?php break; ?>',			// break
		'<?= $1; ?>'
	];

	protected $variables = [];

	public function __construct($template, $variables = [])
	{
		$this->template = $template;
		$this->variables = [];
	}

	public function compile()
	{
		$file = file_get_contents($this->template);

		$parent = $this->getTemplateParent($file);

		if ($parent)
		{
			$parentCompiled = (new View($parent, $this->variables))->render();
			$file = $this->insertIntoParent($parentCompiled, $file);
		}

		$file = $this->getTemplateIncludes($file);

		$file = $this->replace($file);

		$filename = str_random(15);
		$path = base_path("storage/temp/$filename");

		file_put_contents($path, $file);

		$this->compiled = $path;
	}

	public function replace($file)
	{
		$file = preg_replace(self::$patterns, self::$replacements, $file);

		if (file_exists(base_path('config/compilerRules.php')))
		{
			$customRules = include base_path('config/compilerRules.php');
			$file = preg_replace($customRules['patterns'], $customRules['replacements'], $file);
		}

		return $file;
	}

	public function tempName()
	{
		return $this->compiled;
	}

	public function getTemplateParent($file)
	{
		preg_match('/<parent::\w*>/', $file, $matches);

		if (empty($matches))
			return false;

		$parent = str_replace(['<parent::', '>'], '', $matches[0]);

		return $parent;
	}

	public function insertIntoParent($parentCompiled, $file)
	{
		preg_match_all('/<insert::(\w*)>/', $parentCompiled, $matches);

		$fillables = $matches[1];

		preg_match_all('/<fill::(\w*)>(.*)<\/fill::\w*>/sU', $file, $fileMatches);

		$inserts = array_combine($fileMatches[1], $fileMatches[2]);

		foreach ($fillables as $fillable)
		{
			if (isset($inserts[$fillable]))
				$parentCompiled = str_replace("<insert::$fillable>", $inserts[$fillable], $parentCompiled);
		}

		return $parentCompiled;
	}

	public function getTemplateIncludes($file)
	{
		preg_match_all('/<include\s+(.*)>/', $file, $includes);

		$templates = $includes[1];

		foreach ($templates as $template)
		{
			$templatePath = view_path(trim(str_replace('.', '/', $template)));

			if (file_exists("$templatePath.lb"))
				$templateFile = file_get_contents("$templatePath.lb");
			else
				throw new TemplateNotFoundException($template);

            $template = str_replace("/", "\/", $template);
			$file = preg_replace("/<include\s+$template>/", $templateFile, $file);
		}

		return $file;
	}

	public static function cleanUp($view)
	{

		preg_match_all('/<insert::(\w*)>/', $view, $matches);

		foreach ($matches[0] as $match)
		{
			$view = str_replace($match, '', $view);
		}

		return $view;
	}

	public static function compileVariables(array $variables)
	{
		$compiled = [];

		foreach ($variables as $variable)
		{
			if (is_string($variable))
				$return[] = (new self(NULL))->replace($variable);
			else
				$return[] = $variable;
		}

		return $compiled;
	}
}