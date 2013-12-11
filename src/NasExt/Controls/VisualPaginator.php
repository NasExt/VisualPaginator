<?php

/**
 * This file is part of the NasExt extensions of Nette Framework
 *
 * @copyright  Copyright (c) 2009 David Grudl
 * @license    New BSD License
 * @autor Dusan Hudak (http://dusan-hudak.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

namespace NasExt\Controls;

use Nette\Application\UI\Control;
use Nette\Utils\Paginator;

/**
 * VisualPaginator for Nette
 *
 * @author David Grudl
 * @author Dusan Hudak
 */
class VisualPaginator extends Control
{

	/** @persistent */
	public $page = 1;

	/** @var array */
	public $onShowPage;

	/** @var  string */
	private $templateFile;

	/** @var Paginator */
	private $paginator;

	/** @var  bool */
	private $isAjax;


	/**
	 * @param bool $value
	 * @return VisualPaginator provides fluent interface
	 */
	public function setAjaxRequest($value = TRUE)
	{
		$this->isAjax = $value;
		return $this;
	}


	/**
	 * @param string $file
	 * @return VisualPaginator provides fluent interface
	 */
	public function setTemplateFile($file)
	{
		$this->templateFile = $file;
		return $this;
	}


	/**
	 * @return Paginator
	 */
	public function getPaginator()
	{
		if (!$this->paginator) {
			$this->paginator = new Paginator;
		}
		return $this->paginator;
	}


	/**
	 * @param int $page
	 */
	public function handleShowPage($page)
	{
		$this->onShowPage($this, $page);
	}


	/**
	 * Renders paginator.
	 * @return void
	 */
	public function render()
	{
		$paginator = $this->getPaginator();
		$page = $paginator->page;
		if ($paginator->pageCount < 2) {
			$steps = array($page);
		} else {
			$arr = range(max($paginator->firstPage, $page - 3), min($paginator->lastPage, $page + 3));
			$count = 4;
			$quotient = ($paginator->pageCount - 1) / $count;
			for ($i = 0; $i <= $count; $i++) {
				$arr[] = round($quotient * $i) + $paginator->firstPage;
			}
			sort($arr);
			$steps = array_values(array_unique($arr));
		}

		$this->template->steps = $steps;
		$this->template->paginator = $paginator;
		$this->template->isAjax = $this->isAjax;
		$this->template->handle = !empty($this->onShowPage) ? TRUE : FALSE;

		$this->template->setFile($this->getTemplateFile());
		$this->template->render();
	}


	/**
	 * Loads state informations.
	 * @param  array
	 * @return void
	 */
	public function loadState(array $params)
	{
		parent::loadState($params);
		$this->getPaginator()->page = $this->page;
	}


	/**
	 * @return string
	 */
	public function getTemplateFile()
	{
		if ($this->templateFile) {
			return $this->templateFile;
		}

		$reflection = $this->getReflection();
		$dir = dirname($reflection->getFileName());
		$name = $reflection->getShortName();
		return $dir . DIRECTORY_SEPARATOR . $name . '.latte';
	}
}
