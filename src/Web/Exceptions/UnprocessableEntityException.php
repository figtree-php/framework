<?php

declare(strict_types=1);

namespace FigTree\Framework\Web\Exceptions;

use RuntimeException;
use FigTree\Framework\Web\Exceptions\Concerns\HasStatusCode;
use FigTree\Framework\Web\Exceptions\Contracts\HttpExceptionInterface;

class UnprocessableEntityException extends RuntimeException implements HttpExceptionInterface
{
	use HasStatusCode;

	/**
	 * HTTP Status Code
	 *
	 * @var int
	 */
	protected int $status = 422;

	/**
	 * HTTP Status Reason
	 *
	 * @var string
	 */
	protected string $reason = 'Unprocessable Entity';
}
