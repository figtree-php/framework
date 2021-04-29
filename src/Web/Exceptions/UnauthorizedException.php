<?php

namespace FigTree\Framework\Web\Exceptions;

use Exception;
use FigTree\Framework\Web\Exceptions\Concerns\HasStatusCode;
use FigTree\Framework\Web\Exceptions\Contracts\HttpExceptionInterface;

class UnauthorizedException extends Exception implements HttpExceptionInterface
{
	use HasStatusCode;

	/**
	 * HTTP Status Code
	 *
	 * @var int
	 */
	protected int $status = 401;

	/**
	 * HTTP Status Reason
	 *
	 * @var string
	 */
	protected string $reason = 'Unauthorized';
}
