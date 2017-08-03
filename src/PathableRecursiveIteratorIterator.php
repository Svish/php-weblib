<?php

class PathableRecursiveIteratorIterator extends RecursiveIteratorIterator
{
	/**
	 * Gets the path to current, i.e. each key "upwards".
	 * 
	 * @param null|string $glue Optional $glue for imploded.
	 * 
	 * @return array|string The path as an array, or as string if $glue provided.
	 */
	public function getPath(string $glue = null)
	{
		for($i = 0; $i < $this->getDepth(); $i++)
			$path[] = $this->getSubIterator($i)->key();

		$path[] = $this->key();

		return $glue !== null
			? implode($glue, $path)
			: $path;
	}
}
