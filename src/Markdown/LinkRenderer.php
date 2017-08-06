<?php

namespace Markdown;

use HTTP;
use View\Helper\BibleRef;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Link;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use League\CommonMark\Inline\Renderer\LinkRenderer as DefaultLinkRenderer;



/**
 * Link Renderer
 * 
 *  - Runs [](bible "Ref ") through BibleRef.
 *  - Adds rel="nofollow" to external links.
 * 
 * @see http://commonmark.thephpleague.com/customization/inline-rendering/
 */
class LinkRenderer extends DefaultLinkRenderer
{
	private $_bible;
	public function __construct()
	{
		$this->_bible = new BibleRef;
	}

	public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
	{
		$e = parent::render($inline, $htmlRenderer);

		// Bible ref links
		if($this->isBible($e->getAttribute('href')))
		{
			$ref = $e->getAttribute('title');
			$e->setAttribute('href', $this->_bible($ref));
		}

		// External links
		if($this->isExternal($e->getAttribute('href')))
		{
			$e->setAttribute('rel', 'nofollow');
		}

		return $e;
	}

	private function isBible($url)
	{
		return 'bible' == $url;
	}

	private function isExternal($url)
	{
		return ! HTTP::is_local($url);
	}


	use \Candy\PropertyInvoke;
}
