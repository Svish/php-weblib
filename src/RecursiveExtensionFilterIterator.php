<?php

/**
 * Filter accepting only files with given extensions.
 */
class RecursiveExtensionFilterIterator extends RecursiveFilterIterator
{
	private $_ext;

	public function __construct(RecursiveIterator $it, string... $extensions)
	{
		parent::__construct($it);
		$this->_ext = array_map(function($ext)
			{
				return ltrim($ext, '.');
			}, $extensions);
	}

	public function accept()
	{
		if($this->current()->isDir())
			return true;

		return in_array($this->current()->getExtension(), $this->_ext, true);
	}

	public function getChildren()
	{
		$x = parent::getChildren();
		$x->_ext = $this->_ext;
		return $x;
	}

}
