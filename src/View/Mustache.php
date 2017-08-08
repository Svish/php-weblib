<?php
namespace View;

use Mustache as Ms;
use Mustache_Exception_UnknownTemplateException as UnknownTemplate;

use Log;


/**
 * Views using Mustache templates.
 */
class Mustache extends \View
{
	protected $_accept = ['text/html'];

	private $_context = [];
	private $_template;



	public function __construct(array $context = [], $template = null)
	{
		$this->_context = $context;
		$this->_template = $template ?? PATH;
		Log::trace(static::class, 'constructed with template', $this->_template);
	}



	public function render(string $mime): string
	{
		switch($mime)
		{
			case 'text/html':
			
				// Return rendered template
				try
				{
					if( ! headers_sent($file, $line))
						header('content-type: text/html; charset=utf-8');
					
					Log::trace('Rendering template', $this->_template);

					return Ms::engine($this->_template, [])
						->render($this->_template, $this);
				}
				catch(UnknownTemplate $e)
				{
					throw new \Error\PageNotFound(null, $e);
				}

			default:
				return parent::render($mime);
		}
	}



	public function __get($key)
	{
		return $this->_context[$key];
	}

	public function __isset($key)
	{
		// Already set?
		if(array_key_exists($key, $this->_context))
			return true;

		// Constant?
		if(defined($key))
		{
			Log::trace('Added constant', $key, '=', constant($key));
			return $this->set($key, constant($key));
		}

		// Function?
		if(Helper\PhpFunction::exists($key))
		{
			Log::trace('Added function', $key);
			return $this->set($key, new Helper\PhpFunction($key));
		}

		// Helper?
		$name = __NAMESPACE__."\\Helper\\".ucfirst($key);
		if(class_exists($name))
		{
			Log::trace('Added helper', $name);
			return $this->set($key, new $name($this));
		}
		Log::warn("Did not find '$key' in context.");
		return false;
	}



	protected function set($key, $value)
	{
		$this->_context[$key] = $value;
		return true;
	}
}
