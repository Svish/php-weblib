<?php

/**
 * Filter out hidden files and directories.
 */
class RecursiveHiddenFilterIterator extends RecursiveFilterIterator
{
	public function accept()
	{
		return $this->getFilename()[0] !== '.';
	}
}
