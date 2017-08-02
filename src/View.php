<?php
use Bitworking\Mimeparse;

/**
 * Base for view classes.
 * 
 *      View::type()->output(); // Outputs based on best match
 *      View::type()->render('text/html');
 * 
 * @see View\Mustache
 */
abstract class View
{
	use \Candy\NewChain;

	protected $_accept = [];


	/**
	 * Should render the view in the given view and return it as a string.
	 */
	public function render(string $mime): string
	{
		$accept = implode(', ', $this->_accept) ?: 'none';
		HTTP::plain_exit(406, "Acceptable types: $accept");
	}

	/**
	 * Calls render with the based mime type based on Accept header and $_accept.
	 */
	public final function render_best(): string
	{
		$best = Mimeparse::bestMatch($this->_accept, $_SERVER['HTTP_ACCEPT'] ?? '*/*');
		return $this->render($best);
	}

	/**
	 * Outputs the best view.
	 */
	public function output()
	{
		echo $this->render_best();
	}
}
