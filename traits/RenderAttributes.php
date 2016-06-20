<?php

namespace Luba\Traits;

trait RenderAttributes
{
	public function renderAttributes($attributes)
	{
		$arr = [];

		foreach ($attributes as $key => $value)
		{
			$arr[] = "$key=\"$value\"";
		}

		return implode(' ', $arr);
	}
}