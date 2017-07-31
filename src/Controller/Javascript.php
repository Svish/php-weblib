<?php

namespace Controller;
use Config, HTTP, Log;
use Error\PageNotFound;

/**
 * Handles compression and serving of javascript files.
 *
 * @see https://developers.google.com/closure/compiler/docs/api-ref
 * @see https://developers.google.com/closure/compiler/docs/api-tutorial1
 * 
 * @uses Config js
 */
class Javascript extends Cached
{
	const URL = 'https://closure-compiler.appspot.com/compile';
	const EXT = '.js';

	const APP = SRC.'_js'
			.DIRECTORY_SEPARATOR;
	const LIB = __DIR__
			.DIRECTORY_SEPARATOR.'..'
			.DIRECTORY_SEPARATOR.'_js'
			.DIRECTORY_SEPARATOR;

	private $_paths;
	private $_files;


	public function __construct()
	{
		parent::__construct();
		$this->_paths = iterator_to_array(self::paths());
	}

	private static function paths()
	{
		// Add single file "bundles"
		foreach(glob(self::LIB.'*.js') as $file)
			yield basename($file) => [$file];

		foreach(glob(self::APP.'*.js') as $file)
			yield basename($file) => [$file];

		// Add and "expand" defined bundles
		foreach(Config::js()['bundles'] as $name => $files)
		{
			foreach($files as $i => $filename)
			{
				// Leave URLs
				if(self::is_remote($filename))
					continue;

				// Check in app
				$file = self::APP.$filename.self::EXT;
				if(file_exists($file))
				{
					$files[$i] = $file;
					continue;
				}

				// Check in lib
				$file = self::LIB.$filename.self::EXT;
				if(file_exists($file))
				{
					$files[$i] = $file;
					continue;
				}

				// File not found
				Log::error("'$filename.js' could not be found");
				unset($files[$i]);
			}

			if($files)
				yield $name.self::EXT => $files;
		}
	}

	public static function is_remote(string $path)
	{
		return preg_match('%^https?://%i', $path);
	}

	public function before(array &$info)
	{
		$this->_files = $this->_paths[$info['params'][1]] ?? null;

		if( ! $this->_files)
			throw new PageNotFound;

		parent::before($info);
	}



	protected function cache_valid($cached_time)
	{
		$files = array_reject($this->_files, 
			[Javascript::class, 'is_remote']);

		$files = array_map('filemtime', $files);
		$newest = array_reduce($files, 'max');
		return parent::cache_valid($cached_time)
		   and $cached_time >= $newest;
	}
	


	public function get()
	{
		header('Content-Type: text/javascript; charset=utf-8');

		// Gather contents of all input files into one string
		$js = array_map('file_get_contents', $this->_files);
		$js = implode(PHP_EOL.PHP_EOL, $js);


		// Try compile
		$params = [
			'language' => 'ECMASCRIPT6_STRICT',
			'language_out' => 'ECMASCRIPT5',
			'compilation_level' => ENV == 'dev'
				? 'WHITESPACE_ONLY'
				: 'SIMPLE_OPTIMIZATIONS',
			'output_format' => 'text',
			'output_info' => 'compiled_code',
			'js_code' => $js,
		];
		$compiled = HTTP::post(self::URL, $params);


		Log::group();
		Log::trace_raw("Files:", array_map('basename', $this->_files));
		Log::trace_raw("Compilation took: {$compiled->info['total_time']}s");

		// Output if we got something
		if($compiled->header['Content-Length'] > 1)
		{
			$time = date('Y-m-d H:i:s');
			echo implode("\r\n", [
				"/**",
				" * Compiled: $time",
				" * By: ".__CLASS__,
				" * Using: ".self::URL,
				" * Took: {$compiled->info['total_time']}",
				" */",
				$compiled->content,
				]);
		}
		// Otherwise, get helpful error (hopefully)
		else
		{
			$error = HTTP::post(self::URL, ['output_info' => 'errors'] + $params);
			http_response_code(500);
			echo implode("\r\n", [
				"/**",
				" * Javascript error",
				" * Using: ".self::URL,
				" * Took: {$compiled->info['total_time']} + {$error->info['total_time']}",
				" **",
				"",
				trim($error->content),
				" */",
				]);
			Log::error_raw("Error: ", $error->content);
			Log::trace_raw("Took: {$error->info['total_time']}s");
		}

		Log::groupEnd();
	}
}
