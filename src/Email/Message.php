<?php

namespace Email;
use Markdown;

class Message extends \Swift_Message
{
	public function setBodyMd(string $text): self
	{
		$html = Markdown::render($text);

		$this->setBody($html, 'text/html');
		$this->addPart($text, 'text/plain');

		return $this;
	}
}
