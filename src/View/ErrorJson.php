<?php
namespace View;
use Error\HttpException;
use Error\ValidationFailed;
use Security;

/**
 * Json error response.
 * 
 * @see Error\Handler
 */
class ErrorJson extends \View\Json
{
	use \WinPathFix;

	public function __construct(HttpException $e)
	{
		$message = new \View\Helper\Messages;
		$data = [
			'status' => $e->getHttpStatus(),
			'title' => $e->getHttpTitle(),
			'message' => $message(),
		];

		if($e instanceof ValidationFailed)
			$data['errors'] = $e->errors;

		if(Security::check('admin'))
			$data['details'] = self::from_win(ErrorHtml::details($e));

		parent::__construct($data);
	}

}


