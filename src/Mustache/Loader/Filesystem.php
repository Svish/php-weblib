<?php

namespace Mustache\Loader;
use Security, Log;


/**
 * Custom Filesystemloader.
 * 
 * - Defaults to *.ms
 * - Supports {{% ACCESS required,roles }} in templates
 * 
 * TODO: Possibly use/learn from ProductionFilesystemLoader class?
 */
class Filesystem extends \Mustache_Loader_FilesystemLoader
{
	const EXT = '.ms';
	const ACCESS_PRAGMA = '/{{%\s*ACCESS\s*((?<=\s).+)?}}/';


	public function __construct($baseDir, array $options = [])
	{
		parent::__construct($baseDir, $options + [
				'extension' => self::EXT,
			]);
	}

	/**
	 * Load the given file, and process our custom pragma.
	 */
	protected function loadFile($name)
	{
		$contents = parent::loadFile($name);

		return preg_replace_callback(self::ACCESS_PRAGMA, [$this, '_roles'], $contents);
	}


	/**
	 * Does security check on given roles.
	 * 
	 * @see Security::require
	 */
	private function _roles(array $roles): void
	{
		// Split roles into array
		$roles = $roles[1] ?? '';
		$roles = preg_split('/\s*,\s*/', $roles, null, PREG_SPLIT_NO_EMPTY);
		$roles = array_map_callbacks($roles, 'trim', 'strtolower');

		// Secure access (throws if no access)
		Security::require($roles);
	}
}
