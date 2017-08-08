<?php
namespace View;

use Error\HttpException;
use Security;
use Log;


/**
 * Html error page.
 * 
 * @see Error\Handler
 */
class ErrorHtml extends \View\Layout
{
	public function __construct(HttpException $e)
	{
		$details = self::details($e);

		return parent::__construct([
				'status' => $e->getHttpStatus(),
				'title' => $e->getHttpTitle(),
				'full' => $details,
			], 'error');
	}
	

	/**
	 * 
	 * @return string HTML debug info.
	 */
	public static function details(\Throwable $e = null)
	{
		if( ! $e)
			return null;

		// Only supply details in DEV or to admin
		if(ENV !== 'dev' AND ! Security::check('admin'))
			return null;

		Log::trace('Getting details from', isset($e->xdebug_message) ? 'XDebug' : get_class($e), '…');

		$msg = isset($e->xdebug_message)
			? '<table class="xdebug">'.$e->xdebug_message.'</table>'
			: '<pre>'
				.'<b>'.html_encode($e->getMessage()).'</b>'
				."\r\n\r\n"
				.html_encode($e->getTraceAsString())
				.'</pre>';

		return self::details($e->getPrevious()) . "\r\n\r\n\r\n\r\n" . $msg;
	}
}
