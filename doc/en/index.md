NasExt/VisualPaginator
===========================

VisualPaginator for Nette Framework.

Requirements
------------

NasExt/VisualPaginator requires PHP 5.3.2 or higher.

- [Nette Framework](https://github.com/nette/nette)

Installation
------------

The best way to install NasExt/VisualPaginator is using  [Composer](http://getcomposer.org/):

```sh
$ composer require nasext/visual-paginator
```

## Usage

```php
class FooPresenter extends Presenter
{
	/** @var Model */
	$model;

	public function renderDefault()
	{
		$fooList = $this->model->findAll();
		$fooListCount = $fooList->count()

		/** @var NasExt\Controls\VisualPaginator $vp */
		$vp = $this['vp'];
		$paginator = $vp->getPaginator();
		$paginator->itemsPerPage = 10;
		$paginator->itemCount = $fooListCount;
		$fooList->limit($paginator->itemsPerPage, $paginator->offset);
	}


	/**
	 * @return NasExt\Controls\VisualPaginator
	 */
	protected function createComponentVp($name)
	{
		$control = new NasExt\Controls\VisualPaginator($this, $name);
		return $control;
	}
}
```

###VisualPaginator with ajax
For use VisualPaginator with ajax use setAjaxRequest() and event onShowPage[] for invalidateControl
```php
	/**
	 * @return NasExt\Controls\VisualPaginator
	 */
	protected function createComponentVp($name)
	{
		$control = new NasExt\Controls\VisualPaginator($this, $name);
		// enable ajax request, default is false
		$control->setAjaxRequest();

		$that = $this;
		$control->onShowPage[] = function ($component, $page) use ($that) {
			if($that->isAjax()){
				$that->invalidateControl();
			}
		};
		return $control;
	}
```

###Set templateFile for VisualPaginator
For set templateFile use setTemplateFile()
```php
	/**
	 * @return NasExt\Controls\VisualPaginator
	 */
	protected function createComponentVp($name)
	{
		$control = new NasExt\Controls\VisualPaginator($this, $name);
		$control->setTemplateFile('myTemplate.latte')
		return $control;
	}
```

-----

Repository [http://github.com/nasext/visualpaginator](http://github.com/nasext/visualpaginator).