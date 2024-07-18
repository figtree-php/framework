<?php

declare(strict_types=1);

namespace FigTree\Framework\Web\Emission\Exceptions;

use Throwable;
use LogicException;

/**
 * Exception thrown when output has already been sent when attempting to emit an HTTP header.
 */
class OutputSentException extends LogicException
{
	/**
	 * Exception thrown when output has already been sent when attempting to emit an HTTP header.
	 *
	 * @param int $code The Exception code.
	 * @param \Throwable $previous The previous throwable used for the exception chaining.
	 */
	public function __construct(int $code = 0, Throwable $previous = null)
	{
		$message = 'Output already sent.';

		parent::__construct($message, $code, $previous);
	}
}
