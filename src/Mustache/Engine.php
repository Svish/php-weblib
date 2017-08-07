<?php

namespace Mustache;

use Cache\I18N as Cache;

use Mustache\Loader\CascadingFilesystemLoader as CascadingFilesystemLoader;
use Mustache_Engine as ME;


/**
 * Mustache_Engine wrapper with some defaults.
 * 
 *  - Cache enabled.
 *  - Pragma Filters enabled.
 *  - Strict Callabled enabled.
 *  - Custom Logger enabled.
 * 
 * @uses CascadingFilesystem to load templates in order.
 * @uses Filesystem to load templates.
 * @uses FilesystemPartials to load partials.
 */
class Engine extends ME
{
	/**
	 * Creates a new Mustache Engine.
	 * 
	 * @param array $templates Directories with templates.
	 * @param array|null $partials Directories with partials.
	 * @param array|array $options Any extra options.
	 */
	public function __construct(array $templates, array $partials = null, array $options = [])
	{
		if($partials)
			$options += [
				'partials_loader'
					=> new CascadingFilesystemLoader($partials),
			];

		$options += [
			'cache' => Cache::DIR . __CLASS__,
			'pragmas' => [ME::PRAGMA_FILTERS, ME::PRAGMA_ANCHORED_DOT],
			'entity_flags' => ENT_HTML5,
			'strict_callables' => true,
			'logger' => new Logger,
			'loader' => new CascadingFilesystemLoader($templates),
			];

		parent::__construct($options);
	}
}
