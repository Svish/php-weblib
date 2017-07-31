<?php

namespace Data;

/**
 * Base for classes computing values based on other values.
 */
abstract class Computed
{
	private $_columns;

	/**
	 * @param $columns Which columns this computed should be triggered by.
	 */
	public function __construct(string ...$columns)
	{
		$this->_columns = $columns;
	}


	/**
	 * Yields extra columns to set.
	 *
	 * @param $column The column that was set.
	 * @param $value The value it was set to.
	 */
	public final function set(string $column, $value)
	{
		if(in_array($column, $this->_columns))
			yield from $this->_set($column, $value);
	}

	/**
	 * Yields extra columns to unset.
	 *
	 * @param $column The column that was unset
	 */
	public final function unset(string $column)
	{
		if(in_array($column, $this->_columns))
			yield from $this->_unset($column);
	}


	/**
	 * @return yield $computed_column => $value
	 */
	protected abstract function _set(string $column, $value);

	/**
	 * @return yield $computed_column
	 */
	protected abstract function _unset(string $column);
}
