<?php

use League\CommonMark\Converter;
use League\CommonMark\DocParser;
use League\CommonMark\Environment;
use League\CommonMark\HtmlRenderer;
use Webuni\CommonMark\TableExtension\TableExtension;
use Webuni\CommonMark\AttributesExtension\AttributesExtension;
use Markdown\LinkRenderer;

use Valid as Test;


/**
 * Markdown renderer.
 *
 * @see http://commonmark.thephpleague.com
 */
class Markdown
{
	const EXT = '.md';
	private $_converter;


	public function __construct()
	{
		$e = Environment::createCommonMarkEnvironment();
		$e->addExtension(new AttributesExtension());
		$e->addExtension(new TableExtension());
		$e->addInlineRenderer('League\CommonMark\Inline\Element\Link', new LinkRenderer);

		$this->_converter = new Converter(new DocParser($e), new HtmlRenderer($e));
	}
	

	public function render(string $markdown): string
	{
		if(Test::empty($markdown))
			return '';

		return $this->_converter->convertToHtml($markdown);
	}


	public function render_file(string $path): string
	{
		return file_exists($path)
			? $this->render(file_get_contents($path))
			: false;
	}

	use \Candy\Instance;
}
