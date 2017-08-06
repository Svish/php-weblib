<?php

namespace Mustache;

/**
 * For looping over associative arrays in Mustache templates
 * 
 * @see https://stackoverflow.com/a/15619309/39321
 */
class IteratorPresenter implements \IteratorAggregate
{
	private $_values = [];
	private $_callable;
	private $_ms;


	public function __construct(iterable $values, bool $recursive = false, callable $callable = null)
	{
		$this->_values = $values;
		$this->_callable = $callable;

		if($recursive)
			$this->_ms = new class extends \Mustache_Template
			{
				public function __construct() {}
				public function renderInternal(\Mustache_Context $context, $indent = ''){}
				public function isIterable($value)
				{
					return parent::isIterable($value);
				}
			};
	}


	public function getIterator()
	{
		foreach ($this->_values as $key => $val)
		{
			// Base
			$item = [
				'key'   => $key,
				'value' => $val,
			];

			// Adjustments via callable
			if($this->_callable)
				$item = $this->_callable($item);

			// More presentables if recursing
			if($this->_ms)
				if(is_array($item['value']) && ! $this->_ms->isIterable($item['value']))
					$item['value'] = new static($item['value']);

			// Add to list
			yield $item;
		}
	}


	use \Candy\PropertyInvoke;
}
