<?php

use League\CommonMark\Converter;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use Webuni\CommonMark\TableExtension\TableExtension;
use Webuni\CommonMark\AttributesExtension\AttributesExtension;

use View\Helper\BibleRef;
use Valid as Test;


/**
 * Markdown helper.
 *
 * @see http://commonmark.thephpleague.com
 */
class Markdown
{
	const EXT = '.md';


	private $_converter;
	private $_refs;


	public function __construct()
	{
		$e = Environment::createCommonMarkEnvironment();
		$e->addExtension(new AttributesExtension());
		$e->addExtension(new TableExtension());
		$this->_converter = new Converter(new DocParser($e), new HtmlRenderer($e));

		$this->_refs = new BibleRef;
	}
	
	private function render(string $markdown): string
	{
		if(Test::empty($markdown))
			return '';

		$markdown = $this->_refs->md_replace($markdown);

		return $this->_converter->convertToHtml($markdown);
	}

	private function render_file(string $path): string
	{
		return file_exists($path)
			? $this->render(file_get_contents($path))
			: false;
	}

	use \Candy\InstanceCallable;
}
