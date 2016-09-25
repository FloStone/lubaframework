<?php

namespace Luba\Framework;

class Redirect
{
	public function to($url, $type = 302)
	{
		return $this->redirect($url, $type);
	}

	public function external($url, $type = 302)
	{
		$url = \URL::other($url);
		
		return $this->redirect($url, $type);
	}

	public function url($url, $type = 302)
	{
		$this->getRedirectType($type);
		$url = url($url);

		return $this->redirect($url, $type);
	}

	protected function redirect($url, $type = 302)
	{
		$this->getRedirectType($type);

		header("Location: $url");
	}

	public function getRedirectType($type = 302)
	{
		if ($type == 301)
			header("HTTP/1.1 301 Moved Permanently");
	}
}