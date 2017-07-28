<?php
namespace View;
use Config, Model, View;
use Mustache as Ms;
use Mustache_Exception_UnknownTemplateException as UnknownTemplate;

/**
 * Views using Mustache templates.
 */
class Mustache extends View
{
	protected $_accept = ['text/html'];

	private $_context = [];
	private $_template;



	public function __construct(array $context = [], $template = null)
	{
		$this->_context = $context;
		$this->_template = $template ?? PATH;
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

					return Ms::engine([], $this->_template)
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
			return $this->set($key, constant($key));

		// Function?
		if(Helper\PhpFunction::exists($key))
			return $this->set($key, new Helper\PhpFunction($key));

		// Helper?
		$name = __NAMESPACE__."\\Helper\\".ucfirst($key);
		if(class_exists($name))
			return $this->set($key, new $name($this));

		return false;
	}



	protected function set($key, $value)
	{
		$this->_context[$key] = $value;
		return true;
	}
}
