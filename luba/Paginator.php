<?php

namespace Luba\Framework;

use IteratorAggregate, ArrayIterator;

class Paginator implements IteratorAggregate
{
    protected $totalcount;

	protected $totalpages;

	protected $query;

	protected $perpage;

	protected $items;

	public function __construct($query, $perpage, $modelname=null)
	{
		$count = $query->count();
		$totalpages = (int) ceil($count / $perpage);
        $this->totalcount = $count;
		$this->totalpages = $totalpages;
		$this->query = $query;
		$this->perpage = $perpage;

		$this->makeItems($modelname);
	}

	public function makeItems($modelname)
	{
		$currentpage = Input::get('page') ?: 1;
		$items = $this->query->limit($this->perpage)->offset(($currentpage - 1) * $this->perpage);
        if($modelname) {
            $this->items = $items->toModel($modelname);
        } else {
            $this->items = $items->get();
        }
	}

	public function render()
	{
		$pagearray = ["<div class=\"pagination\"><ul>"];

		if ($this->totalpages > 7)
		{
			$dots = "<li><a href=\"#\" class=\"dots\">...</a></li>";

			$current = (int) Input::get('page') ?: 1;

			if ($current < 4)
			{
				for ($i=1; $i <= 5; $i++)
				{
					$pagearray[] = $this->pagelink($i);
				}

				$pagearray[] = $dots;
				$pagearray[] = $this->pagelink($this->totalpages);
			}
			elseif ($current > $this->totalpages - 5)
			{
				$pagearray[] = $this->pagelink(1);
				$pagearray[] = $dots;

				for ($i = $this->totalpages - 5; $i <= $this->totalpages; $i++)
				{
					$pagearray[] = $this->pagelink($i);
				}
			}
			else
			{
				$pagearray[] = $this->pagelink(1);
				$pagearray[] = $dots;

				$pagearray[] = $this->pagelink($current - 1);
				$pagearray[] = $this->pagelink($current);
				$pagearray[] = $this->pagelink($current + 1);

				$pagearray[] = $dots;
				$pagearray[] = $this->pagelink($this->totalpages);
			}
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
		return $this->items;
	}

    public function getTotal()
    {
        return $this->totalcount;
    }

    public function getPages()
    {
        return $this->totalpages;
    }
}