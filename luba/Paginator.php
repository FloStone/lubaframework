<?php

namespace Luba\Framework;

use IteratorAggregate, ArrayIterator;

class Paginator implements IteratorAggregate
{
	protected $totalpages;

	protected $query;

	protected $perpage;

	protected $items;

	public function __construct($query, $perpage)
	{
		$count = $query->count();
		$totalpages = (int) ceil($count / $perpage);
		$this->totalpages = $totalpages;
		$this->query = $query;
		$this->perpage = $perpage;

		$this->makeItems();
	}

	public function makeItems()
	{
		$currentpage = Input::get('page') ?: 1;
		$items = $this->query->limit($this->perpage)->offset(($currentpage - 1) * $this->perpage)->get();
		$this->items = $items;
	}

	public function render()
	{
		$pagearray = ["<div class=\"pagination\"><ul>"];

		if ($this->totalpages > 7)
		{

		}
		else
		{
			for ($i=1; $i <= $this->totalpages; $i++)
			{
				$pagearray[] = $this->pagelink($i);
			}
		}

		$pagearray[] = "</ul></div>";
		
		return implode(' ', $pagearray);
	}

	public function getItems()
	{
		return $this->items;
	}

	public function pagelink($number)
	{
		$active = (Input::get('page') ?: 1) == $number ? 'class="active"' : '';
		$link = url(URL::getInstance()->uri(), array_merge(URL::getInstance()->inputs(), ['page' => $number]));
		
		return "<li><a href=\"$link\" $active>$number</a></li>";
	}

	public function __tostring()
	{
		return $this->render();
	}

	public function getIterator()
	{
		return new ArrayIterator($this->items);
	}
}