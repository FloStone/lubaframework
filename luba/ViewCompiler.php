<?php

namespace Luba\Framework;

class ViewCompiler
{
	protected $template;

	protected $compiled;

	protected $patterns = [
		'/<echo>/',
		'/<\/echo>/',
		'/<if(.*)>/',
		'/<\/if>/',
		'/<php>/',
		'/<\/php>/',
		'/<foreach(.*)>/',
		'/<\/foreach>/',
		'/<continue>/',
		'/<break>/'
	];

	protected $replacements = [
		'<?php echo ',
		' ; ?>',
		'<?php if ($1): ?>',
		'<?php endif; ?>',
		'<?php',
		'?>',
		'<?php foreach($1): ?>',
		'<?php endforeach; ?>',
		'<?php continue; ?>',
		'<?php break; ?>'
	];

	public function __construct($template)
	{
		$this->template = $template;
	}

	public function compile()
	{
		$file = file_get_contents($this->template);

		$file = $this->replace($file);

		$filename = str_random(15);
		$path = base_path("temp/$filename");

		file_put_contents($path, $file);

		$this->compiled = $path;
	}

	public function replace($file)
	{
		$file = preg_replace($this->patterns, $this->replacements, $file);

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
}