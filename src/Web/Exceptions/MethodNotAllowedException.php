<?php

namespace FigTree\Framework\Web\Exceptions;

use Exception;
use FigTree\Framework\Web\Exceptions\Concerns\HasStatusCode;
use FigTree\Framework\Web\Exceptions\Contracts\HttpExceptionInterface;

class MethodNotAllowedException extends Exception implements HttpExceptionInterface
{
	use HasStatusCode;

	/**
	 * HTTP Status Code
	 *
	 * @var int
	 */
	protected int $status = 405;

	/**
	 * HTTP Status Reason
	 *
	 * @var string
	 */
	protected string $reason = 'Method Not Allowed';
}
